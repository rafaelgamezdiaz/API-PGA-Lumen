<?php


namespace App\Http\Controllers\Client;


use App\Models\Client;

class ClientPaymentController
{



    /**
     * Returns all payments from clients /clients/payments
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $clients = Client::all();
        $payments = $clients->each(function($clients){
            $clients->payments;
        })->pluck(['payments']);

        return response()->json(['data' => $payments, 'code' => 200], 200);
    }

    /**
     * Returns all payments for a client /clients/{client_id}/payments
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show( $id ){
        $client = Client::findOrFail($id);
        $payments = $client->payments()->get();
        return response()->json(['payments' => $payments, 'code' => 200], 200);
    }
}