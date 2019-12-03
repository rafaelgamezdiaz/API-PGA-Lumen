<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21/01/19
 * Time: 05:02 PM
 */

namespace App\Http\Controllers;


use App\Core\ReportService;
use App\Core\TatucoController;
use App\Http\Repositories\ClientRepository;
use App\Http\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends TatucoController
{
    public function __construct()
    {
        $this->service = (new ClientService());
        parent::__construct($this->service);
        $this->validateStore = [
            //'dni' => 'unique:clients',
            'code' => 'unique:clients',
            'status' => 'required',
            'type' => 'required'

        ];
        $this->validateUpdate = [
            //'dni' => 'unique:clients',
            'code' => 'unique:clients'

        ];
        $this->messages = [
            //'dni.unique' => 'El dni debe ser unico.',
            'status.required' => 'El status es requerido.',
            'type.required' => 'El type es requerido.',
            'code.unique' => 'El codigo debe ser unico.',

        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectClients(Request $request){
        if (!$request->has('clients')){
            return response()->json(['error'=>true,"message"=>"El cliente es obligatorio"],400);
        }

        return $this->service->getClients($request);
    }

    /**
     * @param Request $request
     * @return \Dompdf\Dompdf|\Illuminate\Http\JsonResponse|string|null
     */
    public function report(Request $request){
        $user = $request->get('user')->user;
        $user->account= $user->current_account;
        $clients= (new ClientRepository())->index($request,$user);
        $index=[
            'Nombre'=>'name',
            'Nombre Comercial'=>'commerce_name',
            'Dni'=>'dni',
            'E-Mail'=>'email',
            'Telefono'=>'phone',
            'Estado'=>'status',
            'Tipo'=>'type'

        ];
        $info []=$clients;
        $report = (new ReportService());
        $report->indexPerSheet([$index]);
        $report->dataPerSheet($info);
        $report->index($index);
        $report->data($clients);
        $report->username($user->username);
        $report->getAccountInfo($user->current_account);
        return $report->report("automatic","Clientes",null,null,false,1);
    }

}