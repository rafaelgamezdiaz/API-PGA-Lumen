<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 12/03/19
 * Time: 09:59 AM
 */

namespace App\Models;

class Collector extends TatucoModel
{
    protected $fillable = [
        'collector_name', 'api_collector_id'
    ];

    protected $hidden = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function setCollectorNameAttribute($value){
        return $this->attributes['collector_name'] = strtolower($value);
    }

    public function getCollectorNameAttribute($value){
        return ucwords($value);
    }

}