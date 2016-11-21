<?php

if (!function_exists('webed_themes_path')) {
    /**
     * @param string $path
     * @return string
     */
    function webed_themes_path($path = '')
    {
        return base_path('themes') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('get_all_theme_information')) {
    /**
     * @return array
     */
    function get_all_theme_information()
    {
        $modulesArr = [];
        $modules = get_folders_in_path(base_path('themes'));

        foreach ($modules as $row) {
            $file = $row . '/module.json';
            $data = json_decode(get_file_data($file), true);
            if ($data === null || !is_array($data)) {
                continue;
            }

            $modulesArr[array_get($data, 'namespace')] = array_merge($data, [
                'file' => $file,
                'type' => 'theme',
            ]);
        }
        return $modulesArr;
    }
}

if (!function_exists('get_theme_information')) {
    /**
     * @param $alias
     * @return mixed
     */
    function get_theme_information($alias)
    {
        return collect(get_all_theme_information())
            ->where('alias', '=', $alias)
            ->first();
    }
}

if (!function_exists('theme_exists')) {
    /**
     * @param $alias
     * @return mixed
     */
    function theme_exists($alias)
    {
        return !!collect(get_all_theme_information())
            ->where('alias', '=', $alias)
            ->first();
    }
}

if (!function_exists('save_theme_information')) {
    /**
     * @param $alias
     * @param array $data
     * @return bool
     */
    function save_theme_information($alias, array $data)
    {
        $module = is_array($alias) ? $alias : get_theme_information($alias);
        if (!$module) {
            return false;
        }
        $editableFields = [
            'name', 'author', 'description', 'image', 'version', 'installed',
        ];

        $count = 0;
        foreach ($data as $key => $item) {
            if (in_array($key, $editableFields)) {
                $module[$key] = $item;
                $count++;
            }
        }
        if (\File::exists(array_get($module, 'file'))) {
            $file = $module['file'];
            unset($module['file']);
            if (array_key_exists('type', $module)) {
                unset($module['type']);
            }
            \File::put($file, json_encode_pretify($module));
        }

        if ($count > 0) {
            return true;
        }
        return false;
    }
}

if (!function_exists('is_theme_activated')) {
    /**
     * @param $alias
     * @return bool
     */
    function is_theme_activated($alias)
    {
        $theme = get_theme_information($alias);
        if (!$theme || !array_get($theme, 'activated')) {
            return false;
        }
        return true;
    }
}

if (!function_exists('is_theme_installed')) {
    /**
     * @param $alias
     * @return bool
     */
    function is_theme_installed($alias)
    {
        $theme = get_theme_information($alias);
        if (!$theme || !array_get($theme, 'installed')) {
            return false;
        }
        return true;
    }
}
