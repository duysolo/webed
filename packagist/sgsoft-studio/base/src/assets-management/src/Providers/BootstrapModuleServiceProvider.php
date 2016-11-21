<?php namespace WebEd\Base\AssetsManagement\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->app->booted(function () {
            $this->booted();
        });
    }

    private function booted()
    {
        /*\DashboardMenu::registerItem([
            'id' => 'webed-assets-management',
            'piority' => 999,
            'parent_id' => 'webed-configuration',
            'heading' => null,
            'title' => 'Assets',
            'font_icon' => 'fa fa-circle-o',
            'link' => '',
            'css_class' => null,
        ]);*/
    }
}
