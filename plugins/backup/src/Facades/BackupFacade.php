<?php namespace WebEd\Plugins\Backup\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Plugins\Backup\Support\Backup;

class BackupFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Backup::class;
    }
}
