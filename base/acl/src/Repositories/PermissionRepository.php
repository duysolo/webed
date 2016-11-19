<?php namespace WebEd\Base\ACL\Repositories;

use WebEd\Base\Core\Repositories\AbstractBaseRepository;

use WebEd\Base\ACL\Repositories\Contracts\PermissionContract;
use WebEd\Base\Caching\Services\Contracts\CacheableContract;

class PermissionRepository extends AbstractBaseRepository implements PermissionContract, CacheableContract
{
    protected $rules = [
        'name' => 'required|between:3,100|string',
        'slug' => 'required|between:3,100|unique:roles|alpha_dash',
        'module' => 'required|max:255',
    ];

    /**
     * Register permission
     * @param $name
     * @param $alias
     * @param $module
     * @param bool $force
     * @return array|\WebEd\Base\ACL\Repositories\PermissionRepository
     */
    public function registerPermission($name, $alias, $module, $force = true)
    {
        $permission = $this->where(['slug' => $alias])->first();
        if (!$permission) {
            $result = $this->editWithValidate(0, [
                'name' => $name,
                'slug' => str_slug($alias),
                'module' => $module,
            ], true, false);
            if (!$result['error']) {
                if (!$force) {
                    return $this->setMessages($result['messages'], false, $this::SUCCESS_NO_CONTENT_CODE);
                }
            }
            if (!$force) {
                return $this->setMessages($result['messages'], true, $this::ERROR_CODE);
            }
        }
        if (!$force) {
            return $this->setMessages('Permission alias exists', true, $this::ERROR_CODE);
        }
        return $this;
    }

    /**
     * @param string|array $alias
     * @param bool $force
     * @return array|\WebEd\Base\ACL\Repositories\PermissionRepository
     */
    public function unsetPermission($alias, $force = true)
    {
        $result = $this->where('slug', 'IN', (array)$alias)->delete();
        if (!$result['error']) {
            if (!$force) {
                return $this->setMessages($result['messages'], false, $this::SUCCESS_NO_CONTENT_CODE);
            }
        }
        if (!$force) {
            return $this->setMessages($result['messages'], true, $this::ERROR_CODE);
        }
        return $this;
    }

    /**
     * @param string|array $module
     * @param bool $force
     * @return array|\WebEd\Base\ACL\Repositories\PermissionRepository
     */
    public function unsetPermissionByModule($module, $force = true)
    {
        $result = $this->where('module', 'IN', (array)$module)->delete();
        if (!$result['error']) {
            if (!$force) {
                return $this->setMessages($result['messages'], false, $this::SUCCESS_NO_CONTENT_CODE);
            }
        }
        if (!$force) {
            return $this->setMessages($result['messages'], true, $this::ERROR_CODE);
        }
        return $this;
    }
}
