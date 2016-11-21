<?php namespace WebEd\Base\Elfinder\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
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
        /**
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'webed-elfinder',
            'piority' => 12,
            'parent_id' => null,
            'heading' => 'Others',
            'title' => 'Medias & Files',
            'font_icon' => 'icon-doc',
            'link' => route('admin::elfinder.index.get'),
            'css_class' => null,
        ]);
    }
}
