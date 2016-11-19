<?php namespace WebEd\Base\Users\Repositories;

use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;
use WebEd\Base\Users\Repositories\Contracts\UserContract;

class UserRepositoryCacheDecorator extends AbstractRepositoryCacheDecorator implements UserContract
{
    /**
     * @param \WebEd\Base\Users\Models\EloquentUser $user
     */
    public function getRoles($user)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $data
     * @param bool $withEvent
     * @return array
     */
    public function createUser(array $data, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param array $data
     * @param bool $withEvent
     * @return array
     */
    public function updateUser($id, array $data, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param \WebEd\Base\Users\Models\EloquentUser $model
     * @param \Illuminate\Database\Eloquent\Collection|array $data
     */
    public function syncRoles($model, $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
