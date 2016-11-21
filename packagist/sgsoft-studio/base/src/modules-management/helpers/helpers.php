<?php

if (!function_exists('webed_plugins_path')) {
    /**
     * @param string $path
     * @return string
     */
    function webed_plugins_path($path = '')
    {
        return base_path('plugins') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('webed_base_path')) {
    /**
     * @param string $path
     * @return string
     */
    function webed_base_path($path = '')
    {
        return base_path('base') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('get_base_vendor_modules_information')) {
    /**
     * @return array
     */
    function get_base_vendor_modules_information()
    {
        $modules = get_folders_in_path(base_path('vendor/sgsoft-studio/base/src'));
        $modulesArr = [];
        foreach ($modules as $row) {
            $file = $row . '/module.json';
            $data = json_decode(get_file_data($file), true);
            if ($data === null || !is_array($data)) {
                continue;
            }

            $modulesArr[array_get($data, 'namespace')] = array_merge($data, [
                'file' => $file,
                'type' => 'base',
            ]);
        }
        return $modulesArr;
    }
}

if (!function_exists('get_all_module_information')) {
    /**
     * @return array
     */
    function get_all_module_information()
    {
        $modulesArr = [];
        foreach (['base', 'plugins'] as $type) {
            $modules = get_folders_in_path(base_path($type));

            foreach ($modules as $row) {
                $file = $row . '/module.json';
                $data = json_decode(get_file_data($file), true);
                if ($data === null || !is_array($data)) {
                    continue;
                }

                $modulesArr[array_get($data, 'namespace')] = array_merge($data, [
                    'file' => $file,
                    'type' => $type,
                ]);
            }
        }
        return array_merge(get_base_vendor_modules_information(), $modulesArr);
    }
}

if (!function_exists('get_module_information')) {
    /**
     * @param $alias
     * @return mixed
     */
    function get_module_information($alias)
    {
        return collect(get_all_module_information())
            ->where('alias', '=', $alias)
            ->first();
    }
}

if (!function_exists('get_modules_by_type')) {
    /**
     * @param $type
     * @return mixed
     */
    function get_modules_by_type($type)
    {
        return collect(get_all_module_information())
            ->where('type', '=', $type);
    }
}

if (!function_exists('save_module_information')) {
    /**
     * @param $alias
     * @param array $data
     * @return bool
     */
    function save_module_information($alias, array $data)
    {
        $module = is_array($alias) ? $alias : get_module_information($alias);
        if (!$module) {
            return false;
        }
        $editableFields = [
            'name', 'author', 'description', 'image', 'version', 'enabled', 'installed'
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
