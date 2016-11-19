<?php namespace WebEd\Plugins\CustomFields\Support\Facades;

use Illuminate\Support\Facades\Facade;

class CustomFieldRules extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \WebEd\Plugins\CustomFields\Support\CustomFieldRules::class;
    }
}
