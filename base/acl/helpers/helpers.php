<?php
use WebEd\Base\ACL\Repositories\Contracts\PermissionContract;

if (!function_exists('acl_permission')) {
    /**
     * Get the available cms instance.
     *
     * @return \WebEd\Base\ACL\Repositories\PermissionRepository
     */
    function acl_permission()
    {
        return app(PermissionContract::class);
    }
}
