<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request) {

        $validator      =       Validator::make($request->all(),
            [
                'email'               =>        'required|email',
                'password'            =>        'required|alpha_num|min:5'
            ]
        );

        if($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user       =       Auth::user();
            $token      =       $user->createToken('token')->accessToken;

            return response()->json(["status" => Response::HTTP_OK, "success" => true, "login" => true, "token" => $token]);
        }
        else {
            return response()->json(["status" => Response::HTTP_UNAUTHORIZED, "success" => false, "message" => "Login failed"]);
        }
    }

}
