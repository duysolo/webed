<?php namespace WebEd\Base\Elfinder\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\Elfinder';

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
            ->registerPermission('View files', 'view-files', $this->module)
            ->registerPermission('Upload file', 'upload-files', $this->module)
            ->registerPermission('Edit file', 'edit-files', $this->module)
            ->registerPermission('Delete file', 'delete-files', $this->module);
    }
}
