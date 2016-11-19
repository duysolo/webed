<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Config for repositories
    |--------------------------------------------------------------------------
    */
    'repository' => [
        'enabled' => env('CACHE_REPOSITORY', true),
        /*
        |--------------------------------------------------------------------------
        | Default Cache Store
        |--------------------------------------------------------------------------
        |
        | This option controls the default cache connection that gets used while
        | using this caching library. This connection is used when another is
        | not explicitly specified when executing a given caching function.
        |
        | Supported: "apc", "array", "database", "file", "memcached", "redis"
        |
        */
        'default' => env('CACHE_DRIVER', 'file'),

        /*
        |--------------------------------------------------------------------------
        | Cache Lifetime
        |--------------------------------------------------------------------------
        |
        | Here you may specify the number of minutes that you wish the cache
        | to be remembered before it expires. If you want the cache to be
        | remembered forever, set this option to -1. 0 means disabled.
        |
        | Unit: minute
        |
        | Default: -1
        |
        */
        'lifetime' => -1,

        /*
        |--------------------------------------------------------------------------
        | Cache Keys File
        |--------------------------------------------------------------------------
        |
        | Here you may specify the cache keys file that is used only with cache
        | drivers that does not support cache tags. It is mandatory to keep
        | track of cache keys for later usage on cache flush process.
        |
        |
        */
        'store_keys' => storage_path('framework/cache/repositories-cache-keys.json'),
    ],
];
