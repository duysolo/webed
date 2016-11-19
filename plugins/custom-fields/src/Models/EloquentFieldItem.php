<?php namespace WebEd\Plugins\CustomFields\Models;

use WebEd\Base\Core\Models\EloquentBase as BaseModel;
use WebEd\Plugins\CustomFields\Models\Contracts\FieldItemContract;

class EloquentFieldItem extends BaseModel implements FieldItemContract
{
    protected $table = 'field_items';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fieldGroup()
    {
        return $this->belongsTo(EloquentFieldGroup::class, 'field_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(EloquentFieldItem::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child()
    {
        return $this->hasMany(EloquentFieldItem::class, 'parent_id');
    }
}
