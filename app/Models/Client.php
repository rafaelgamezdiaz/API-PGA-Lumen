<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21/01/19
 * Time: 04:58 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    const CLIENT_ACTIVE = 'active';
    const CLIENT_INACTIVE = 'inactive';

    protected $fillable = [
        'enterprise_id','code','enterprise_name','status'
    ];

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function isActive(){
        return $this->status == Client::CLIENT_ACTIVE;
    }

}