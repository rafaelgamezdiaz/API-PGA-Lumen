<?php

namespace App\Http\Controllers\Transaction;

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
       /* $transaction = Client::collection(Client::all());
        return $this->showAll('TRANSACTIONS LIST', $transaction);*/
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
       /* $transaction = new TransactionResource($transaction);
        return $this->showOne('Info of Transaction', $transaction);*/
    }

}
