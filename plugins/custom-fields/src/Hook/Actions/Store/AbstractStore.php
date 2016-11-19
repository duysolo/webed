<?php namespace WebEd\Plugins\CustomFields\Hook\Actions\Store;

use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;
use WebEd\Base\Core\Http\Controllers\BaseAdminController;
use WebEd\Base\Core\Models\Contracts\BaseModelContract;
use WebEd\Base\Core\Repositories\AbstractBaseRepository;
use WebEd\Plugins\CustomFields\Models\EloquentCustomField;
use WebEd\Plugins\CustomFields\Repositories\Contracts\CustomFieldContract;
use WebEd\Plugins\CustomFields\Repositories\Contracts\FieldGroupContract;
use WebEd\Plugins\CustomFields\Repositories\Contracts\FieldItemContract;
use WebEd\Plugins\CustomFields\Repositories\CustomFieldRepository;
use WebEd\Plugins\CustomFields\Repositories\FieldGroupRepository;
use WebEd\Plugins\CustomFields\Repositories\FieldItemRepository;

abstract class AbstractStore
{
    /**
     * @var AbstractBaseRepository
     */
    protected $repository;

    /**
     * @var CustomFieldRepository
     */
    protected $customFieldRepository;

    /**
     * @var FieldGroupRepository
     */
    protected $fieldGroupRepository;

    /**
     * @var FieldItemRepository
     */
    protected $fieldItemRepository;

    /**
     * Determine if the related modules enabled
     * @var bool
     */
    protected $moduleEnabled = false;

    /**
     * @var array|\Illuminate\Http\Request|string
     */
    protected $request;

    /**
     * @var string
     */
    protected $repositoryInterface = '';

    public function __construct()
    {
        if (interface_exists($this->repositoryInterface)) {
            $this->moduleEnabled = true;

            $this->repository = app($this->repositoryInterface);

            $this->customFieldRepository = app(CustomFieldContract::class);
            $this->fieldGroupRepository = app(FieldGroupContract::class);
            $this->fieldItemRepository = app(FieldItemContract::class);

            $this->request = request();
        }
    }

    /**
     * @param \WebEd\Base\Core\Models\EloquentBase $model
     * @return $this
     */
    public function setCustomFieldRelationship($model)
    {
        return $model->morphMany(EloquentCustomField::class, 'useCustomFields', 'use_for', 'use_for_id');
    }

    /**
     * @param BaseModelContract|int $owner
     * @param array $data
     */
    public function saveCustomFields($owner, array $data)
    {
        if (!$owner instanceof BaseModelContract) {
            $owner = $this->repository->find($owner);
        }

        if (!$owner) {
            return;
        }

        foreach ($data as $key => $row) {
            $this->saveCustomField($owner, $row, false);
        }

        $this->flushCache();
    }

    /**
     * Save custom field
     * @param int|BaseModelContract $owner
     * @param $data
     * @param bool $flushCache
     */
    public function saveCustomField($owner, $data, $flushCache = true)
    {
        if (!$owner instanceof BaseModelContract) {
            $owner = $this->find($owner);
        }

        if (!$owner) {
            return;
        }

        $class = $this->customFieldRepository->getModel()->getMorphClass();

        $this->setCustomFieldRelationship($owner);

        $currentMeta = $this->setCustomFieldRelationship($owner)
            ->where([
                'field_item_id' => $data->id,
                'slug' => $data->slug,
            ])
            ->first();

        $value = $this->parseFieldValue($data);

        if (!is_string($value)) {
            $value = json_encode($value);
        }

        $isOK = false;

        if ($currentMeta) {
            $result = $this->customFieldRepository->editWithValidate($currentMeta, [
                'type' => $data->type,
                'value' => $value,
            ], false, true);
            if ($result['error']) {
                return;
            }
            $isOK = true;
        } else {
            $meta = new $class;
            $meta->field_item_id = $data->id;
            $meta->slug = $data->slug;
            $meta->type = $data->type;
            $meta->value = $value;

            try {
                $this->setCustomFieldRelationship($owner)
                    ->save($meta);
                $isOK = true;
            } catch (\Exception $exception) {

            }
        }

        if ($flushCache && $isOK === true) {
            $this->flushCache();
        }
    }

    /**
     * Get field value
     * @param $field
     * @return array|string
     */
    private function parseFieldValue($field)
    {
        switch ($field->type) {
            case 'repeater':
                if (!isset($field->value)) {
                    return [];
                }

                $value = [];
                foreach ($field->value as $row) {
                    $groups = [];
                    foreach ($row as $item) {
                        $groups[] = [
                            'field_item_id' => $item->id,
                            'type' => $item->type,
                            'slug' => $item->slug,
                            'value' => $this->parseFieldValue($item),
                        ];
                    }
                    $value[] = $groups;
                }
                return $value;
                break;
            case 'checkbox':
                $value = isset($field->value) ? (array)$field->value : [];
                break;
            default:
                $value = isset($field->value) ? $field->value : '';
                break;
        }
        return $value;
    }

    /**
     * Flush repository cache
     */
    protected function flushCache()
    {
        if ($this->customFieldRepository instanceof AbstractRepositoryCacheDecorator) {
            $this->customFieldRepository->getCacheInstance()->flushCache();
        }
        if ($this->fieldGroupRepository instanceof AbstractRepositoryCacheDecorator) {
            $this->fieldGroupRepository->getCacheInstance()->flushCache();
        }
        if ($this->fieldItemRepository instanceof AbstractRepositoryCacheDecorator) {
            $this->fieldItemRepository->getCacheInstance()->flushCache();
        }
    }

    /**
     * @param $id
     * @param array $result
     * @param BaseAdminController $controller
     */
    public function afterSaveContent($id, array $result, BaseAdminController $controller)
    {
        if ($this->moduleEnabled !== true) {
            return;
        }

        /**
         * Plugin Pages enabled
         */
        if (!array_get($result, 'error', false) && $this->request->has('custom_fields')) {
            $customFieldsData = parse_custom_fields_raw_data($this->request->get('custom_fields', []));

            if (!$customFieldsData) {
                return;
            }

            /**
             * Get object from result
             */
            $object = array_get($result, 'data', null);

            /**
             * Has custom fields
             */
            if ($customFieldsData && $object) {
                try {
                    /**
                     * Begin save custom fields
                     */
                    $this->saveCustomFields($object, $customFieldsData);
                    \FlashMessages::addMessages('Related custom fields updated', 'success');
                } catch (\Exception $exception) {
                    \FlashMessages::addMessages($exception->getMessage(), 'error');
                }
            }
        }
    }
}
