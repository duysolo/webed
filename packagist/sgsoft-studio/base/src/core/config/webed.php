<?php

/**
 * Global config for WebEd
 * @author Tedozi Manson <duyphan.developer@gmail.com>
 */
return [
    /**
     * Admin route slug
     */
    'admin_route' => env('WEBED_ADMIN_ROUTE', 'admincp'),

    /**
     * Recaptcha
     */
    'recaptcha' => [
        'site_key' => env('WEBED_RECAPTCHA_SITE_KEY'),
        'secret_key' => env('WEBED_RECAPTCHA_SECRET_KEY'),
    ],
];
