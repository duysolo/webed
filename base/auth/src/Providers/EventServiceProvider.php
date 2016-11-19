<?php namespace WebEd\Base\Auth\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\Auth\Listeners\UserLoggedInListener;
use WebEd\Base\Auth\Listeners\UserLoggedOutListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen('Illuminate\Auth\Events\Login', UserLoggedInListener::class);
        Event::listen('Illuminate\Auth\Events\Logout', UserLoggedOutListener::class);
    }
}
