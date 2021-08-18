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
$router->group(['prefix' => 'tokobaju','middleware' => 'auth'], function() use ($router){
    //-----------------route untuk katagori----------
    $router->get('/katagori',['uses' => 'KatagoriController@index']);
    $router->get('/katagori/{id}',['uses' => 'KatagoriController@show']);
    $router->post('/katagori',['uses' => 'KatagoriController@create']);
    $router->put('/katagori/{id}',['uses' => 'KatagoriController@update']);
    $router->delete('/katagori/{id}',['uses' => 'KatagoriController@destroy']);
    //-----------------route untuk produk----------------
    $router->get('/produk',['uses' => 'ProdukController@index']);
    $router->get('/produk/{id}',['uses' => 'ProdukController@show']);
    $router->get('/produk/images/{id}',['uses' => 'ProdukController@images']);
    $router->post('/produk',['uses' => 'ProdukController@create']);
    $router->put('/produk/{id}',['uses' => 'ProdukController@update']);
    $router->delete('/produk/{id}',['uses' => 'ProdukController@destroy']);
    //--------------------route galeri produk---------------------
    $router->get('/galeri/produk',['uses' => 'GaleriController@index']);
    $router->get('/galeri/produk/{id}',['uses' => 'GaleriController@show']);
    $router->post('/galeri/produk',['uses' => 'GaleriController@create']);
    $router->put('/galeri/produk/{id}',['uses' => 'GaleriController@update']);
    $router->delete('/galeri/produk/{id}',['uses' => 'GaleriController@destroy']);
});

