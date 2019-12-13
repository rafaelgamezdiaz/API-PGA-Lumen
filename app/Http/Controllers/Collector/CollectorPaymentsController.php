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
        $collector = Collector::where('api_collector_id', $id)->first();
        if($collector != null){
            $payments = $collector->payments;
            $payments->each(function ($payments){
                $payments->client;
            });
            return response()->json(['data' => $payments, 'code' => 200], 200);
        }
        return response()->json(['message' => 'There is not collector with this id', 'code' => 200], 200);
    }

}
