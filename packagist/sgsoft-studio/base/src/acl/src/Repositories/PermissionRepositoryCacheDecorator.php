<?php namespace WebEd\Base\ACL\Repositories;

use WebEd\Base\ACL\Repositories\Contracts\PermissionContract;
use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;

class PermissionRepositoryCacheDecorator extends AbstractRepositoryCacheDecorator implements PermissionContract
{
    /**
     * Register permission
     * @param $name
     * @param $alias
     * @param $module
     * @param bool $withEvent
     * @param bool $force
     * @return array|\WebEd\Base\ACL\Repositories\PermissionRepository
     */
    public function registerPermission($name, $alias, $module, $withEvent = true, $force = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param string|array $alias
     * @param bool $withEvent
     * @param bool $force
     * @return array|\WebEd\Base\ACL\Repositories\PermissionRepository
     */
    public function unsetPermission($alias, $withEvent = true, $force = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param string|array $module
     * @param bool $withEvent
     * @param bool $force
     * @return array|\WebEd\Base\ACL\Repositories\PermissionRepository
     */
    public function unsetPermissionByModule($module, $withEvent = true, $force = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
