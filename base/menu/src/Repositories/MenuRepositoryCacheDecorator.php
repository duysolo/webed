<?php namespace WebEd\Base\Menu\Repositories;

use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;

use WebEd\Base\Menu\Models\Contracts\MenuModelContract;
use WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;

class MenuRepositoryCacheDecorator extends AbstractRepositoryCacheDecorator  implements MenuRepositoryContract
{
    /**
     * Create menu
     * @param $data
     * @return array
     */
    public function createMenu($data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Update menu
     * @param $id
     * @param $data
     * @param bool $allowCreateNew
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function updateMenu($id, $data, $allowCreateNew = false, $justUpdateSomeFields = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Update menu structure
     * @param $menuId
     * @param $menuStructure
     * @param array $messages
     */
    public function updateMenuStructure($menuId, $menuStructure, array &$messages)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * $messages
     * @param $menuId
     * @param $node
     * @param array $messages
     * @param null $parentId
     */
    public function updateMenuNode($menuId, $node, $order, array &$messages, $parentId = null)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Get menu
     * @param $id
     * @return mixed|null|MenuModelContract
     */
    public function getMenu($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * Get menu nodes
     * @param $menuId
     * @param null $parentId
     * @return mixed|null
     */
    public function getMenuNodes($menuId, $parentId = null)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
