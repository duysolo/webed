<?php

if (!function_exists('get_image')) {
    /**
     * @param $fields
     * @param $updateTo
     */
    function get_image($image, $default)
    {
        if (!$image || !trim($image)) {
            return $default;
        }
        return $image;
    }
}

if (!function_exists('convert_timestamp_format')) {
    /**
     * @param $dateTime
     * @param $format
     * @return string
     */
    function convert_timestamp_format($dateTime, $format = 'Y-m-d H:i:s')
    {
        if ($dateTime == '0000-00-00 00:00:00') {
            return null;
        }
        $date = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateTime);
        return $date->format($format);
    }
}

if (!function_exists('json_encode_pretify')) {
    /**
     * @param array $files
     */
    function json_encode_pretify($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('save_file_data')) {
    /**
     * @param string $path
     * @param string|array|object $data
     * @param bool $json
     * @return bool
     */
    function save_file_data($path, $data, $jsonFormat = false)
    {
        try {
            if ($jsonFormat === true) {
                $data = json_encode_pretify($data);
            }
            \File::put($path, $data);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
