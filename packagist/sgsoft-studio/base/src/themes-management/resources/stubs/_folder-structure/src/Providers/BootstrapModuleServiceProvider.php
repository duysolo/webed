<?php namespace DummyNamespace\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'DummyNamespace';

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
        /*\DashboardMenu::registerItem([
            'id' => 'DummyAlias',
            'piority' => 20,
            'parent_id' => null,
            'heading' => null,
            'title' => 'DummyName',
            'font_icon' => 'icon-puzzle',
            'link' => '',
            'css_class' => null,
        ]);*/
    }
}
