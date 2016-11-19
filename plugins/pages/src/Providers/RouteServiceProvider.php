<?php

namespace WebEd\Plugins\Pages\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Plugins\Pages\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'pages';

            /*
             * Admin route
             * */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    $router->get('/', 'PageController@getIndex')->name('admin::pages.index.get');
                    $router->post('/', 'PageController@postListing')->name('admin::pages.index.post');

                    $router->post('update-status/{id}/{status}', 'PageController@postUpdateStatus')->name('admin::pages.update-status.post');

                    $router->get('create', 'PageController@getCreate')->name('admin::pages.create.get');
                    $router->get('edit/{id}', 'PageController@getEdit')->name('admin::pages.edit.get');
                    $router->post('edit/{id}', 'PageController@postEdit')->name('admin::pages.edit.post');

                    $router->delete('/{id}', 'PageController@deleteDelete')->name('admin::pages.delete.delete');
                });
            });

        });
    }
}
