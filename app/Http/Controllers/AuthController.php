<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\Models\User;
use \stdClass;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register (Request $request){
        $validator = Validator::make($request->all(),[
            'name' =>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());

        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' =>Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json (['data'=>$user,'access_token' => $token,'token_type' =>'Bearer',]);

    }

    public function login(Request $request){

        //$user es una coleccion
        $user = User::where('username',$request['username'])->get();

        if($user->isEmpty()){
            return response()->json(['message'=>'User not found'],404);

        }else{
          
            if($user[0]->password != md5($request['password'])){

                return response()->json(['message'=>'Unauthorized'],401);
    
            }
        }


        //$user = User::where('email',$request['email'])->firstOrFail();

        $token = $user[0]->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token,'user'=>$user[0]]);
    }
}
