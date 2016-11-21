<?php namespace WebEd\Base\Settings\Support\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\Settings\Support\CmsSettings;

class CmsSettingsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CmsSettings::class;
    }
}
