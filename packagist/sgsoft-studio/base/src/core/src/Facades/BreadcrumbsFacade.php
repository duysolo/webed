<?php namespace WebEd\Base\Core\Facades;

use Illuminate\Support\Facades\Facade;

class BreadcrumbsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \WebEd\Base\Core\Support\Breadcrumbs::class;
    }
}
