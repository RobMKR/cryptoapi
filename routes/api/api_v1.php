<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** Just for testing */
Route::get('test', function () {
    dd('Test V1');
});

/** Auth routes */
Route::group(['prefix' => 'auth'], function (\Illuminate\Routing\Router $router) {
    /** Register */
    $router->post('register', 'Auth\RegisterController');

    /** Login */
    $router->post('login', 'Auth\LoginController');
});

/** Authenticated routes group */
Route::group(['prefix' => 'exchange'], function (\Illuminate\Routing\Router $router) {
    /** Get coins from 3rd party service or cache */
    $router->get('coins', 'Exchange\CoinsController');

    /** Get tickers from 3rd party service or cache */
    $router->get('ticker/{coin_code}', 'Exchange\TickerController');
});
