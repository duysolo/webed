<?php namespace WebEd\Plugins\CustomFields\Repositories;

use WebEd\Base\Core\Repositories\AbstractBaseRepository;
use WebEd\Base\Caching\Services\Contracts\CacheableContract;

use WebEd\Plugins\CustomFields\Repositories\Contracts\CustomFieldContract;

class CustomFieldRepository extends AbstractBaseRepository implements CustomFieldContract, CacheableContract
{
    protected $rules = [
        'use_for' => 'required',
        'use_for_id' => 'required|integer',
        'parent_id' => 'integer',
        'type' => 'required|string|max:255',
        'slug' => 'required|between:3,255|alpha_dash',
        'value' => 'nullable|string',
    ];

    protected $editableFields = [
        'use_for',
        'use_for_id',
        'parent_id',
        'type',
        'slug',
        'value',
    ];
}
