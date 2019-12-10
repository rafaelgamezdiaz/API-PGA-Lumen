<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21/01/19
 * Time: 05:02 PM
 */

namespace App\Http\Repositories;


use App\Models\Client;

class ClientRepository
{
    /**
     * If the Client exist, return the id
     * if not, creates the client and return the id
     * @param $request
     * @return mixed
     */
    public static function getClientId($request){
        $client_exist = Client::where('enterprise_id', $request->enterprise_id)
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

}