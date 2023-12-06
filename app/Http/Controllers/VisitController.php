<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

/**
* @OA\Info(
*             title="Pedidos Chips", 
*             version="1.0",
*             description="Api Pedidos Chips"
* )
*
* @OA\Server(url="http://localhost:8000")
*
*/


class VisitController extends Controller
{
   
 
    /**
     * Crear visita
     * @OA\Post (
     *     path="/api/visits",
     *     tags={"Visitas"}, 
     *  security={ {"sanctum": {} }},
     *  @OA\RequestBody(
    * @OA\MediaType(
    * mediaType="multipart/form-data",
    * @OA\Schema(
    * type="object",
        * @OA\Property(
    * description="observaciones",
    * property="observaciones",
    * type="string"
    * ),
        * @OA\Property(
    * description="latitud",
    * property="latitud",
    * type="string"
    * ),
        * @OA\Property(
    * description="longitud",
    * property="longitud",
    * type="string"
    * ),
    * @OA\Property(
    * description="foto de la visita",
    * property="foto",
    
    * type="string",
    * format="binary",
    * ),
    * )
    * )
    * ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *                     @OA\Property(
     *                         property="id",
     *                         type="string",
     *                         example="22"
     *                     )
     *                 
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'observaciones' =>'required|min:5',
            'latitud' => 'required',
            'longitud' => 'required',
            
            'foto' =>'sometimes|image'
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()],400);
        }

        $visita = (new Visit)->fill($request->all());

        $visita->user_id = $request->user()->id;

        if($request->hasFile('foto')){
           $visita->foto = URL::to('').'/api/visits/photo/'. $request->file('foto')->store('public');
        }
       
        $visita->save();

        return response()->json(['id' => $visita->id],201);
    }
    
    /**
     * Obtener foto de visita
     * @OA\Get (
     *     path="/api/visits/photo/{path}",
     *     tags={"Visitas"},
    
     *  @OA\Parameter(
     *         in="path",
     *         name="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     * @OA\Response(response=200,description="successful operation",
     *          @OA\MediaType(mediaType="application/json")
     *      ),
     * @OA\Response(response=400, description="Bad request"),
     * @OA\Response(response=404, description="Resource Not Found"),
     *)
     */
    public function getImage($path){
        $image = Storage::get($path);
        //dd (Storage::response($image));
        return response($image, 200)->header('Content-Type', 'image/jpg');
    }
  

    /**
     * Lista todas las visitas de un usuario
     * @OA\Get (
     *     path="/api/myvisits",
     *     tags={"Visitas"},
     *  security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="ok",
     *         @OA\JsonContent(
     *         type="array",

     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="observaciones",
     *                         type="string",
     *                         example="Visita realizada hoy."
     *                     ),
     *                     @OA\Property(
     *                         property="latitud",
     *                         type="string",
     *                         example="231231231"
     *                     ),
     *                     @OA\Property(
     *                         property="longitud",
     *                         type="string",
     *                         example="342342333"
     *                     ),
     *                     @OA\Property(
     *                         property="foto",
     *                         type="string",
     *                         example="public/ci9nAbrct9qqm9f3EPRC9djpk6b55Qy6eflfbagD.png"
     *                     )
     *                 
     *             )
     *         )
     *     )
     * )
     */
    public function myVisits(Request $request){

        $data = $request->user()->visitas()->orderBy('created_at', 'desc')->Paginate(10);
        $data = json_encode($data);
        $data = json_Decode($data);
        
       /*
        foreach ( $data->data as $item) {
            $item->foto = URL::to('').'/api/visits/photo/'. $item->foto;
        }*/

        return response()->json($data);
        
    }
}
