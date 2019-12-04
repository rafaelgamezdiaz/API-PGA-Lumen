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

$router->group(['prefix' => 'ps'], function () use ($router) {

    $router->get('/payments', 'Payment\PaymentController@index');
    $router->post('/payments', 'Payment\PaymentController@store');

    $router->group(['prefix' => 'report'], function () use ($router) {
        $router->post('/automatic', 'ReportController@automatic');
    });


    /*
    $router->get('/', function () use ($router) {
        return response()->json([
            "version"=> $router->app->version(),
            "time" => Carbon::now()
        ], 200);
    });

    $router->group(['middleware' => ['auth']],function () use ($router) {

        $router->group(['prefix' => 'report'], function () use ($router) {

            $router->get('/clients', 'ClientController@report');
            $router->post('/automatic', 'ReportController@automatic');


        });
    });


        $router->get('/clients', 'ClientController@_index');
        $router->get('/clients/{id}', 'ClientController@_show');
        $router->post('/clients', 'ClientController@_store');
        $router->put('/clients/{id}', 'ClientController@_update');
        $router->delete('/clients/{id}', 'ClientController@_destroy');


        $router->get('/venues', 'VenueController@_index');
        $router->get('/venues/{id}', 'VenueController@_show');
        $router->post('/venues', 'VenueController@_store');
        $router->put('/venues/{id}', 'VenueController@_update');
        $router->delete('/venues/{id}', 'VenueController@_destroy');

        $router->group(['prefix' => 'selects'], function () use ($router) {
            $router->get('/clients', 'ClientController@selectClients');
        });

    */

    });
