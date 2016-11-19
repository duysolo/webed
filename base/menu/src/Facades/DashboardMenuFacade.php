<?php namespace WebEd\Base\Menu\Facades;

use Illuminate\Support\Facades\Facade;

class DashboardMenuFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \WebEd\Base\Menu\Support\DashboardMenu::class;
    }
}
