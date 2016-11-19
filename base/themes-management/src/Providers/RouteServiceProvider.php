<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\ThemesManagement\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'webed-themes-management';

            /**
             * Admin routes
             */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    /**
                     * Put some route here
                     */
                    $router->get('', 'ThemeController@getIndex')->name('admin::themes.index.get');
                    $router->post('', 'ThemeController@postListing')->name('admin::themes.index.post');
                    $router->post('change-status/{module}/{status}', 'ThemeController@postChangeStatus')->name('admin::themes.change-status.post');

                    $router->post('install/{module}', 'ThemeController@postInstall')->name('admin::themes.install.post');
                    $router->post('uninstall/{module}', 'ThemeController@postUninstall')->name('admin::themes.uninstall.post');
                });
            });
        });
    }
}
