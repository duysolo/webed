<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\ThemesManagement';

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
            ->registerPermission('View themes', 'view-themes', $this->module)
            ->registerPermission('Add theme', 'add-themes', $this->module)
            ->registerPermission('Edit theme', 'edit-themes', $this->module)
            ->registerPermission('Remove theme', 'remove-themes', $this->module);
    }
}
