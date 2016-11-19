<?php namespace WebEd\Base\ACL\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\ACL\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'acl';

            /**
             * Admin routes
             */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    $router->get('', function () {
                        return redirect()->to(route('admin::acl-roles.index.get'));
                    });
                    /**
                     * Roles
                     */
                    $router->get('/roles', 'RoleController@getIndex')->name('admin::acl-roles.index.get');
                    $router->post('/roles', 'RoleController@postListing')->name('admin::acl-roles.index.get-json');
                    $router->delete('/roles/{id}', 'RoleController@deleteDelete')->name('admin::acl-roles.delete.delete');
                    $router->get('/roles/create', 'RoleController@getCreate')->name('admin::acl-roles.create.get');
                    $router->get('/roles/edit/{id}', 'RoleController@getEdit')->name('admin::acl-roles.edit.get');
                    $router->post('/roles/edit/{id}', 'RoleController@postEdit')->name('admin::acl-roles.edit.post');

                    /**
                     * Permissions
                     */
                    $router->get('/permissions', 'PermissionController@getIndex')->name('admin::acl-permissions.index.get');
                    $router->post('/permissions', 'PermissionController@postListing')->name('admin::acl-permissions.index.post');
                });
            });
        });
    }
}
