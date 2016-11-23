<?php namespace WebEd\Plugins\Blog\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Plugins\Blog\Http\Controllers';

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function (Router $router) {

            $adminRoute = config('webed.admin_route');

            $moduleRoute = 'webed-blog';

            /**
             * Admin routes
             */
            $router->group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
                    /**
                     * Put some route here
                     */
                    $router->get('posts', 'PostController@getIndex')
                        ->name('admin::blog.posts.index.get')
                        ->middleware('has-permission:view-posts');

                    $router->post('posts', 'PostController@postListing')
                        ->name('admin::blog.posts.index.post')
                        ->middleware('has-permission:view-posts');

                    $router->get('posts/create', 'PostController@getCreate')
                        ->name('admin::blog.posts.create.get')
                        ->middleware('has-permission:create-posts');

                    $router->get('posts/edit/{id}', 'PostController@getEdit')
                        ->name('admin::blog.posts.edit.get')
                        ->middleware('has-permission:edit-posts');

                    $router->post('posts/edit/{id}', 'PostController@postEdit')
                        ->name('admin::blog.posts.edit.post')
                        ->middleware('has-permission:edit-posts');

                    $router->post('posts/update-status/{id}/{status}', 'PostController@postUpdateStatus')
                        ->name('admin::blog.posts.update-status.post')
                        ->middleware('has-permission:edit-posts');

                    $router->delete('posts/{id}', 'PostController@deleteDelete')
                        ->name('admin::blog.posts.delete.delete')
                        ->middleware('has-permission:delete-posts');

                    /**
                     * Categories
                     */
                    $router->get('categories', 'CategoryController@getIndex')
                        ->name('admin::blog.categories.index.get')
                        ->middleware('has-permission:view-categories');

                    $router->post('categories', 'CategoryController@postListing')
                        ->name('admin::blog.categories.index.post')
                        ->middleware('has-permission:view-categories');

                    $router->get('categories/create', 'CategoryController@getCreate')
                        ->name('admin::blog.categories.create.get')
                        ->middleware('has-permission:create-categories');

                    $router->get('categories/edit/{id}', 'CategoryController@getEdit')
                        ->name('admin::blog.categories.edit.get')
                        ->middleware('has-permission:edit-categories');

                    $router->post('categories/edit/{id}', 'CategoryController@postEdit')
                        ->name('admin::blog.categories.edit.post')
                        ->middleware('has-permission:edit-categories');

                    $router->post('categories/update-status/{id}/{status}', 'CategoryController@postUpdateStatus')
                        ->name('admin::blog.categories.update-status.post')
                        ->middleware('has-permission:edit-categories');

                    $router->delete('categories/{id}', 'CategoryController@deleteDelete')
                        ->name('admin::blog.categories.delete.delete')
                        ->middleware('has-permission:delete-categories');
                });
            });
        });
    }
}
