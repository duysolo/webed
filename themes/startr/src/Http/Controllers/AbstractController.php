<?php namespace WebEd\Themes\Startr\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseFrontController;

abstract class AbstractController extends BaseFrontController
{
    /**
     * Override some menu attributes
     *
     * @param $type
     * @param $relatedId
     * @return null|string|mixed
     */
    protected function getMenu($type, $relatedId)
    {
        $menuHtml = webed_menu_render(get_settings('top_menu', 'top-menu'), [
            'class' => 'nav navbar-nav',
            'container_class' => 'navbar-collapse collapse',
            'has_sub_class' => 'dropdown',
            'container_tag' => 'nav',
            'container_id' => 'navbar',
            'group_tag' => 'ul',
            'child_tag' => 'li',
            'submenu_class' => 'sub-menu',
            'active_class' => 'active current-menu-item',
            'menu_active' => [
                'type' => $type,
                'related_id' => $relatedId,
            ]
        ]);
        view()->share([
            'cmsMenuHtml' => $menuHtml
        ]);
        return $menuHtml;
    }
}
