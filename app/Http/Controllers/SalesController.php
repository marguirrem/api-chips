<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\SalesItems;

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
      $sales =  $request->user()->sales()->with('items')->Paginate(10);
      return $sales;
    }

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
    * description="status",
    * property="status",
    * type="string"
    * ),
            * @OA\Property(
    * description="tendered",
    * property="tendered",
    * type="string"
    * ),
            * @OA\Property(
    * description="is_guest",
    * property="is_guest",
    * type="string"
    * ),
            * @OA\Property(
    * description="delete_flag",
    * property="delete_flag",
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
    * description="bodega",
    * property="bodega",
    * type="string"
    * ),
    * @OA\Property(
    * description="foto del pedido",
    * property="foto",
    * type="string",
    * format="binary",
    * ),
    * @OA\Property(
    * description="item",
    * property="item",
    * type="array",
    *@OA\Items(
* @OA\Property(
    * description="product_id",
    * property="product_id",
    * type="string",
    *),
    * @OA\Property(
    * description="price",
    * property="price",
    * type="string",
    *)
    *)
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
        try{
        $Date = date("Y-m-d");  

        $sale = new Sales();
        $sale->invoice_code = str_replace("-","",$Date);
        $sale->client_id= $request['client_id'];
        $sale->notes = $request['notes'];
        $sale->total = $request['total'];
        $sale->status = $request['status'];
        $sale->tendered = $request['tendered'];
        $sale->is_guest = $request['is_guest'];
        $sale->user_id =$request->user()->id;
        $sale->delete_flag = $request['delete_flag'];
        $sale->geolocalizacion = $request['geolocalizacion'];
        $sale->forma_pago = $request['forma_pago'];
        $sale->transporte = $request['transporte'];
        $sale->bodega=$request['bodega'];
        if($request->hasFile('foto')){

            /*$file = $request->file('foto');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $sale->attachment = $contents;
            */
            $path = $request->file('foto')->getRealPath();
            $logo = file_get_contents($path);
            $base64 = base64_encode($logo);
            $sale->attachment = $base64;
        }
        $sale->save();


        foreach ($request['item'] as $valor) {
            $item = new SalesItems();
            $item->sales_id = $sale->id;
            $item->product_id = $valor['product_id'];
            $item->price = $valor['price'];
            $item->quantity = $valor['quantity'];
            $item->save();
      
        }
    }catch (\Exception $e ){
        return response()->json( $e,500);
    }
        return response()->json(['id' => $sale->id],201);

        /*
        $file = $request->file('image');

        // Get the contents of the file
        $contents = $file->openFile()->fread($file->getSize());
    
        // Store the contents to the database
        $user = App\User::find($id);
        $user->avatar = $contents;
        */
    }


}
