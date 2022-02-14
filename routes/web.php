<?php

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/all', 'ConcertsController@all');
$router->get('/upcoming', 'ConcertsController@upcoming');
$router->get('/past', 'ConcertsController@past');
$router->get('/old/upcoming', 'ConcertsController@old_upcoming');

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('me', 'AuthController@me');
        $router->get('logout', 'AuthController@logout');
    });
});

$router->group([
    'prefix' => 'intern',
    'middleware' => 'auth'
], function () use ($router) {
    $router->get('basics', 'InternController@basics');
    $router->get('downloads', 'InternController@downloads');
    $router->get('song/{file_name}', ['as' => 'song', 'uses' => 'InternController@song']);
});

$router->group(['prefix' => 'download'], function () use ($router) {
    $router->get('all-filenames', 'DownloadController@getAllFileNames');
    $router->get('id/{id}', 'DownloadController@download');
    $router->get('filename', 'DownloadController@downloadByName');
    $router->get('recordings', 'DownloadController@recordings');
});

