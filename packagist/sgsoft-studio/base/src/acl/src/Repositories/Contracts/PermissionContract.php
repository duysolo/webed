<?php namespace WebEd\Base\ACL\Repositories\Contracts;

interface PermissionContract
{
    /**
     * Register permission
     * @param $name
     * @param $alias
     * @param $module
     * @param bool $force
     * @return array|\WebEd\Base\ACL\Repositories\PermissionRepository
     */
    public function registerPermission($name, $alias, $module, $force = true);

    /**
     * @param string|array $alias
     * @param bool $force
     * @return array|\WebEd\Base\ACL\Repositories\PermissionRepository
     */
    public function unsetPermission($alias, $force = true);

    /**
     * @param string|array $module
     * @param bool $force
     * @return array|\WebEd\Base\ACL\Repositories\PermissionRepository
     */
    public function unsetPermissionByModule($module, $force = true);
}
