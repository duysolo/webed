<?php namespace WebEd\Base\Core\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\Core\Support\DataTable\DataTables;

class DataTablesFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DataTables::class;
    }
}
