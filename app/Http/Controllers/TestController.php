<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $req)
    {
        $token = "123456";
        if ($req->token != $token) {
            $data = [
                'result' => false,
                'data' => null,
                'msg' => 'token Not Valid'
            ];
        } else {
            $data = [
                'result' => true,
                'data' => [
                    'data' => 'token valid', 'sip' => 'xxxx'
                ],
                'msg' => 'success'
            ];
        }

        return response()->json($data);
    }
}
