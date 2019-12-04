<?php

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

//use Carbon\Carbon;

$router->group(['prefix' => 'pga'], function () use ($router) {

    $router->get('/payments', 'Payment\PaymentController@index');
    $router->post('/payments', 'Payment\PaymentController@store');

    $router->group(['prefix' => 'report'], function () use ($router) {
        $router->post('/automatic', 'ReportController@automatic');
    });

});
