<?php

namespace WebEd\Base\Core\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

/**
 * Class RouteServiceProvider
 * @package WebEd\Base\Core\Providers
 * @author Tedozi Manson <duyphan.developer@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\Core\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {
            $adminRoute = config('webed.admin_route');

            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute) {
                $router->get('/', 'DashboardController@getIndex')->name('admin::dashboard.index.get');

                $router->get('error/{code}', 'ErrorController@getIndex')->name('admin::error');

                /**
                 * Commands
                 */
                $router->get('system/call-composer-dump-autoload', 'SystemCommandController@getCallDumpAutoload')->name('admin::system.commands.composer-dump-autoload.get');
            });

            //$router->get('{slugNum?}', 'ResolveSlug@index')->where('slugNum', '(.*)');
        });
    }
}
