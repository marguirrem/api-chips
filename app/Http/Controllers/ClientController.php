<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

/**

* @OA\Server(url="http://ec2-107-20-22-188.compute-1.amazonaws.com")
*
*/


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$data = Time::on('mysql_timer')->with(['user'])->paginate($length);
        
        //$clients = \DB::connection('sqlsrvchips')->table('clients')->get();
        $data = Client::on('sqlsrvchips')->selectRaw("TRIM(Cliente) AS Cliente, TRIM(IDTributario) AS IDTributario, TRIM(RazonSocial) AS RazonSocial, FORMAT(CreditoLimite, 'C', 'es-gt') AS CreditoLimite, CAST(Saldo AS INT) AS Saldo")->paginate(10);

        return $data;
    } 

    
    /**
     * Buscar clientes
     * @OA\Get (
     *     path="/api/clients/search/{value}",
     *     tags={"Clientes"},
    
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
      
        $data = Client::on('sqlsrvchips')->selectRaw("TRIM(Cliente) AS Cliente, TRIM(IDTributario) AS IDTributario, TRIM(RazonSocial) AS RazonSocial,Direccion as Direccion, FORMAT(CreditoLimite, 'C', 'es-gt') AS CreditoLimite, CAST(Saldo AS INT) AS Saldo")
        ->where('Cliente','LIKE','%'. $value.'%')
        ->orWhere('NombreComercial', 'like', '%' . $value . '%')->with('invoices')->paginate(10);

        if($data->total() > 0){
            return $data;
        }
        return response()->json(["error" => 'Not found'],404);
    }

}
