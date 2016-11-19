<?php namespace WebEd\Plugins\Pages\Providers;

use Illuminate\Support\ServiceProvider;

class UnInstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\Pages';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    private function booted()
    {
        /**
         * Unset related permissions
         */
        acl_permission()->unsetPermissionByModule($this->module);

        $this->dropSchema();
    }

    private function dropSchema()
    {
        \Schema::dropIfExists('pages');
    }
}
