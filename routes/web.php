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

$router->group(['prefix' => 'concerts'], function () use ($router) {
    $router->get('/all', 'ConcertsController@all');
    $router->get('/upcoming', 'ConcertsController@upcoming');
    $router->get('/past', 'ConcertsController@past');
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('logout', 'AuthController@logout');
    });
});

$router->group([
    'prefix' => 'intern',
    'middleware' => 'auth'
], function () use ($router) {
    $router->get('basics', 'InternController@basics');
});

$router->group([
    'prefix' => 'download',
    'middleware' => 'auth'
], function () use ($router) {
    $router->get('recording', 'ConcertRecordingsController@oneFile');
    $router->get('recordings', 'InternController@downloads');
    $router->get('song', 'SongsController@oneFile');
    $router->get('songs', 'SongsController@getAll');
});
