<?php namespace WebEd\Base\Users\Models\Contracts;

interface UserModelContract
{
    /**
     * Get user avatar
     * @use static->resolved_avatar
     * @return mixed|string
     */
    public function getResolvedAvatarAttribute($default = null);

    /**
     * Hash the password before save to database
     * @param $value
     */
    public function setPasswordAttribute($value);
}
