<?php namespace WebEd\Plugins\CustomFields\Repositories;

use WebEd\Base\Core\Models\Contracts\BaseModelContract;
use WebEd\Base\Core\Repositories\AbstractBaseRepository;

use WebEd\Base\Caching\Services\Contracts\CacheableContract;
use WebEd\Plugins\CustomFields\Repositories\Contracts\CustomFieldContract;
use WebEd\Plugins\CustomFields\Repositories\Contracts\FieldGroupContract;
use WebEd\Plugins\CustomFields\Repositories\Contracts\FieldItemContract;

class FieldGroupRepository extends AbstractBaseRepository implements FieldGroupContract, CacheableContract
{
    protected $rules = [
        'order' => 'integer|min:0',
        'rules' => 'json|required',
        'title' => 'string|required|max:255',
        'status' => 'required|in:activated,disabled,deleted',
        'created_by' => 'integer|min:0',
        'updated_by' => 'integer|min:0',
    ];

    protected $editableFields = [
        'order',
        'rules',
        'title',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * @var \WebEd\Plugins\CustomFields\Repositories\FieldItemRepository|\WebEd\Plugins\CustomFields\Repositories\FieldItemRepositoryCacheDecorator
     */
    protected $fieldItemRepository;

    /**
     * @var \WebEd\Plugins\CustomFields\Repositories\CustomFieldRepository|\WebEd\Plugins\CustomFields\Repositories\CustomFieldRepositoryCacheDecorator
     */
    protected $customFieldRepository;

    /**
     * @param BaseModelContract $model
     */
    public function __construct(BaseModelContract $model)
    {
        parent::__construct($model);

        $this->fieldItemRepository = app()->make(FieldItemContract::class);

        $this->customFieldRepository = app()->make(CustomFieldContract::class);
    }

    /**
     * @param int $groupId
     * @param null $parentId
     * @return mixed
     */
    public function getGroupItems($groupId, $parentId = null)
    {
        return $this->fieldItemRepository
            ->where([
                'field_group_id' => $groupId,
                'parent_id' => $parentId
            ])
            ->orderBy('order', 'ASC')
            ->get();
    }

    /**
     * @param $groupId
     * @param null|int $parentId
     * @param bool $withValue
     * @param null|string $morphClass
     * @param null|int $morphId
     * @return array
     */
    public function getFieldGroupItems($groupId, $parentId = null, $withValue = false, $morphClass = null, $morphId = null)
    {
        $result = [];

        $fieldItems = $this->getGroupItems($groupId, $parentId);

        foreach ($fieldItems as $key => $row) {

            $item = [
                'id' => $row->id,
                'title' => $row->title,
                'slug' => $row->slug,
                'instructions' => $row->instructions,
                'type' => $row->type,
                'options' => json_decode($row->options),
                'items' => $this->getFieldGroupItems($groupId, $row->id, $withValue, $morphClass, $morphId),
            ];
            if ($withValue === true) {
                if ($row->type === 'repeater') {
                    $item['value'] = $this->getRepeaterValue($item['items'], $this->getFieldItemValue($row, $morphClass, $morphId));
                } else {
                    $item['value'] = $this->getFieldItemValue($row, $morphClass, $morphId);
                }
            }

            $result[] = $item;
        }

        return $result;
    }

    private function getFieldItemValue($fieldItem, $morphClass, $morphId)
    {
        if (is_object($morphClass)) {
            $morphClass = get_class($morphClass);
        }

        $field = $this->customFieldRepository
            ->where([
                'use_for' => $morphClass,
                'use_for_id' => $morphId,
                'field_item_id' => $fieldItem->id,
                //'slug' => $fieldItem->slug,
            ])->first();

        return ($field) ? $field->value : null;
    }

    private function getRepeaterValue($items, $data)
    {
        if (!$items) {
            return null;
        }
        $data = ($data) ?: [];
        if (!is_array($data)) {
            $data = json_decode($data, true);
        }
        $result = [];
        foreach ($data as $key => $row) {
            $cloned = $items;
            foreach ($cloned as $keyItem => $item) {
                foreach ($row as $currentData) {
                    if ((int)$item['id'] === (int)$currentData['field_item_id']) {
                        if ($item['type'] === 'repeater') {
                            $item['value'] = $this->getRepeaterValue($item['items'], $currentData['value']);
                        } else {
                            $item['value'] = $currentData['value'];
                        }
                        $cloned[$keyItem] = $item;
                    }
                }
            }
            $result[$key] = $cloned;
        }
        return $result;
    }

    /**
     * @param array $data
     * @param bool $withEvent
     * @return array
     */
    public function createFieldGroup(array $data)
    {
        $result = $this->editWithValidate(0, array_merge($data, [
            'created_by' => $data['updated_by'],
            'updated_by' => $data['updated_by'],
        ]), true, false);

        if ($result['error']) {
            return $this->setMessages($result['messages'], true, $this::ERROR_CODE);
        }
        $object = $result['data'];

        if (isset($data['group_items'])) {
            $this->editGroupItems(json_decode($data['group_items'], true), $object->id);
        }

        return $this->setMessages('Field group updated successfully', false, $this::SUCCESS_CODE, $object);
    }

    /**
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateFieldGroup($id, array $data)
    {
        $result = $this->editWithValidate($id, [
            'rules' => $data['rules'],
            'title' => $data['title'],
            'status' => $data['status'],
            'updated_by' => $data['updated_by'],
        ], false, true);

        if ($result['error']) {
            return $this->setMessages($result['messages'], true, $this::ERROR_CODE);
        }
        $object = $result['data'];

        if (array_get($data, 'deleted_items')) {
            $this->deleteGroupItems(json_decode($data['deleted_items'], true));
        }

        if (array_get($data, 'group_items')) {
            $this->editGroupItems(json_decode($data['group_items'], true), $id);
        }

        return $this->setMessages('Field group updated successfully', false, $this::SUCCESS_CODE, $object);
    }

    /**
     * @param int|array $id
     * @return mixed
     */
    public function deleteFieldGroup($id)
    {
        $result = $this->delete($id);

        return $result;
    }

    /**
     * @param array $items
     * @param int $groupId
     * @param int|null $parentId
     */
    private function editGroupItems($items, $groupId, $parentId = null)
    {
        $position = 0;
        $items = (array)$items;
        foreach ($items as $key => $row) {
            $position++;

            $id = (int)$row['id'];

            $data = [
                'field_group_id' => $groupId,
                'parent_id' => $parentId,
                'title' => $row['title'],
                'order' => $position,
                'type' => $row['type'],
                'options' => json_encode($row['options']),
                'instructions' => $row['instructions'],
                'slug' => (str_slug($row['slug'], '_')) ?: str_slug($row['title'], '_'),
            ];

            $result = $this->fieldItemRepository->updateFieldItem($id, $data);

            if (!$result['error']) {
                $this->editGroupItems($row['items'], $groupId, (int)$result['data']->id);
            }
        }
    }

    /**
     * @param array|int $items
     */
    private function deleteGroupItems($items)
    {
        return $this->fieldItemRepository->delete((array)$items);
    }
}
