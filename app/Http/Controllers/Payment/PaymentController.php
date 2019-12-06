<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\ApiController;
use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\CollectorRepository;
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
    public function index(Request $request)
    {
       // $fields = Payment::all();

        $fields = (isset($_GET['where'])) ? Payment::doWhere($request)->get() : Payment::all();
        $fields->each(function($fields){
            $fields->client;
            $fields->collector;
        });

        /*
        $date_out = $fields->last()->created_at;

        $timezone = "America/Panama";
        date_default_timezone_set($timezone);
        $offset = date('Z', strtotime($date_out));
        $do = date('r', strtotime($date_out) + $offset);
        //return response()->json($do, 200);
        $d = (new \DateTime($do . ' UTC'))->format('U');
        $do = date("Y-m-d H:i:s", $d);
        return response()->json(['utc' => $date_out, 'local panama' =>$do], 200);
        */

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

        $rules = [
            'code'              => 'required',
            'enterprise_id'     => 'required',
            'enterprise_name'   => 'required|string',
            'amount'            => 'required|numeric',
            'api_collector_id'  => 'required',
            'collector_name'    => 'required|string'
        ];
        $this->validate($request, $rules);
        $payment = Payment::create([
            'amount'            => $request->amount,
            'date'              => $this->today(),
            'client_id'         => ClientRepository::getClientId($request),
            'collector_id'      => CollectorRepository::getCollectorId($request),
            'journal_id'        => Payment::JOURNAL_ID,
            'payment_method_id' => Payment::PAYMENT_METHOD_ID
        ]);
        if($payment){
            return response()->json(['message' => '¡Pago realizado con Éxito!'], 200);
        }
        return response()->json(['error' => 'Error al intentar registrar el pago.'], 409);
    }


}
