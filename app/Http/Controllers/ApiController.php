<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{
    use ApiResponser;

   //  protected $model;

   /* public function __construct($model)
    {
        $this->model = $model;
    }*/

    public function saveFields($request, $rules, $model){
        $this->validate($request, $rules);
        $model->fill($request->all());
        $model->save();
        return $this->showOne('The resource was created.', $model, 201);
    }


    /**
     * General Update Method
     * @param $fields
     * @param $request
     * @param $model
     * @return \Illuminate\Http\JsonResponse
     */
   public function updateFields($fields = [], $request, $model){
       $tofill = ($fields != []) ? $request->only($fields) :$request->all();
       $model->fill($tofill);
       return $this->updateNow($model);
   }

   private function updateNow($model){
       if ($model->isClean()){
           return $this->errorResponse('You must enter at least one different value',422 );
       }
       $model->save();
       return $this->showOne('The resource was updated', $model);
   }

    public static function today(){
        $now = Carbon::now();
        return $now->year.'-'.$now->month.'-'.$now->day;
    }

}
