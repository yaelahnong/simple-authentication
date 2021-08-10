<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Str;

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

$router->get('/key', function() {
  return Str::random(32);
});

$router->post('/auth', 'Backoffice\AuthController@index');
$router->post('/two-factor', 'Backoffice\AuthController@tfauth');
$router->post('/forgot-password', 'Backoffice\UsersController@forgotPassword');
$router->get('/validate-token', 'Backoffice\UsersController@validateToken');
$router->post('/reset-password', 'Backoffice\UsersController@resetPassword');

$router->group(['prefix' => 'bo', 'middleware' => 'auth'], function () use ($router) {
  $router->get('/user', 'Backoffice\UsersController@show');
});