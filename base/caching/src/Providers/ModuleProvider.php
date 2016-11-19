<?php namespace WebEd\Base\Caching\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Caching\Services\CacheService;
use WebEd\Base\Caching\Services\Contracts\CacheServiceContract;

class ModuleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Load views*/
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'webed-caching');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'webed-caching');

        \Event::listen(['cache:cleared'], function () {
            \File::delete(config('webed-caching.repository.store_keys'));
            \File::delete(storage_path('framework/cache/cache-service.json'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BootstrapModuleServiceProvider::class);

        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/webed-caching',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/webed-caching'),
        ], 'lang');
        $this->publishes([
            __DIR__ . '/../../config' => base_path('config'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../../config/webed-caching.php', 'webed-caching');

        //Bind some services
        $this->app->bind(CacheServiceContract::class, CacheService::class);
    }
}
