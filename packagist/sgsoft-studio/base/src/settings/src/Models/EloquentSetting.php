<?php namespace WebEd\Base\Settings\Models;

use WebEd\Base\Core\Models\EloquentBase as BaseModel;

class EloquentSetting extends BaseModel
{
    protected $table = 'settings';

    protected $primaryKey = 'id';
}
