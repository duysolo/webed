<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**
 *
 * @var \Illuminate\Routing\Router $router
 *
 */

/**
 * Use for pages
 */
$router->get('/{slug?}', 'ResolvePagesController@handle')->name('front.resolve-pages.get');

/**
 * Use for blog
 */
if (
    interface_exists('WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract') &&
    interface_exists('WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract')
) {
    $router->get('blog/{slug}.html', 'ResolveBlogController@handle')->name('front.resolve-blog.get');
}
