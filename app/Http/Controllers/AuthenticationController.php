<?php

namespace App\Http\Controllers;

use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use JWTFactory;
use JWTAuth;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function register(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);

        // check if email exist
        $exist = User::where('email', $request->email)->first();

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);
        } else {
            if(!$exist){
                // create new user
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                ]);

                $token = JWTAuth::fromUser($user);
                return response()->json(['token'=>$token, 'userData'=>$user], 200);
            } else {
                return response()->json(['error'=>'Email already exist'], 401);
            }
        }
    }

    public function login(Request $request){
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
