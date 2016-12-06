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
$router->get('/{slug?}', 'ResolvePagesController@handle')->name('front.web.resolve-pages.get');
