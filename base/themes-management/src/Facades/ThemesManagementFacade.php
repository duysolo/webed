<?php namespace WebEd\Base\ThemesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\ThemesManagement\Support\ThemesManagement;

class ThemesManagementFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemesManagement::class;
    }
}
