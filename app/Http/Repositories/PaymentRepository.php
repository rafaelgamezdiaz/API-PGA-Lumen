<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21/01/19
 * Time: 05:02 PM
 */

namespace App\Http\Repositories;


use App\Models\Client;
use App\Models\Collector;

class PaymentRepository
{

    public static function getClientId($request){
        $client_exist = Client::where('code', $request->code)
            ->where('status', Client::CLIENT_ACTIVE);
        if($client_exist->count() == 0){
            $client = Client::create([
                'code'              => $request->code,
                'enterprise_id'     => $request->enterprise_id,
                'enterprise_name'   => $request->enterprise_name,
                'status'            => Client::CLIENT_ACTIVE
            ]);
            return $client->id;
        }
        return $client_exist->first()->id;
    }

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