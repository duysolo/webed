<?php

if (!function_exists('get_categories')) {
    /**
     * @param array $options
     * @return array
     */
    function get_categories($parentId = null)
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
            $category->child_cats = get_categories($category->id);
            $result[] = $category;
        }

        return $result;
    }
}

if (!function_exists('categories_with_indent_text')) {
    /**
     * @param array $categories
     * @param int $dept
     * @return array
     */
    function categories_with_indent_text(array $categories, $dept = 0)
    {
        $indentText = '';
        for ($i = 0; $i < $dept; $i++) {
            $indentText .= '——';
        }

        $result = [];

        foreach ($categories as $category) {
            $category->indent_text = $indentText;
            $category->child_cats = categories_with_indent_text($category->child_cats, $dept + 1);
            $result[] = $category;
        }

        return $result;
    }
}

if (!function_exists('collect_all_categories_to_one_array')) {

    function collect_all_categories_to_one_array(array $categories, &$result = [])
    {
        foreach ($categories as $category) {
            $result[] = $category;
            collect_all_categories_to_one_array($category->child_cats, $result);
            unset($category->child_cats);
        }
        return $result;
    }
}
