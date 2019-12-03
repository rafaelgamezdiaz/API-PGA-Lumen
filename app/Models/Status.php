<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 12/03/19
 * Time: 09:59 AM
 */

namespace App\Models;


use App\Core\TatucoModel;

class Status extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table ="status";
    protected $fillable = [
        'id', 'name','description','account','deleted'
    ];
}