<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 12/03/19
 * Time: 09:59 AM
 */

namespace App\Models;

use Carbon\Carbon;

class Payment extends TatucoModel
{
    // Passing these two params as constant in the actual version of the api
    const JOURNAL_ID = 7;
    const PAYMENT_METHOD_ID = 1;


    protected $fillable = [
        'amount',
        'client_id',
        'collector_id',
        'journal_id',
        'created_at',
        'payment_method_id'
    ];

    protected $hidden = [
        'client_id',
        'collector_id',
        'updated_at',
        'deleted_at',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function collector(){
        return $this->belongsTo(Collector::class);
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timezone("America/Panama")->format("Y-m-d"); //format("Y-m-d h:i:s")
    }

}