<?php namespace WebEd\Plugins\Backup\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Backup\Facades\BackupFacade;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'webed-backup');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'webed-backup');
        /*Load migrations*/
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../resources/assets' => resource_path('assets'),
            __DIR__ . '/../../resources/public' => public_path(),
        ], 'assets');
        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/webed-backup',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/webed-backup'),
        ], 'lang');
        $this->publishes([
            __DIR__ . '/../../database' => base_path('database'),
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Load helpers
        load_module_helpers(__DIR__);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Backup', BackupFacade::class);

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(BootstrapModuleServiceProvider::class);
    }
}
