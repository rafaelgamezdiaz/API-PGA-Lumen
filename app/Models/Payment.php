<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 12/03/19
 * Time: 09:59 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Passing these two params as constant in the actual version of the api
    const JOURNAL_ID = 7;
    const PAYMENT_METHOD_ID = 1;


    protected $fillable = [
        'amount',
        'date',
        'client_id',
        'collector_id',
        'journal_id',
        'payment_method_id'
    ];

    protected $hidden = [
        'client_id',
        'collector_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function collector(){
        return $this->belongsTo(Collector::class);
    }

}