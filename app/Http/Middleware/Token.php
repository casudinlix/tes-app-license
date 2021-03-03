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

        $curl->post('http://service-jbap.test/tes.php', array(
            'token' => env('API_TES'),

        ));
        $res = json_decode($curl->response, true);

        if ($res['result'] == false) {
            $res['error'] = array(array('code' => 401, 'message' => 'Token  invalid'));
            return response($res, 401);
        }

        return $next($request);
    }
}
