<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use JWTFactory;
use JWTAuth;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request){
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
}

