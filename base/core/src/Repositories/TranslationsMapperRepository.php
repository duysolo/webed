<?php namespace WebEd\Base\Core\Repositories;

use WebEd\Base\Core\Repositories\Contracts\TranslationsMapperContract;
use WebEd\Base\Caching\Services\Contracts\CacheableContract;

class TranslationsMapperRepository extends AbstractBaseRepository implements TranslationsMapperContract, CacheableContract
{
    protected $rules = [
        'language_id' => 'required|integer',
        'map_from_id' => 'required|integer',
        'map_to_id' => 'required|integer',
        'map_class' => 'required',
    ];

    protected $editableFields = [
        'language_id',
        'map_from_id',
        'map_to_id',
        'map_class',
    ];
}
