<?php namespace WebEd\Base\Users\Models;

use WebEd\Base\Users\Models\Contracts\UserModelContract;
use WebEd\Base\Core\Models\EloquentBase as BaseModel;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use \WebEd\Base\ACL\Models\Traits\EloquentUserAuthorizable;

class EloquentUser extends BaseModel implements UserModelContract, AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    use EloquentUserAuthorizable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = ['username', 'email', 'first_name', 'last_name', 'display_name', 'password', 'sex', 'status', 'phone', 'mobile_phone', 'avatar'];

    /**
     * Get user avatar
     * @use static->resolved_avatar
     * @return mixed|string
     */
    public function getResolvedAvatarAttribute($default = null)
    {
        if (isset($this->avatar) && isset($this->sex)) {
            $defaultAvt = ($default) ? $default : '/admin/images/no-avatar-' . $this->sex . '.jpg';
            return get_image($this->avatar, $defaultAvt);
        }
        if ($default) {
            return $default;
        }
        return '/admin/images/no-avatar-other.jpg';
    }

    /**
     * Hash the password before save to database
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
