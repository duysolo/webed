<?php namespace WebEd\Base\Menu\Models;

use WebEd\Base\Menu\Models\Contracts\MenuModelContract;
use WebEd\Base\Core\Models\EloquentBase as BaseModel;

class Menu extends BaseModel implements MenuModelContract
{
    protected $table = 'menus';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public $timestamps = false;
}
