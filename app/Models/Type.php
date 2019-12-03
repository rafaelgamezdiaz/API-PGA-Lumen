<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 12/03/19
 * Time: 09:59 AM
 */

namespace App\Models;


use App\Core\TatucoModel;

class Type extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table ="types";
    protected $fillable = [
        'id', 'name','description','account','deleted'
    ];
}