<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

  /**
     * Listar y buscar productos
     * @OA\Get (
     *     path="/api/products",
     *     tags={"Productos"},
     *  security={ {"sanctum": {} }},
     *  @OA\Parameter(
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
    public function search(Request $request){
        $filtro =$request->Input('filtro');

        if( $filtro == ''){
            $data = Product::on('sqlsrvchips')->paginate(10);
            if($data->total() > 0){
                return $data;
            }
            return response()->json(["error" => 'Not found'],404);
        }else{

            $data = Product::on('sqlsrvchips')
            ->where('Producto','LIKE','%'. $filtro.'%')
            ->orWhere('Descripcion', 'like', '%' . $filtro . '%')->paginate(10);
            if($data->total() > 0){
                return $data;
            }
            return response()->json(["error" => 'Not found'],404);
        }
    }
}
