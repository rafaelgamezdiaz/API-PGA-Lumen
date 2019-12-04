<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 12/03/19
 * Time: 09:59 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    protected $fillable = [
        'collector_name', 'api_collector_id'
    ];

    protected $hidden = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function payments(){
        return $this->hasMany(Payment::class);
    }

}