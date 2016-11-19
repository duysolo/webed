<?php namespace WebEd\Plugins\CustomFields\Models\Contracts;

interface FieldItemContract
{
    /**
     * @return mixed
     */
    public function fieldGroup();

    /**
     * @return mixed
     */
    public function parent();

    /**
     * @return mixed
     */
    public function child();
}
