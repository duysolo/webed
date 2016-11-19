<?php namespace WebEd\Base\ModulesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
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
        \DashboardMenu::registerItem([
            'id' => 'webed-core-modules',
            'piority' => 1000,
            'parent_id' => null,
            'heading' => 'Our extensions',
            'title' => 'Core modules',
            'font_icon' => 'icon-puzzle',
            'link' => route('admin::core-modules.index.get'),
            'css_class' => null,
        ])->registerItem([
            'id' => 'webed-plugins',
            'piority' => 1001,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Plugins',
            'font_icon' => 'icon-paper-plane',
            'link' => route('admin::plugins.index.get'),
            'css_class' => null,
        ]);
        /*->registerItem([
            'id' => 'webed-theme-modules',
            'piority' => 1001,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Themes',
            'font_icon' => 'icon-magic-wand',
            'link' => route('admin::index-theme-modules'),
            'css_class' => null,
        ]);*/
        /*->registerItem([
            'id' => 'webed-add-modules',
            'piority' => 1001,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Add new',
            'font_icon' => 'icon-basket-loaded',
            'link' => route('admin::add-module'),
            'css_class' => null,
        ])*/
    }
}
