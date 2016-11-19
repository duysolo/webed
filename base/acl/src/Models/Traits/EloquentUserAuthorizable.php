<?php namespace WebEd\Base\ACL\Models\Traits;

trait EloquentUserAuthorizable
{
    /**
     * Set relationship
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(\WebEd\Base\ACL\Models\EloquentRole::class, 'users_roles', 'user_id', 'role_id');
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        $role = $this->roles()->where('slug', '=', 'super-admin')->count();
        return $role ? true : false;
    }

    /**
     * @param $roles
     * @return bool
     */
    public function hasRole($roles)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        $relatedRoles = $this->roles()->whereIn('slug', (array)$roles)->count();
        if ($relatedRoles > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param string|array $permissions
     * @return bool
     */
    public function hasPermission($permissions)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $count = static::join('users_roles', 'users_roles.user_id', '=', $this->getTable() . '.id')
            ->join('roles', 'users_roles.role_id', '=', 'roles.id')
            ->join('roles_permissions', 'roles_permissions.role_id', '=', 'roles.id')
            ->join('permissions', 'roles_permissions.permission_id', '=', 'permissions.id')
            ->where('users.id', '=', $this->id)
            ->whereIn('permissions.slug', (array)$permissions)
            ->distinct()
            ->groupBy('permissions.id')
            ->select('permissions.id')
            ->get()->count();

        if ($count) {
            return true;
        }

        return false;
    }
}
