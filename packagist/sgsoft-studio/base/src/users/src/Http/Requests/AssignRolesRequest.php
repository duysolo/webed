<?php namespace WebEd\Base\Users\Http\Requests;

use WebEd\Base\ACL\Repositories\Contracts\RoleContract;
use WebEd\Base\ACL\Repositories\RoleRepository;
use WebEd\Base\Core\Http\Requests\Request;
use WebEd\Base\Users\Models\EloquentUser;

class AssignRolesRequest extends Request
{
    /**
     * @var array
     */
    protected $roles = [];

    /**
     * @var EloquentUser
     */
    protected $loggedInUser;

    /**
     * @return bool
     */
    public function requestHasRoles()
    {
        if($this->exists('roles')) {
            $this->roles = $this->get('roles', []);
            return true;
        }
        return false;
    }

    /**
     * @return EloquentUser
     */
    public function getLoggedInUser()
    {
        return $this->loggedInUser = $this->user();
    }

    /**
     * @return bool
     */
    public function loggedInUserIsSuperAdmin()
    {
        if($this->loggedInUser->isSuperAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function loggedInUserCanAssignRoles()
    {
        if($this->loggedInUser->hasPermission('assign-roles')) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getSuperAdminRole()
    {
        /**
         * @var RoleRepository $repo
         */
        $repo = app(RoleContract::class);
        $role = $repo
            ->where('slug', '=', 'super-admin')->first();
        if(!$role) {
            return [];
        }
        return [$role->id];
    }

    /**
     * @return array
     */
    public function getResolvedRoles()
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        if(!$this->requestHasRoles()) {
            return true;
        }

        if(!$this->loggedInUserIsSuperAdmin()) {
            if(!$this->loggedInUserCanAssignRoles()) {
                return false;
            }
            /**
             * Only super admin can assign super admin
             */
            $this->roles = array_diff($this->roles, $this->getSuperAdminRole());
            return true;
        }
        /**
         * Is super admin
         */
        return true;
    }
}
