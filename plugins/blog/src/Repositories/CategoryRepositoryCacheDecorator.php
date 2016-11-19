<?php namespace WebEd\Plugins\Blog\Repositories;

use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;

use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

class CategoryRepositoryCacheDecorator extends AbstractRepositoryCacheDecorator  implements CategoryRepositoryContract
{
    /**
     * @param $data
     * @return array
     */
    public function createCategory(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param $data
     * @return array
     */
    public function updateCategory($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param bool $justId
     * @return array
     */
    public function getChildren($id, $justId = true)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param array $result
     * @return array|null
     */
    public function getAllRelatedChildrenIds($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
