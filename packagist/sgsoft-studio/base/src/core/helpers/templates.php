<?php

if (!function_exists('get_templates')) {
    /**
     * @param string $type
     * @return array
     */
    function get_templates($type = null)
    {
        if ($type === null) {
            return config('webed-templates');
        }
        $templates = config('webed-templates.' . $type);
        $templatesWithKeys = [];
        foreach ((array)$templates as $row) {
            $templatesWithKeys[$row] = $row;
        }
        return $templatesWithKeys;
    }
}

if (!function_exists('add_new_template')) {
    /**
     * @param $template
     * @param $type
     */
    function add_new_template($template, $type)
    {
        $currentTemplates = config('webed-templates.' . $type);
        config(['webed-templates.' . $type => array_merge((array)$currentTemplates, (array)$template)]);
    }
}
