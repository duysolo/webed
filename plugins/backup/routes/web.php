<?php use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$adminRoute = config('webed.admin_route');

$moduleRoute = 'backup';

/**
 * Admin routes
 */
$router->group(['prefix' => $adminRoute . '/' . $moduleRoute, 'middleware' => 'has-permission:view-backups,download-backups'], function (Router $router) use ($adminRoute, $moduleRoute) {
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
