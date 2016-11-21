<?php

if (!function_exists('response_with_messages')) {
    /**
     * @param string|array $messages
     * @param bool $error
     * @param int $responseCode
     * @param array $data
     * @return array
     */
    function response_with_messages($messages, $error = false, $responseCode = null, $data = null)
    {
        return [
            'error' => $error,
            'response_code' => $responseCode ?: 200,
            'messages' => (array)$messages,
            'data' => $data
        ];
    }
}
