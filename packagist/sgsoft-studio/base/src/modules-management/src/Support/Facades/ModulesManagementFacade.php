<?php namespace WebEd\Base\ModulesManagement\Support\Facades;

use Illuminate\Support\Facades\Facade;

class ModulesManagementFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \WebEd\Base\ModulesManagement\Support\ModulesManagement::class;
    }
}
