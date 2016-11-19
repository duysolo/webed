<?php namespace WebEd\Plugins\Blog\Models\Contracts;

interface CategoryModelContract
{
    /**
     * @return mixed
     */
    public function posts();

    /**
     * @return mixed
     */
    public function parent();

    /**
     * @return mixed
     */
    public function children();
}
