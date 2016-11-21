<?php namespace WebEd\Base\ACL\Models;

use WebEd\Base\ACL\Models\Contracts\PermissionModelContract;
use WebEd\Base\Core\Models\EloquentBase as BaseModel;

class EloquentPermission extends BaseModel implements PermissionModelContract
{
    protected $table = 'permissions';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'slug', 'module'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(EloquentRole::class, 'roles_permissions', 'permission_id', 'role_id');
    }
}
