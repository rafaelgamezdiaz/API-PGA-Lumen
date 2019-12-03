<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28/01/19
 * Time: 02:40 PM
 */

namespace App\Http\Middleware;


use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate
{
    protected $client;

    public function __construct()
    {
        $this->client= new Client();
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = '';
        if($request->hasHeader('Authorization')){
            $token = $request->header('Authorization');
        }
        if ($request->has('token')){
            $token = 'Bearer ' .$request->input('token');
        }
        $header = [
            "Authorization" => $token,
            "Accept" => "application/json",
            "Cache-Control" => "no-cache"
        ];
        try{
            $url = substr(env('USERS_API'), -1) == "/" ? env('USERS_API') : env('USERS_API') . "/";
            $response = $this->client->get( $url . 'validate',['headers' => $header]);
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            return response()->json(["error"=>true,"message"=>'unauthorized',"trace"=>$exception->getMessage()],$response->getStatusCode());
        }catch (ServerException $exception){
            $response = $exception->getResponse();
            return response()->json(["error"=>true,"message"=>"Users Internal Error","trace"=>$exception->getMessage()],$response->getStatusCode());
        }

        $request->attributes->add(['user' => json_decode($response->getBody())]);

        return  $next($request);
    }
}