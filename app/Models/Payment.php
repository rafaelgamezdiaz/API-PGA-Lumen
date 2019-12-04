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
    protected $fillable = [
        'amount','date','client_id','collector_id'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function collector(){
        return $this->belongsTo(Collector::class);
    }

}