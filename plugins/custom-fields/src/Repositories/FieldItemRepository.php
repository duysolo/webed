<?php namespace WebEd\Plugins\CustomFields\Repositories;

use WebEd\Base\Core\Repositories\AbstractBaseRepository;

use WebEd\Base\Caching\Services\Contracts\CacheableContract;
use WebEd\Plugins\CustomFields\Repositories\Contracts\FieldItemContract;

class FieldItemRepository extends AbstractBaseRepository implements FieldItemContract, CacheableContract
{
    protected $rules = [
        'field_group_id' => 'required|integer|min:0',
        'parent_id' => '',
        'order' => 'integer|min:0',
        'title' => 'required|max:255',
        'slug' => 'alpha_dash|required|max:255',
        'type' => 'max:100|required',
        'instructions' => '',
        'options' => 'required|json',
    ];

    /**
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateFieldItem($id, array $data)
    {
        $data['slug'] = $this->makeUniqueSlug($id, $data['field_group_id'], $data['parent_id'], $data['slug']);
        return $this->editWithValidate($id, $data, true, true);
    }

    /**
     * @param int $id
     * @param int $fieldGroupId
     * @param int $parentId
     * @param string $slug
     * @return string
     */
    private function makeUniqueSlug($id, $fieldGroupId, $parentId, $slug)
    {
        $isExist = $this->where([
            'slug' => $slug,
            'field_group_id' => $fieldGroupId,
            'parent_id' => $parentId
        ])->first();
        if ($isExist && (int)$id != (int)$isExist->id) {
            return $slug . '_' . time();
        }
        return $slug;
    }
}
