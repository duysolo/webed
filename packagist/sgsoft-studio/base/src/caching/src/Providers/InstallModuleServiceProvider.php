<?php namespace WebEd\Base\Caching\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\Caching';

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
            ->registerPermission('View cache management page', 'view-cache', $this->module)
            ->registerPermission('Modify cache', 'modify-cache', $this->module)
            ->registerPermission('Clear cache', 'clear-cache', $this->module);
    }
}
