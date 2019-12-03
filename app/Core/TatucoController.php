<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 * Date: 23/07/18
 * Time: 04:05 PM
 */

namespace App\Core;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class TatucoController extends BaseController
{

    public $service;
    protected $validateStore = [];
    protected $validateUpdate = [];
    protected $validateDefault = [];
    protected $messages = [];


    public function __construct($service){
        $this->service = $service;
    }


    public function _index(Request $request)
    {
        return $this->service->_index($request);
    }

    public function _show($id)
    {
        return $this->service->_show($id);
    }

    public function _store(Request $request)
    {
        $validator = Validator::make($request->all(), array_merge($this->validateStore, $this->validateDefault),$this->messages);
        if ($validator->fails()) {
            return response()->json(["error"=>true,"message"=>$validator->getMessageBag()],500);
        }
        return $this->service->_store($request);
    }


    public function _update($id,Request $request)
    {
        $validator = Validator::make($request->all(), array_merge($this->validateUpdate, $this->validateDefault),$this->messages);
        if ($validator->fails()) {
            return response()->json(["error"=>true,"message"=>$validator->getMessageBag()],500);
        }
        return $this->service->_update($id, $request);
    }

    public function _destroy($id, Request $request)
    {
        return $this->service->_destroy($id, $request);
    }




}