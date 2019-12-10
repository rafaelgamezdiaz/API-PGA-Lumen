<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\ApiController;
use App\Models\Collector;

class CollectorController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Collector::all();
        return response()->json(['data' => $clients, 'code' => 200], 200);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Collector $seller)
    {
    /*    $transaction = new TransactionResource($transaction);
        return $this->showOne('Info of Transaction', $transaction);*/
    }

}
