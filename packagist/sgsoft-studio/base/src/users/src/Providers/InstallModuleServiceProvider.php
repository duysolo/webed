<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\Users';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        acl_permission()
            ->registerPermission('View users', 'view-users', $this->module)
            ->registerPermission('Create user', 'create-users', $this->module)
            ->registerPermission('Edit other user', 'edit-other-users', $this->module)
            ->registerPermission('Delete user', 'delete-users', $this->module)
            ->registerPermission('Assign roles', 'assign-roles', $this->module);
    }
}
