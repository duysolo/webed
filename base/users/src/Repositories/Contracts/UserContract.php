<?php namespace WebEd\Base\Users\Repositories\Contracts;

interface UserContract
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createUser(array $data);

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function updateUser($id, array $data);

    /**
     * @param mixed $model
     * @param \Illuminate\Database\Eloquent\Collection|array $data
     */
    public function syncRoles($model, $data);

    /**
     * @param $user
     * @return mixed
     */
    public function getRoles($user);
}
