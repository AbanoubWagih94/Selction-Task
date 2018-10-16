<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTFactory;
use JWTAuth;
use Validator;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function store(Request $request) {
        // Validation
        $validator = Validator::make($request->all() ,
            [
                'email' => 'required|string|email|max:255',
                'password'=>'required'
            ]);
        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()], 401);
        } else {
            // Check if user exist
            $userdata = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($userdata)) {
                    return response()->json(['error'=> 'Unauthorized access'], 401);
                } else {
                    // Login
                    $user = User::find(auth()->user()->getAuthIdentifier());
                    // set token
                    /*$user->token = md5($user->email.$user->password.time());
                    $user->save();*/

                    return response()->json(['token'=>$token, 'userDate'=>$user], 200);
                }
            } catch (JWTException $e){
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
        }

    }
}
