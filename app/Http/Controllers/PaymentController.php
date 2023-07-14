<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Validator;

class PaymentController extends Controller
{
    
    public function index(Request $request)
    {
        $payments = Payment::where('vendedor_id','=', $request->user()->id)->paginate(10);

        return response()->json($payments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
