<?php namespace WebEd\Base\Elfinder\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\Elfinder\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'elfinder';

            /**
             * Admin routes
             */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    $router->get('', 'ElfinderController@getIndex')->name('admin::elfinder.index.get');
                    $router->get('/stand-alone', 'ElfinderController@getStandAlone')->name('admin::elfinder.stand-alone.get');
                    $router->get('/elfinder-view', 'ElfinderController@getElfinderView')->name('admin::elfinder.popup.get');
                    $router->any('/connector', 'ElfinderController@anyConnector')->name('admin::elfinder.connect');
                });
            });
        });
    }
}
