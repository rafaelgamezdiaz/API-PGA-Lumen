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

    // PAYMENTS
    $router->get('/payments', 'Payment\PaymentController@index');
    $router->post('/payments', 'Payment\PaymentController@store');

    // REPORT XLS
    $router->group(['prefix' => 'report'], function () use ($router) {
        $router->post('/automatic', 'ReportController@automatic');
    });

    // CLIENTS
    $router->get('/clients', 'Client\ClientController@index');
    $router->get('/clients/{id}/details', 'Client\ClientController@show');
    $router->get('/clients/payments', 'Client\ClientPaymentController@index');
    $router->get('/clients/{id}/payments', 'Client\ClientPaymentController@show');
    $router->get('/clients/{id}/collectors', 'Client\ClientCollectorController@show');

    // COLLECTORS
    $router->get('/collectors', 'Collector\CollectorController@index');
});
