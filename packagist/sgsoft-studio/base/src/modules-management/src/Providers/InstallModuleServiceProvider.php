<?php namespace WebEd\Base\ModulesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\ModulesManagement';

    /**
     * Bootstrap any application services.
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
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        acl_permission()
            ->registerPermission('Manage modules', 'view-modules', $this->module)
            ->registerPermission('Add module', 'add-modules', $this->module)
            ->registerPermission('Edit module', 'edit-modules', $this->module)
            ->registerPermission('Remove module', 'remove-modules', $this->module);
    }
}
