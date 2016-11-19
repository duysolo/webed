<?php namespace WebEd\Base\Settings\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\Settings';

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
            'id' => 'webed-settings',
            'piority' => 1,
            'parent_id' => 'webed-configuration',
            'heading' => null,
            'title' => 'Settings',
            'font_icon' => 'fa fa-circle-o',
            'link' => route('admin::settings.index.get'),
            'css_class' => null,
        ]);
    }
}
