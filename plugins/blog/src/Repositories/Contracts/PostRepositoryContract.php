<?php namespace WebEd\Plugins\Blog\Repositories\Contracts;

use WebEd\Plugins\Blog\Models\Contracts\PostModelContract;

interface PostRepositoryContract
{
    /**
     * @param array $data
     * @return array
     */
    public function createPost($data);

    /**
     * @param $id
     * @param $data
     * @param bool $allowCreateNew
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function updatePost($id, $data, $allowCreateNew = false, $justUpdateSomeFields = true);

    /**
     * @param PostModelContract $model
     * @param array $categories
     */
    public function syncCategories($model, $categories = null);

    /**
     * @param array $categoryIds
     * @return $this
     */
    public function whereBelongsToCategories(array $categoryIds);
}
