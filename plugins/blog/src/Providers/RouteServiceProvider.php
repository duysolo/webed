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
                    $router->get('posts', 'PostController@getIndex')->name('admin::blog.posts.index.get');
                    $router->post('posts', 'PostController@postListing')->name('admin::blog.posts.index.post');
                    $router->get('posts/create', 'PostController@getCreate')->name('admin::blog.posts.create.get');
                    $router->get('posts/edit/{id}', 'PostController@getEdit')->name('admin::blog.posts.edit.get');
                    $router->post('posts/edit/{id}', 'PostController@postEdit')->name('admin::blog.posts.edit.post');
                    $router->post('posts/update-status/{id}/{status}', 'PostController@postUpdateStatus')->name('admin::blog.posts.update-status.post');
                    $router->delete('posts/{id}', 'PostController@deleteDelete')->name('admin::blog.posts.delete.delete');

                    $router->get('categories', 'CategoryController@getIndex')->name('admin::blog.categories.index.get');
                    $router->post('categories', 'CategoryController@postListing')->name('admin::blog.categories.index.post');
                    $router->get('categories/create', 'CategoryController@getCreate')->name('admin::blog.categories.create.get');
                    $router->get('categories/edit/{id}', 'CategoryController@getEdit')->name('admin::blog.categories.edit.get');
                    $router->post('categories/edit/{id}', 'CategoryController@postEdit')->name('admin::blog.categories.edit.post');
                    $router->post('categories/update-status/{id}/{status}', 'CategoryController@postUpdateStatus')->name('admin::blog.categories.update-status.post');
                    $router->delete('categories/{id}', 'CategoryController@deleteDelete')->name('admin::blog.categories.delete.delete');
                });
            });
        });
    }
}
