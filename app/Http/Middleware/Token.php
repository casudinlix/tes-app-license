<?php

namespace App\Http\Middleware;

use Closure;
use Curl\Curl;

class Token
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
        $curl = new Curl();
        // $curl->setHeader('token', env('API_TES'));
        $curl->get('http://api.dzc.my.id/token', array(
            'token' => env('API_TES'),

        ));
        $res = $curl->response;

        if ($res->result == false) {
            $res = array('code' => 401, 'message' => 'Token  invalid', 'server Reply' => $res->msg);
            return response()->json($res, 401);
        }

        return $next($request);
    }
}
