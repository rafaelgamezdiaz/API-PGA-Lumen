<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\ApiController;
use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\CollectorRepository;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = (isset($_GET['where'])) ? Payment::doWhere($request)->orderBy('created_at', 'desc')->get() : Payment::all()->sortByDesc('created_at');
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

        $rules = [
            'code'              => 'required',
            'enterprise_id'     => 'required',
            'enterprise_name'   => 'required',
            'amount'            => 'required|numeric|min:1',
            'api_collector_id'  => 'required',
            'collector_name'    => 'required|string'
        ];
        $messages = [
            'code.required'             => 'Debe ingresar el codigo de la empresa',
            'enterprise_id.required'    => 'Debe ingresar el id de la empresa',
            'enterprise_name.required'  => 'Debe ingresar el nombre de la empresa',
            'amount.required'           => 'Debe ingresar el monto a pagar',
            'amount.numeric'            => 'El monto a pagar debe ser numerico y mayor a cero',
            'amount.min'                => 'El monto a pagar debe ser mayor a cero',
            'api_collector_id.required' => 'Debe ingresar el id del cobrador',
            'collector_name.required'   => 'Debe ingresar el nombre del cobrador',
            'collector_name.string'     => 'Formato incorrecto para el nombre del cobrador'

        ];
        $this->validate($request, $rules, $messages);
        $payment = Payment::create([
            'amount'            => $request->amount,
            'client_id'         => ClientRepository::getClientId($request),
            'collector_id'      => CollectorRepository::getCollectorId($request),
            'journal_id'        => Payment::JOURNAL_ID,
            'payment_method_id' => Payment::PAYMENT_METHOD_ID
        ]);
        if($payment){
            return response()->json(['message' => '¡Pago realizado con Éxito!', 'id' => $payment->id], 200);
        }
        return response()->json(['error' => 'Error al intentar registrar el pago.'], 409);
    }

}
