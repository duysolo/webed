<?php namespace WebEd\Base\ModulesManagement\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\ModulesManagement\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'modules-management';

            /**
             * Admin routes
             */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    $router->get('', function () {
                        return redirect(route('admin::core-modules.index.get'));
                    });
                    $router->get('core', 'CoreModulesController@getIndex')->name('admin::core-modules.index.get');
                    $router->post('core', 'CoreModulesController@postListing')->name('admin::core-modules.index.post');
                    $router->get('plugins', 'PluginsController@getIndex')->name('admin::plugins.index.get');
                    $router->post('plugins', 'PluginsController@postListing')->name('admin::plugins.index.post');

                    $router->post('plugins/change-status/{module}/{status}', 'PluginsController@postChangeStatus')->name('admin::plugins.change-status.post');
                    $router->post('plugins/install/{module}', 'PluginsController@postInstall')->name('admin::plugins.install.post');
                    $router->post('plugins/uninstall/{module}', 'PluginsController@postUninstall')->name('admin::plugins.uninstall.post');
                });
            });
        });
    }
}
