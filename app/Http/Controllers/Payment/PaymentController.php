<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\ApiController;
use App\Http\Repositories\PaymentRepository;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class PaymentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = Payment::all();
        $fields->each(function($fields){
            $fields->client;
            $fields->collector;
        });

        return response()->json($fields, 200);
    }



    /**
     * Store the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client_id = PaymentRepository::getClientId($request);
        $collector_id = PaymentRepository::getCollectorId($request);
        $now = Carbon::now();
        $date = $now->year.'-'.$now->month.'-'.$now->day;

        $payment = Payment::create([
            'amount'        => $request->amount,
            'date'          => $date,
            'client_id'     => $client_id,
            'collector_id'  => $collector_id
        ]);
        if($payment){
            return response()->json(['message' => '¡Pago realizado con Éxito!'], 200);
        }
        return response()->json(['error' => 'Error al intentar registrar el pago.'], 409);
    }


}
