<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22/01/19
 * Time: 09:40 AM
 */

namespace App\Models;


use App\Core\TatucoModel;

class Venue extends TatucoModel
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table ="venues";
    protected $fillable = [
        'id', 'client', 'name','description','account','deleted'
    ];
}