<?php namespace WebEd\Base\ACL\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\ACL';

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
            'id' => 'webed-acl-roles',
            'piority' => 3.1,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Roles',
            'font_icon' => 'icon-lock',
            'link' => route('admin::acl-roles.index.get'),
            'css_class' => null,
        ])->registerItem([
            'id' => 'webed-acl-permissions',
            'piority' => 3.2,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Permissions',
            'font_icon' => 'icon-shield',
            'link' => route('admin::acl-permissions.index.get'),
            'css_class' => null,
        ]);
    }
}
