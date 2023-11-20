<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\TypePayment;
use App\Models\Bank;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

/**
*
* @OA\Server(url="http://localhost:8000")
*
*/

class PaymentController extends Controller
{
    
    /**
     * Lista los cobros de un usuario
     * @OA\Get (
     *     path="/api/mypayments",
     *     tags={"Cobros"},
     *  security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="ok",
     *         @OA\JsonContent(
     *         type="array",

     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="payment_id",
     *                         type="string",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="cantidad",
     *                         type="string",
     *                         example="2500.00"
     *                     ),
     *                     @OA\Property(
     *                         property="fecha_pago",
     *                         type="string",
     *                         example="2023-07-14 06:14:14"
     *                     ),
     *                     @OA\Property(
     *                         property="cliente_id",
     *                         type="string",
     *                         example="00554"
     *                     ),
     *                      @OA\Property(
     *                         property="tipo_abono",
     *                         type="string",
     *                         example="Efectivo"
     *                     ),
     *                      @OA\Property(
     *                         property="vendedor_id",
     *                         type="string",
     *                         example="6"
     *                     ),
     *   @OA\Property(
     *                         property="foto",
     *                         type="string",
     *                         example="http://domain/api/payments/photo/ddkdjdjadldfjldfadfdfsad.png"
     *                     ),
     *   @OA\Property(
     *                         property="observaciones",
     *                         type="string",
     *                         example="Cliente abona a factura no. xxxx"
     *                     ),
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $payments = Payment::where('vendedor_id','=', $request->user()->id)->orderBy('fecha_pago', 'desc')->paginate(10);

        return response()->json($payments);
    }
  
 
    /**
     * Crear cobro
     * @OA\Post (
     *     path="/api/payments",
     *     tags={"Cobros"}, 
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
    * description="cantidad",
    * property="cantidad",
    * type="string"
    * ),
        * @OA\Property(
    * description="cliente_id",
    * property="cliente_id",
    * type="string"
    * ),
    * @OA\Property(
    * description="foto de la visita",
    * property="foto",
    * type="string",
    * format="binary",
    * ),
            * @OA\Property(
    * description="tipo_abono",
    * property="tipo_abono",
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'cliente_id' =>'required|min:5',
            'tipo_abono' => 'required',
            'cantidad' =>'required',
            'foto' =>'sometimes|image',
            'observaciones' =>'required|min:5'
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()],400);
        }

        $payment = (new Payment)->fill($request->all());

        $payment->vendedor_id = $request->user()->id;

        if($request->hasFile('foto')){
            $payment->foto = URL::to('').'/api/payments/photo/'. $request->file('foto')->store('public');
         }

        $payment->save();

        return response()->json(['id' => $payment->id],201);
    }

    /**
     * Lista los tipos de abono
     * @OA\Get (
     *     path="/api/typepayments",
     *     tags={"Cobros"},
     *  security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="ok",
     *         @OA\JsonContent(
     *         type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="tipo_id",
     *                         type="string",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="descripcion",
     *                         type="string",
     *                         example="Efectivo"
     *                     ),
     *                  
     *             )
     *         )
     *     )
     * )
     */
    public function tipos_abonos(){
        $type_payments = TypePayment::paginate(10);

        return response()->json($type_payments);
    }


     /**
     * Lista los bancos para cobros
     * @OA\Get (
     *     path="/api/payments/banks",
     *     tags={"Cobros"},
     *  security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="ok",
     *         @OA\JsonContent(
     *         type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="string",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="descripcion",
     *                         type="string",
     *                         example="Banco BAC"
     *                     ),
     *                  
     *             )
     *         )
     *     )
     * )
     */
    public function bancos(){
        $banks = Bank::paginate(10);

        return response()->json($banks);
    }



    /**
     * Lista los tipos de abono v2 para pantalla de cobros
     * @OA\Get (
     *     path="/api/typepayments/payments",
     *     tags={"Cobros"},
     *  security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="ok",
     *         @OA\JsonContent(
     *         type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="tipo_id",
     *                         type="string",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="descripcion",
     *                         type="string",
     *                         example="Efectivo"
     *                     ),
     *                  
     *             )
     *         )
     *     )
     * )
     */
    public function tipos_abonos_cobros(){
        $type_payments = TypePayment::whereNotIn(strtoupper('descripcion'), ['CREDITO','CONTADO'] )->paginate(10);

        return response()->json($type_payments);
    }

     /**
     * Obtener foto del cobro
     * @OA\Get (
     *     path="/api/payments/photo/{path}",
     *     tags={"Cobros"},
    
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
}
