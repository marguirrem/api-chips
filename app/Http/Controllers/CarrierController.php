<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrier;

class CarrierController extends Controller
{
       /**
    * Listar transportistas
    * @OA\Get (
    *     path="/api/carriers",
    *     tags={"Transportistas"},
    *  security={ {"sanctum": {} }},
    * @OA\Parameter(
    *         in="query",
    *         name="filtro",
    *        
    *         @OA\Schema(type="string")
    *     ),
    * @OA\Response(response=200,description="successful operation",
    *          @OA\MediaType(mediaType="application/json")
    *      ),
    * @OA\Response(response=404, description="Resource Not Found",
    * 
    *  @OA\JsonContent(
    *                     @OA\Property(
    *                         property="error",
    *                         type="string",
    *                         example="Not found"
    *                     )
    *                 
    *         )
    * ),
    *)
    */
    public function index(Request $request)
    {
        $filtro =$request->Input('filtro');

        if( $filtro == ''){
            $data = Carrier::on('sqlsrvchips')->paginate(10);
            if($data->total() > 0){
                return $data;
            }
            return response()->json(["error" => 'Not found'],404);
        }else{

            $data = Carrier::on('sqlsrvchips')
            ->where('Nombre','LIKE','%'. $filtro.'%')
            ->orWhere('Direccion', 'like', '%' . $filtro . '%')->paginate(10);
            if($data->total() > 0){
                return $data;
            }
            return response()->json(["error" => 'Not found'],404);
        }
    } 
}
