<?php namespace WebEd\Plugins\Backup\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Plugins\Backup\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'webed-backup';

            /**
             * Admin routes
             */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->group(['prefix' => $moduleRoute, 'middleware' => 'has-permission:view-backups,download-backups'], function (Router $router) use ($adminRoute, $moduleRoute) {
                    /**
                     * Put some route here
                     */
                    $router->get('', 'BackupController@getIndex')
                        ->name('admin::webed-backup.index.get');
                    $router->post('', 'BackupController@postListing')
                        ->name('admin::webed-backup.index.post');

                    /**
                     * Create backup
                     */
                    $router->get('create/{type?}', 'BackupController@getCreate')
                        ->name('admin::webed-backup.create.get');

                    /**
                     * Download backup
                     */
                    $router->get('download', 'BackupController@getDownload')
                        ->name('admin::webed-backup.download.get');

                    /**
                     * Delete backup
                     */
                    $router->delete('delete', 'BackupController@deleteDelete')
                        ->name('admin::webed-backup.delete.delete');

                    /**
                     * Delete all backups
                     */
                    $router->get('delete-all', 'BackupController@getDeleteAll')
                        ->name('admin::webed-backup.delete-all.get');
                });
            });
        });
    }
}
