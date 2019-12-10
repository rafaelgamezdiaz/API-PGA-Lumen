<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\ApiController;
use App\Models\Client;

class ClientController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json(['data' => $clients, 'code' => 200], 200);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show( $id ){

        $client = Client::findOrFail($id);
        return response()->json(['data' => $client, 'code' => 200], 200);
       /* $transaction = new TransactionResource($transaction);
        return $this->showOne('Info of Transaction', $transaction);*/
    }

}
