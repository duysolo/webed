<?php

if (!function_exists('split_files_with_basename')) {
    /**
     * @param array $files
     */
    function split_files_with_basename(array $files, $suffix = '.php')
    {
        $result = [];
        foreach ($files as $row) {
            $baseName = basename($row, $suffix);
            $result[$baseName] = $row;
        }
        return $result;
    }
}

if (!function_exists('scan_folder')) {
    /**
     * @param $path
     * @return array
     */
    function scan_folder($path)
    {
        if (is_dir($path)) {
            return array_diff(scandir($path), ['.', '..']);
        }
        return [];
    }
}

if (!function_exists('get_folders_in_path')) {
    /**
     * @param $path
     * @return array
     */
    function get_folders_in_path($path)
    {
        if (!File::exists($path)) {
            return [];
        }
        return File::directories($path);
    }
}

if (!function_exists('get_base_folder')) {
    /**
     * @param $path
     * @return string
     */
    function get_base_folder($path)
    {
        if (is_dir($path)) {
            return $path;
        }

        $path = dirname($path);

        if (!ends_with('/', $path)) {
            $path .= '/';
        }

        return $path;
    }
}

if (!function_exists('get_file_name')) {
    /**
     * @param string $path
     * @param null|string $withSuffix
     * @return string
     */
    function get_file_name($path, $suffix = null)
    {
        if (is_dir($path)) {
            return '';
        }

        $path = basename($path);

        if ($suffix === null) {
            return $path;
        }

        return str_replace($suffix, '', $path);
    }
}

if (!function_exists('get_file_data')) {
    /**
     * @param string $path
     * @return string
     */
    function get_file_data($path)
    {
        if (!File::exists($path) || !File::isFile($path)) {
            return null;
        }

        return File::get($path, true);
    }
}
