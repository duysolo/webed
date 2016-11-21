<?php namespace WebEd\Base\Core\Models;

class EloquentTranslationsMapper extends EloquentBase
{
    protected $table = 'translations_mapper';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function translatable()
    {
        return $this->morphTo();
    }
}
