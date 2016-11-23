<?php namespace WebEd\Plugins\CustomFields\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Plugins\CustomFields\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'custom-fields';

            /**
             * Admin routes
             */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    $router->get('/', 'CustomFieldController@getIndex')
                        ->name('admin::custom-fields.index.get')
                        ->middleware('has-permission:view-custom-fields');

                    $router->post('/', 'CustomFieldController@postListing')
                        ->name('admin::custom-fields.index.post')
                        ->middleware('has-permission:view-custom-fields');

                    $router->post('/update-status/{id}/{status}', 'CustomFieldController@postUpdateStatus')
                        ->name('admin::custom-fields.field-group.update-status.post')
                        ->middleware('has-permission:edit-field-groups');

                    $router->get('/create', 'CustomFieldController@getCreate')
                        ->name('admin::custom-fields.field-group.create.get')
                        ->middleware('has-permission:create-field-groups');

                    $router->get('/edit/{id}', 'CustomFieldController@getEdit')
                        ->name('admin::custom-fields.field-group.edit.get')
                        ->middleware('has-permission:edit-field-groups');

                    $router->post('/edit/{id}', 'CustomFieldController@postEdit')
                        ->name('admin::custom-fields.field-group.edit.post')
                        ->middleware('has-permission:edit-field-groups');

                    $router->delete('/delete/{id}', 'CustomFieldController@deleteDelete')
                        ->name('admin::custom-fields.field-group.delete')
                        ->middleware('has-permission:delete-field-groups');
                });
            });
        });
    }
}
