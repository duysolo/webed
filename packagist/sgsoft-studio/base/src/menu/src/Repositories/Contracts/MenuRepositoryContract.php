<?php namespace WebEd\Base\Menu\Repositories\Contracts;

use WebEd\Base\Menu\Models\Contracts\MenuModelContract;

interface MenuRepositoryContract
{
    /**
     * Create menu
     * @param $data
     * @return array
     */
    public function createMenu($data);

    /**
     * Update menu
     * @param $id
     * @param $data
     * @param bool $allowCreateNew
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function updateMenu($id, $data, $allowCreateNew = false, $justUpdateSomeFields = false);

    /**
     * Update menu structure
     * @param $menuId
     * @param $menuStructure
     * @param array $messages
     */
    public function updateMenuStructure($menuId, $menuStructure, array &$messages);

    /**
     * $messages
     * @param $menuId
     * @param $node
     * @param array $messages
     * @param null $parentId
     */
    public function updateMenuNode($menuId, $node, $order, array &$messages, $parentId = null);

    /**
     * Get menu
     * @param $id
     * @return mixed|null|MenuModelContract
     */
    public function getMenu($id);

    /**
     * Get menu nodes
     * @param $menuId
     * @param null $parentId
     * @return mixed|null
     */
    public function getMenuNodes($menuId, $parentId = null);
}
