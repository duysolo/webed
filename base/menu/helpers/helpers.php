<?php

use \WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use \WebEd\Base\Menu\Repositories\MenuRepository;

if (!function_exists('webed_menu_render')) {
    /**
     * @param string $alias
     * @param array $options
     * @return null|string
     */
    function webed_menu_render($alias, array $options = [])
    {
        /**
         * @var MenuRepository $repo
         */
        $repo = app(MenuRepositoryContract::class);
        $menu = $repo->where([
            'slug' => $alias,
            'status' => 'activated',
        ])->first();

        if (!$menu) {
            return null;
        }

        $options = array_merge([
            'class' => 'nav nav-bar',
            'container_tag' => 'nav',
            'container_class' => '',
            'container_id' => '',
            'group_tag' => 'ul',
            'child_tag' => 'li',
            'has_sub_class' => 'has-children',
            'submenu_class' => 'sub-menu',
            'active_class' => 'active current-menu-item',
            'menu_active' => [
                'type' => 'custom-link',
                'related_id' => null,
            ],
        ], $options);

        $menuNodes = $repo->getMenuNodes($menu);

        return view('webed-menu::front._renderer.menu', [
            'menuNodes' => $menuNodes,
            'options' => $options,
            'container' => true,
            'isChild' => false,
        ])->render();
    }
}

if (!function_exists('is_menu_item_active')) {
    /**
     * Determine a menu item will be active or not
     * @param $node
     * @param $type
     * @param int|array $relatedId
     * @return bool
     */
    function is_menu_item_active($node, $type, $relatedId)
    {
        switch ($type) {
            case 'custom-link':
                if (request()->url() === url($node->url)) {
                    return true;
                }
                break;
            default:
                if($type === $node->type) {
                    if(is_array($relatedId)) {
                        if(in_array($node->related_id, $relatedId)) {
                            return true;
                        }
                    }
                    if ((int)$relatedId === (int)$node->related_id) {
                        return true;
                    }
                }
                break;
        }
        return false;
    }
}

if (!function_exists('parent_active_menu_item_ids')) {
    /**
     * Get all active
     * @param $node
     * @param $type
     * @param $relatedId
     * @param array $result
     * @return array
     */
    function parent_active_menu_item_ids($node, $type, $relatedId, array &$result = [])
    {
        foreach ($node->children as $child) {
            if (is_menu_item_active($child, $type, $relatedId)) {
                $result[] = (int)$node->id;
            }
            parent_active_menu_item_ids($child, $type, $relatedId, $result);
        }
        return $result;
    }
}
