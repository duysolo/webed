<?php namespace WebEd\Base\Hook\Support\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\Hook\Support\Filters;

class FiltersFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Filters::class;
    }
}
