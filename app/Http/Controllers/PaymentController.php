<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\TypePayment;
use Validator;

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
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $payments = Payment::where('vendedor_id','=', $request->user()->id)->paginate(10);

        return response()->json($payments);
    }

 
   /**
     * Registrar cobro
     * @OA\Post (
     *     path="/api/payments",
     *     tags={"Cobros"},
    *@OA\RequestBody(
    *  @OA\JsonContent(
    *    type="object",
    *    @OA\Property(property="cantidad", type="string"),
    *    @OA\Property(property="cliente_id", type="string"),
    *    @OA\Property(property="tipo_abono", type="string"),
    *  )
    *),
     *  security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=201,
     *         description="ok",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="string", example="6"),
 
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'cliente_id' =>'required|min:5',
            'tipo_abono' => 'required',
            'cantidad' =>'required'
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()],400);
        }

        $payment = (new Payment)->fill($request->all());

        $payment->vendedor_id = $request->user()->id;

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
}
