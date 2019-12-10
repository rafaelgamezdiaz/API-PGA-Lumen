<?php


namespace App\Http\Controllers\Client;


use App\Models\Client;

class ClientCollectorController
{

    public function show($id){

        $client = Client::where('enterprise_id', $id)->first();
        $client->payments;
        return response()->json([$client]);
    }
}