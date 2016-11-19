<?php namespace WebEd\Base\Auth\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\Auth\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'auth';

            /*
             * Admin route
             * */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->get($moduleRoute, function () use ($adminRoute, $moduleRoute) {
                    return redirect()->to($adminRoute . '/' . $moduleRoute . '/login');
                });

                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    $router->get('login', 'AuthController@getLogin')->name('admin::auth.login.get');
                    $router->post('login', 'AuthController@postLogin')->name('admin::auth.login.post');
                    $router->get('logout', 'AuthController@getLogout')->name('admin::auth.logout.get');
                });
            });

        });
    }
}
