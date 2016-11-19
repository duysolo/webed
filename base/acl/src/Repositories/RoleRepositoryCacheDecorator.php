<?php namespace WebEd\Base\ACL\Repositories;

use WebEd\Base\ACL\Repositories\Contracts\RoleContract;
use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;

class RoleRepositoryCacheDecorator extends AbstractRepositoryCacheDecorator implements RoleContract
{
    /**
     * @param array|int $id
     * @param bool $withEvent
     * @return array
     */
    public function deleteRole($id, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $data
     * @param bool $withEvent
     * @return array
     */
    public function createRole($data, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $id
     * @param array $data
     * @param bool $withEvent
     * @return array
     */
    public function updateRole($id, $data, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param \WebEd\Base\ACL\Models\EloquentRole $model
     * @param \Illuminate\Database\Eloquent\Collection|array $data
     */
    public function syncPermissions($model, $data)
    {
        $result = call_user_func_array([$this->getRepository(), __FUNCTION__], func_get_args());

        $this->getCacheInstance()->flushCache();

        return $result;
    }

    /**
     * @param int|\WebEd\Base\ACL\Repositories\Contracts\RoleContract $id
     * @return array
     */
    public function getRelatedPermissions($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
