<?php namespace WebEd\Plugins\Blog\Repositories\Contracts;

interface CategoryRepositoryContract
{
    /**
     * @param $data
     * @return array
     */
    public function createCategory(array $data);

    /**
     * @param $id
     * @param $data
     * @return array
     */
    public function updateCategory($id, array $data);

    /**
     * @param $id
     * @param bool $justId
     * @return array
     */
    public function getChildren($id, $justId = true);

    /**
     * @param $id
     * @return array|null
     */
    public function getAllRelatedChildrenIds($id);
}
