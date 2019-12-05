<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22/01/19
 * Time: 01:54 PM
 */

namespace App\Http\Repositories;


use App\Models\Collector;

class CollectorRepository
{
    /**
     * If collector exist, returns it's id
     * else, create the collector and returns it's id
     * @param $request
     * @return mixed
     */
    public static function getCollectorId($request){
        $collector_exist = Collector::where('api_collector_id', $request->api_collector_id);
        if($collector_exist->count() == 0){
            $collector = Collector::create([
                'collector_name'    => $request->collector_name,
                'api_collector_id'  => $request->api_collector_id
            ]);
            return $collector->id;
        }
        return $collector_exist->first()->id;
    }
}