<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21/01/19
 * Time: 05:02 PM
 */

namespace App\Http\Services;


use App\Core\TatucoService;
use App\Http\Repositories\ClientRepository;
use App\Models\Client;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientService extends TatucoService
{
    public function __construct()
    {
        parent::__construct((new ClientRepository()));
        $this->repository = (new ClientRepository());
        $this->name = "Cliente";
        $this->namePlural = "Clientes";
    }

    /**
     * @param Request $request
     * @param null $user
     * @return JsonResponse
     */
    public function _index(Request $request, $user = null)
    {
        try{
            $user = (!$user) ? $this->currentUSer($request) : $user;
            $query = $this->repository->index($request,$user);

            if (isset($request->withList) AND $request->withList=="false"){
                $result= $query;
            }else{
                $result = ["list"=>$query,"count"=>count($query)];
            }
            return response()->json($result,200);

        }catch (Exception $e){
            return $this->errorException($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getClients(Request $request){
        $value = $request->input('clients');
        $account = $request->input('account');
        $clients = $this->repository->getClient($value, $account);

        return response()->json(["list"=>$clients,"count"=>count($clients)]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function _store(Request $request)
    {
        if(Client::query()->where(['dni'=>$request->input('dni'),'account'=>$request->input('account')])->first()){
            return response()->json(["error"=>true,"message"=>"Dni ya registrado"],400);
        }
        if(empty($request->input('dni'))){
            $request->merge(['dni'=>'']);
        }
        return parent::_store($request);
    }
}