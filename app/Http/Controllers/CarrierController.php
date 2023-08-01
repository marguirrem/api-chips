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
        $data = Carrier::on('sqlsrvchips')->paginate(10);

        return $data;
    } 
}
