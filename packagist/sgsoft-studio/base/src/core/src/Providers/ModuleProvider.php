<?php namespace WebEd\Base\Core\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Core\Facades\BreadcrumbsFacade;
use WebEd\Base\Core\Facades\FlashMessagesFacade;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'webed-core');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'webed-core');

        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/webed-core',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/webed-core'),
        ], 'lang');
        $this->publishes([
            __DIR__ . '/../../config' => base_path('config'),
        ], 'config');
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
        config(['webed.version' => '2.0']);

        //Load helpers
        $this->loadHelpers();

        //Register related facades
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Breadcrumbs', BreadcrumbsFacade::class);
        $loader->alias('FlashMessages', FlashMessagesFacade::class);

        //Merge configs
        $configs = split_files_with_basename($this->app['files']->glob(__DIR__ . '/../../config/*.php'));

        foreach ($configs as $key => $row) {
            $this->mergeConfigFrom($row, $key);
        }

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ValidateServiceProvider::class);
        $this->app->register(HookServiceProvider::class);
        $this->app->register(ComposerServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(CollectiveServiceProvider::class);
        $this->app->register(BootstrapModuleServiceProvider::class);

        /**
         * Auto register modules
         */
        $this->app->register(\WebEd\Base\ModulesManagement\Providers\ModuleProvider::class);
    }

    private function loadHelpers()
    {
        $helpers = $this->app['files']->glob(__DIR__ . '/../../helpers/*.php');
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }
}
