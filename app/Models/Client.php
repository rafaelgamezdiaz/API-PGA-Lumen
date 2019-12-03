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
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table ="clients";
    protected $fillable = [
        'id','dni', 'identifier', 'name','image','last_name','commerce_name','description','phone','address',
        'email','code','account','deleted','type','status','provider'
    ];

    public function venues(){
        return $this->hasMany('App\Models\Venue','client','id');
    }

}