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

$router->post('auth/login', 'AuthController@login');
$router->post('auth/logout', 'AuthController@logout');
$router->post('auth/refresh', 'AuthController@refresh');
$router->post('auth/info', 'AuthController@user_info');

$router->get('/mahasiswa', 'MahasiswaController@index');
$router->get('/mahasiswa/{npm}', 'MahasiswaController@read');
$router->post('/mahasiswa', 'MahasiswaController@create');
$router->put('/mahasiswa/{npm}', 'MahasiswaController@update');
$router->delete('/mahasiswa/{npm}', 'MahasiswaController@delete');