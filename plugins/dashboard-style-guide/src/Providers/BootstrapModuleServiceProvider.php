<?php namespace WebEd\Plugins\DashboardStyleGuide\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\DashboardStyleGuide';

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
            'id' => 'webed-dashboard-style-guide',
            'piority' => 9999,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Admin style guide',
            'font_icon' => 'icon-grid',
            'link' => route('admin::dashboard-style-guide.index.get'),
            'css_class' => null,
        ])
            ->registerItem([
                'id' => 'webed-dashboard-style-guide.index',
                'piority' => 1,
                'parent_id' => 'webed-dashboard-style-guide',
                'heading' => null,
                'title' => 'Basic',
                'font_icon' => 'fa fa-circle-o',
                'link' => route('admin::dashboard-style-guide.index.get'),
                'css_class' => null,
            ])
            ->registerItem([
                'id' => 'webed-dashboard-style-guide.colors',
                'piority' => 1,
                'parent_id' => 'webed-dashboard-style-guide',
                'heading' => null,
                'title' => 'Colors',
                'font_icon' => 'fa fa-circle-o',
                'link' => route('admin::dashboard-style-guide.colors.get'),
                'css_class' => null,
            ])
            ->registerItem([
                'id' => 'webed-dashboard-style-guide.font-icons',
                'piority' => 2,
                'parent_id' => 'webed-dashboard-style-guide',
                'heading' => null,
                'title' => 'Font icons',
                'font_icon' => 'fa fa-circle-o',
                'link' => route('admin::dashboard-style-guide.font-icons.get'),
                'css_class' => null,
            ]);
    }
}
