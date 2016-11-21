<?php namespace WebEd\Base\Caching\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\Caching\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'caching';

            /**
             * Admin routes
             */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {

                    $router->get('', 'CachingController@getIndex')->name('admin::webed-caching.index.get');
                    $router->get('clear-cms-cache', 'CachingController@getClearCmsCache')->name('admin::webed-caching.clear-cms-cache.get');
                    $router->get('clear-cms-cache', 'CachingController@getClearCmsCache')->name('admin::webed-caching.clear-cms-cache.get');
                    $router->get('refresh-compiled-views', 'CachingController@getRefreshCompiledViews')->name('admin::webed-caching.refresh-compiled-views.get');
                });
            });
        });
    }
}
