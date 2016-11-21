<?php namespace WebEd\Base\Auth\Providers;

use Illuminate\Support\ServiceProvider;

use WebEd\Base\Auth\Http\Middleware\AuthenticateAdmin;
use WebEd\Base\Auth\Http\Middleware\GuestAdmin;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['router']->middleware('webed.auth-admin', AuthenticateAdmin::class);
        $this->app['router']->middleware('webed.guest-admin', GuestAdmin::class);
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
