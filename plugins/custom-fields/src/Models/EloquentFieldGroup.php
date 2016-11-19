<?php namespace WebEd\Plugins\CustomFields\Models;

use WebEd\Base\Core\Models\EloquentBase as BaseModel;
use WebEd\Plugins\CustomFields\Models\Contracts\FieldGroupContract;

class EloquentFieldGroup extends BaseModel implements FieldGroupContract
{
    protected $table = 'field_groups';

    protected $primaryKey = 'id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fieldItems()
    {
        return $this->hasMany(EloquentFieldItem::class, 'field_group_id');
    }
}
