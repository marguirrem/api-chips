<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
    * Listar productos
    * @OA\Get (
    *     path="/api/products",
    *     tags={"Productos"},
    *  security={ {"sanctum": {} }},
    
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
    public function index()
    {
        $data = Product::on('sqlsrvchips')->paginate(10);

        return $data;
    } 

  /**
     * Buscar productos
     * @OA\Get (
     *     path="/api/products/search/{value}",
     *     tags={"Productos"},
     *  security={ {"sanctum": {} }},
     *  @OA\Parameter(
     *         in="path",
     *         name="value",
     *         required=true,
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
    public function search($value){
      
        $data = Product::on('sqlsrvchips')
        ->where('Producto','LIKE','%'. $value.'%')
        ->orWhere('Descripcion', 'like', '%' . $value . '%')->paginate(10);

        if($data->total() > 0){
            return $data;
        }
        return response()->json(["error" => 'Not found'],404);
    }
}
