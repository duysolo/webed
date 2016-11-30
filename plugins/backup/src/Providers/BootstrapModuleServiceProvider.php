<?php namespace WebEd\Plugins\Backup\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\Backup';

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
        /**
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'webed-backup',
            'piority' => 999,
            'parent_id' => 'webed-configuration',
            'heading' => null,
            'title' => 'Backup',
            'font_icon' => 'fa fa-circle-o',
            'link' => route('admin::webed-backup.index.get'),
            'css_class' => null,
        ]);
    }
}
