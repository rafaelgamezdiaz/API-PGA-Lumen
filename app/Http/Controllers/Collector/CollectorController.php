<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\ApiController;
use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\CollectorRepository;
use App\Models\Collector;
use App\Models\Payment;
use Illuminate\Http\Request;

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
        //
    }

    public function store(Request $request)
    {

        $rules = [
            'collector_name'   => 'required',
            'api_collector_id' => 'required'
        ];
        $this->validate($request, $rules);
        $collector = Collector::create([
            'collector_name'    => $request->collector_name,
            'api_collector_id'  => $request->api_collector_id
        ]);
        if($collector){
            return response()->json(['message' => '¡Cobrador registrado!'], 200);
        }
        return response()->json(['error' => 'Error al intentar registrar el cobrador.'], 409);
    }

}
