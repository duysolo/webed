<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\Users\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'users';

            /*
             * Admin route
             * */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {

                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    $router->get('/', 'UserController@getIndex')->name('admin::users.index.get');
                    $router->post('/', 'UserController@postListing')->name('admin::users.index.post');

                    $router->post('update-status/{id}/{status}', 'UserController@postUpdateStatus')->name('admin::users.update-status.post');

                    $router->get('create', 'UserController@getCreate')->name('admin::users.create.get');
                    $router->get('edit/{id}', 'UserController@getEdit')->name('admin::users.edit.get');
                    $router->post('edit/{id}', 'UserController@postEdit')->name('admin::users.edit.post');
                });

            });

        });
    }
}
