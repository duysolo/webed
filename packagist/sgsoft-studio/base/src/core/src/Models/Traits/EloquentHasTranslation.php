<?php namespace WebEd\Base\Core\Models\Traits;

use WebEd\Base\Core\Models\EloquentTranslationsMapper;

trait EloquentHasTranslation
{
    /**
     * @return mixed
     */
    public function translations()
    {
        return $this->morphMany(EloquentTranslationsMapper::class, 'translatable', 'map_class', 'map_to_id');
    }
}
