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
            'id' => 'webed-plugins',
            'piority' => 1001,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Plugins',
            'font_icon' => 'icon-paper-plane',
            'link' => route('admin::plugins.index.get'),
            'css_class' => null,
        ]);
    }
}
