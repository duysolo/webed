<?php

use \WebEd\Base\Core\Models\Contracts\BaseModelContract;
use \WebEd\Base\Core\Models\EloquentBase;
use \WebEd\Plugins\CustomFields\Repositories\Contracts\CustomFieldContract;

if (!function_exists('get_field')) {
    /**
     * @param BaseModelContract|EloquentBase $object
     * @param null $alias
     * @return mixed|null
     */
    function get_field(BaseModelContract $object, $alias = null)
    {
        /**
         * @var \WebEd\Plugins\CustomFields\Repositories\CustomFieldRepository $customFieldRepository
         */
        $customFieldRepository = app(CustomFieldContract::class);

        $objectModelPrimaryKey = $object->getPrimaryKey();

        $field = $customFieldRepository
            ->where([
                'use_for' => get_class($object),
                'use_for_id' => $object->$objectModelPrimaryKey
            ]);
        if ($alias === null || !trim($alias)) {
            return $field->get();
        }

        $field = $field
            ->where('slug', '=', $alias)
            ->first();

        if (!$field) {
            return null;
        }

        return $field->resolved_value;
    }
}

if (!function_exists('has_field')) {
    /**
     * @param BaseModelContract $object
     * @param null $alias
     * @return bool
     */
    function has_field(BaseModelContract $object, $alias = null)
    {
        if (!get_field($object, $alias)) {
            return false;
        }
        return true;
    }
}

if (!function_exists('get_sub_field')) {
    /**
     * @param array $parentField
     * @param $alias
     * @param null $default
     * @return mixed
     */
    function get_sub_field(array $parentField, $alias, $default = null)
    {
        foreach ($parentField as $field) {
            if (array_get($field, 'slug') === $alias) {
                return array_get($field, 'value', $default);
            }
        }
        return $default;
    }
}

if (!function_exists('has_sub_field')) {
    /**
     * @param array $parentField
     * @param $alias
     * @return bool
     */
    function has_sub_field(array $parentField, $alias)
    {
        if (!get_sub_field($parentField, $alias)) {
            return false;
        }
        return true;
    }
}

