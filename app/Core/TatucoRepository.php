<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 * Date: 23/07/18
 * Time: 04:06 PM
 */

namespace App\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TatucoRepository
{
    protected $model;
    public $data = [];

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function _index($request = null)
    {

        $query = (isset($request->where)) ? $this->model::select("*")->doWhere($request->where) : $this->model::all();

        return $query;
    }



    public function test($request)
    {

        $query = (isset($request->where)) ? $this->model::select("*")->doWhere($request->where) : $this->model::all();

        return $query;
    }

    public function _show($id)
    {
        $item = $this->model::find($id);

        return $item;
    }

    public function _store($data)
    {
        if (count($this->data) == 0) {
            $this->data = $data->all();
        }
        $new = $this->model::create($this->data);

        return $new;
    }

    public function _update($id, $data)
    {

        $object = $this->model::findOrFail($id);

        $object->update($data);
        if($object)
            return $object;
        else
            return null;

    }

    public function errorException(\Exception $e)
    {
        Log::critical("Error, archivo del peo: {$e->getFile()}, linea del peo: {$e->getLine()}, el peo: {$e->getMessage()}");
        return response()->json([
            "message" => "Error de servidor",
            "exception" => $e->getMessage(),
            "file" => $e->getFile(),
            "line" => $e->getLine(),
            "code" => $e->getCode(),
            // "error" => $this->runError()
        ], 500);
    }

    /* public function exceptionPdo(\Exception $e, $value =  null)
     {

     }*/

    public function select($select)
    {
        $query = $this->model::select($select);
        return $query->get();
    }

    public function saveModel($model, $data)
    {
        if($data instanceof Request)
            $data = $data->all();

        if($new = $model::create($data)){
            return $new;
        }
        return null;
    }
    /**
     * @named Funcion para obtener el Sql Plano
     * @param $cadena
     * @return string
     */
    public function ObtenerQuery($cadena){
        $sql = str_replace('?', "'?'", $cadena->toSql());
        return vsprintf(str_replace('?', '%s', $sql), $cadena->getBindings());
    }
}