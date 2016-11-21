<?php namespace WebEd\Base\Settings\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\Settings\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => ['web']], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'settings';

            /*
             * Admin route
             * */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {

                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    $router->get('/', 'SettingController@index')->name('admin::settings.index.get');
                    $router->post('', 'SettingController@store')->name('admin::settings.update.post');
                });

            });

        });
    }
}
