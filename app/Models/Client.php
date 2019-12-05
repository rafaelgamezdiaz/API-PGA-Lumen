<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21/01/19
 * Time: 04:58 PM
 */

namespace App\Models;

class Client extends TatucoModel
{
    const CLIENT_ACTIVE = 'active';
    const CLIENT_INACTIVE = 'inactive';

    protected $fillable = [
        'enterprise_id','code','enterprise_name','status'
    ];

    protected $hidden = ['id', 'status', 'created_at', 'updated_at', 'deleted_at'];

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function isActive(){
        return $this->status == Client::CLIENT_ACTIVE;
    }

}