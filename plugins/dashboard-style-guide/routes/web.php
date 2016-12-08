<?php use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$adminRoute = config('webed.admin_route');

$moduleRoute = 'dashboard-style-guide';

/**
 * Admin routes
 */
$router->group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    /**
     * Basic components
     */
    $router->get('/', 'StyleGuideController@getIndex')
        ->name('admin::dashboard-style-guide.index.get');
    /**
     * Colors
     */
    $router->get('colors', 'StyleGuideController@getColors')
        ->name('admin::dashboard-style-guide.colors.get');
    /**
     * Font icons
     */
    $router->get('font-icons', 'StyleGuideController@getFontIcons')
        ->name('admin::dashboard-style-guide.font-icons.get');
});
