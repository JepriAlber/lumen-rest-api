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

$router->post('/register','UserController@register');
$router->post('/login','UserController@login');

//mengelompokan route, akses url menjadi awalan https/tokobaju/
$router->group(['prefix' => 'tokobaju'], function() use ($router){
    
    $router->get('/produk',['uses' => 'ProdukController@index']);
    $router->get('/produk/{id}',['uses' => 'ProdukController@show']);
    $router->post('/produk',['uses' => 'ProdukController@create']);
    $router->put('/produk/{id}',['uses' => 'ProdukController@update']);
    $router->delete('/produk/{id}',['uses' => 'ProdukController@destroy']);
    
});

