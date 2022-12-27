<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Auth;
use Hash;

class Icontroller extends Controller
{
    // register function
    function register(Request $request){

        // requesting feilds from api
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>\Hash::make($request->password)
        ]);

        $token=$user->createToken('Token')->accessToken;
        return response()->json(['token'=>$token],200);
    }

    // login function
    function login(Request $request){
        $data=[
            'email'=>$request->email,
            'password'=>$request->password
        ];
        if(Auth::attempt($data))
        {
            $token=Auth::user()->createToken('Token')->accessToken;
            return response()->json(['token'=>$token],200);
        }
        else{
            return response()->json(['error'=>'auth not found']);
        }
    }

    // user info function
    function userinfo(){
        $user=Auth::user();
        return response()->json(['users'=>$user]);
    }
}
