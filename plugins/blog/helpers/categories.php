<?php

if (!function_exists('get_categories')) {
    /**
     * @param string $indent
     * @return array
     */
    function get_categories($indent = '——')
    {
        /**
         * @var \WebEd\Plugins\Blog\Repositories\CategoryRepository $repo
         */
        $repo = app(\WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract::class);
        $categories = $repo
            ->orderBy('order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();

        $categories = sort_categories($categories);

        foreach ($categories as $category) {
            $indentText = '';
            $depth = (int)$category->depth;
            for ($i = 0; $i < $depth; $i++) {
                $indentText .= $indent;
            }
            $category->indent_text = $indentText;
        }

        return $categories;
    }
}

if (!function_exists('sort_categories')) {
    /**
     * Sort parents before children
     * @param \Illuminate\Support\Collection|array $categories
     * @param array $result
     * @param int $parent
     * @param int $depth
     * @return array
     */
    function sort_categories($categories, array &$result = [], $parent = null, $depth = 0)
    {
        if ($categories instanceof \Illuminate\Support\Collection) {
            $categoriesArr = [];
            foreach ($categories as $category) {
                $categoriesArr[] = $category;
            }
            $categories = $categoriesArr;
        }

        foreach ($categories as $key => $object) {
            if ((int)$object->parent_id == (int)$parent) {
                array_push($result, $object);
                $object->depth = $depth;
                unset($categories[$key]);
                sort_categories($categories, $result, $object->id, $depth + 1);
            }
        }
        return $result;
    }
}

if (!function_exists('get_categories_with_children')) {
    /**
     * @param null $parentId
     * @return array
     */
    function get_categories_with_children($parentId = null)
    {
        /**
         * @var \WebEd\Plugins\Blog\Repositories\CategoryRepository $repo
         */
        $repo = app(\WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract::class);
        $categories = $repo
            ->orderBy('order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->where('parent_id', '=', $parentId)->get();

        $result = [];
        foreach ($categories as $category) {
            $category->child_cats = get_categories_with_children($category->id);
            $result[] = $category;
        }
        return $result;
    }
}
