<?php namespace WebEd\Base\Menu\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\Menu\Support\MenuManagement;

class MenuManagementFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MenuManagement::class;
    }
}
