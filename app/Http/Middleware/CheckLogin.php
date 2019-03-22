<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset($_COOKIE['xnn_uid']) && isset($_COOKIE['xnn_token'])){
            //验证token
            $key = 'token:' . $_COOKIE['xnn_uid'];
            $token = Redis::get($key);
            if($token == $_COOKIE['xnn_token']){
                $request->attributes->add(['is_login'=>1]);
            }else{
                $request->attributes->add(['is_login'=>0]);
            }
        }else{
            $request->attributes->add(['is_login'=>0]);
        };
        return $next($request);
    }
}
