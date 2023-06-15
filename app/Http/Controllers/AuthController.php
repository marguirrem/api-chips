<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\Models\User;
use \stdClass;
use Illuminate\Support\Facades\Hash;

/**
*
* @OA\Server(url="http://ec2-107-20-22-188.compute-1.amazonaws.com")
*
*/

class AuthController extends Controller
{
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

     /**
     * Iniciar Sesión
     * @OA\Post (
     *     path="/api/login",
     *     tags={"Login"},
     * @OA\Parameter(
     *         in="query",
     *         name="username",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     * @OA\Parameter(
     *         in="query",
     *         name="password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *  security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="ok",
     *         @OA\JsonContent(
     *       
     *             @OA\Property(property="access_token", type="string", example="4|i3hT5WlPnrA6D3ulyyfLx7PaTYSuIpLO4eOpAasr"),
     *             @OA\Property(
     *              property="user",
     *              type="object",
     * 
     *                     @OA\Property(
     *                         property="id",
     *                         type="string",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="firstname",
     *                         type="string",
     *                         example="Estaurdo"
     *                     ),
     *                     @OA\Property(
     *                         property="middlename",
     *                         type="string",
     *                         example="Luis"
     *                     ),
     *                     @OA\Property(
     *                         property="lastname",
     *                         type="string",
     *                         example="Perez"
     *                     ),
     *                 @OA\Property(
     *                         property="username",
     *                         type="string",
     *                         example="mperez"
     *                     ),
     *                      @OA\Property(
     *                         property="avatar",
     *                         type="string",
     *                         example="perfil.png"
     *                     ),
     *                      @OA\Property(
     *                         property="last_login",
     *                         type="string",
     *                         example="2023-05-12"
     *                     ),
     *                      @OA\Property(
     *                         property="type",
     *                         type="number",
     *                         example="2"
     *                     ),
     *                      @OA\Property(
     *                         property="date_added",
     *                         type="string",
     *                         example="2023-05-26 16:58:06"
     *                     ),
     *                      @OA\Property(
     *                         property="date_updated",
     *                         type="string",
     *                         example="2023-05-26 16:58:23"
     *                     ),
     *                      @OA\Property(
     *                         property="fullname",
     *                         type="string",
     *                         example="Estuardo Luis Perez"
     *                     ),
     *                      @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="example@example.com"
     *                     ),
     *                      @OA\Property(
     *                         property="email_verified_at",
     *                         type="string",
     *                         example="2023-05-26 16:58:23"
     *                     )
     * 
     * 
     *             )
     *         )
     *     )
     * )
     */

    public function login(Request $request){

        //$user es una coleccion
        $user = User::where ([
            ['username', '=', $request['username']]
           
        ])->get();

        if($user[0]->type == 1){
            return response()->json(['message'=>'Unauthorized'],401);
        }
        //$user = User::where('username',$request['username'])->get();
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
