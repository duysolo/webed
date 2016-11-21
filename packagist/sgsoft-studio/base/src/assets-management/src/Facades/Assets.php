<?php namespace WebEd\Base\AssetsManagement\Facades;

use Illuminate\Support\Facades\Facade;

class Assets extends Facade
{
    /**
     * @return string
     * @author sangnm <sang.nguyenminh@elinext.com>
     */
    protected static function getFacadeAccessor()
    {
        return 'assets-management';
    }
}
