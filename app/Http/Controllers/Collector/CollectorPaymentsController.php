<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\ApiController;
use App\Models\Collector;

class CollectorPaymentsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collector = Collector::findOrFail($id);
        $payments = $collector->payments;
        $payments->each(function ($payments){
           $payments->client;
        });

        return response()->json(['data' => $payments, 'code' => 200], 200);
    }

}
