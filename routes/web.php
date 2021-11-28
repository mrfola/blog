<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/api/posts', [
    'uses' => 'PostController@index',
    'as' => 'post_index'
]);

$router->get('/api/posts/{id}', [
    'uses' => 'PostController@show',
    'as' => 'post_show'
]);


$router->post('/api/posts', [
    'uses' => 'PostController@store',
    'as' => 'post_store'
]);


$router->patch('/api/posts/{id}', [
    'uses' => 'PostController@update',
    'as' => 'post_update'
]);

$router->delete('/api/posts/{id}', [
    'uses' => 'PostController@destroy',
    'as' => 'post_destroy'
]);

