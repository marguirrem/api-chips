<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\SalesItems;
use App\Models\Client;
use App\Models\Product;
use Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Controller
{
    //
  /**
     * Listar mis pedidos
     * @OA\Get (
     *     path="/api/myorders",
     *     tags={"Pedidos"},
     *  security={ {"sanctum": {} }},
     * @OA\Response(response=200,description="successful operation",
     *          @OA\MediaType(mediaType="application/json")
     *      ),
     * @OA\Response(response=404, description="Resource Not Found",
     * 
     * ),
     *)
     */ 
    public function index(Request $request){
      $sales =  $request->user()->sales()->orderBy('created_at', 'desc')->with('items')->Paginate(10);
      return $sales;
    }

    /**
     * Ver foto de un pedido por id de registro
     * @OA\Get (
     *     path="/api/sales/photo/{id}",
     *     tags={"Pedidos"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *        
     *     ),
     * )
     **/
    public function getImage($saleId){
       
        $rendered_buffer= Sales::all()->find($saleId)->attachment;
        if($rendered_buffer == ''){
            return response()->json(['message'=>'Not found'],404);
        }

        if (str_contains($rendered_buffer, 'data:image')) {
            return printf('<img src="%s" />', $rendered_buffer);
        }else{
            return printf('<img src="data:image/png;base64,%s" />', $rendered_buffer);
        }
    }

     /**
     * Crear Pedido
     * @OA\Post (
     *     path="/api/orders",
     *     tags={"Pedidos"}, 
     *  security={ {"sanctum": {} }},
     *  @OA\RequestBody(
    * @OA\MediaType(
    * mediaType="multipart/form-data",
    * @OA\Schema(
    * type="object",
        * @OA\Property(
    * description="client_id",
    * property="client_id",
    * type="string"
    * ),
        * @OA\Property(
    * description="notes",
    * property="notes",
    * type="string"
    * ),
        * @OA\Property(
    * description="total",
    * property="total",
    * type="string"
    * ),
    * @OA\Property(
    * description="geolocalizacion",
    * property="geolocalizacion",
    * type="string"
    * ),
    * @OA\Property(
    * description="forma_pago",
    * property="forma_pago",
    * type="string"
    * ),
    * @OA\Property(
    * description="transporte",
    * property="transporte",
    * type="string"
    * ),
    * @OA\Property(
    * description="foto del pedido",
    * property="foto",
    * type="string",
    * format="binary",
    * ),
    * @OA\Property(
    * description="items",
    * property="items",
    * type="string"
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
    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'client_id' =>'required',
            'notes' => 'required',
            'total' => 'required',
            'geolocalizacion' => 'required',
            'forma_pago' => 'required',
            'transporte' => 'required',
            'items' => 'required',
            'foto' =>'sometimes|image'
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()],400);
        }

        try {
        $Date = date("Y-m-d");  

        $count = Sales::whereDate('created_at', DB::raw('CURDATE()'))->count();;
     
        $count+=1;

        $correlativo = $Date.str_pad($count, 3, "0", STR_PAD_LEFT); 
    

        $sale = new Sales();
        $sale->invoice_code = str_replace("-","",$correlativo);
        $sale->client_id= $request['client_id'];
        $sale->notes = $request['notes'];
        $sale->total = $request['total'];
        $sale->status = "0";
        $sale->tendered = "0";
        $sale->is_guest = "0";
        $sale->user_id =$request->user()->id;
        $sale->delete_flag = "0";
        $sale->geolocalizacion = $request['geolocalizacion'];
        $sale->forma_pago = $request['forma_pago'];
        $sale->transporte = $request['transporte'];
        $sale->bodega = "0";

        if($request->hasFile('foto')){

            $path = $request->file('foto')->getRealPath();
            $logo = file_get_contents($path);
            $base64 = base64_encode($logo);
            $sale->attachment = $base64;
        }

        $sale->save();

        $items = json_decode($request['items']);
        if($items!=null){
            foreach($items as $valor){
                $item = new SalesItems();
                $item->sales_id = $sale->id;
                $item->product_id = str_pad($valor->product_id, 6, "0", STR_PAD_LEFT);  
                $item->price = $valor->price;
                $item->quantity = $valor->quantity;
                $item->save();
            }
        }
    }catch (\Exception $e ){
        return response()->json( $e,500);
    }
        return response()->json(['id' => $sale->id],201);
    }


    
    /**
     * Descargar pdf con detalle del pedido con  id de registro
     * @OA\Get (
     *     path="/api/pdf/{id}",
     *     tags={"Pedidos"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK" dfsafdsa fasd 
     *        
     *     ),
     * )
     **/
    public function pdf($id){
        set_time_limit(0);
        $sale = Sales::with('items')->findOrFail($id);
        $client =Client::on('sqlsrvchips')->selectRaw("TRIM(Cliente) AS Cliente, TRIM(IDTributario) AS IDTributario, TRIM(RazonSocial) AS RazonSocial, FORMAT(CreditoLimite, 'C', 'es-gt') AS CreditoLimite, CAST(Saldo AS INT) AS Saldo")->where('Cliente','=',$sale->client_id)->get();

        foreach($sale->items as $itm){
            $product = Product::on('sqlsrvchips')->where('Producto','=', $itm->product_id)->get();
              
            $itm->nombre = $product[0]->Descripcion;
        }
       
        $pdf = Pdf::loadView('pdf', ['sale' => $sale,'cliente'=>$client]);
        //$pdf->render();
        // download PDF file with download method

        return $pdf->download('pedido_'.$id);
        //return view('pdf', ['sale' => $sale,'cliente'=>$client]);
    }

}