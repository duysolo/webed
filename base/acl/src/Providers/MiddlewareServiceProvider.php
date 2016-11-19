<?php namespace WebEd\Base\ACL\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\ACL\Http\Middleware\HasPermission;
use WebEd\Base\ACL\Http\Middleware\HasRole;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['router']->middleware('has-role', HasRole::class);
        $this->app['router']->middleware('has-permission', HasPermission::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
