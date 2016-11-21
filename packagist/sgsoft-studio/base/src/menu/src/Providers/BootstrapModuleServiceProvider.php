<?php namespace WebEd\Base\Menu\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\Menu';

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
            'id' => 'webed-menu',
            'piority' => 20,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Menus',
            'font_icon' => 'fa fa-bars',
            'link' => route('admin::menus.index.get'),
            'css_class' => null,
        ]);
    }
}
