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
$router->get('/{slug}.html', 'SlugWithSuffixController@handle')->name('public.get-by-slug-with-suffix.get');
$router->get('/{slug?}', 'SlugWithoutSuffixController@handle')->name('public.get-by-slug.get');
