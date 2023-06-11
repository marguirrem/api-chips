<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;


class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $visitas = Visit::all();
        return $visitas;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'observaciones' =>'required|min:5',
            'latitud' => 'required',
            'longitud' => 'required',
            'user_id' => 'required',
            'foto' =>'image'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());

        }


        $visita = (new Visit)->fill($request->all());


        if($request->hasFile('foto')){
           $visita->foto =  $request->file('foto')->store('public');
        }
       

        return $visita;
        /*$visita->save();

        return response()->json(['visita' => $visita],201);*/
    }


    public function getImage($path){
        $image = Storage::get($path);
        //dd (Storage::response($image));
        return response($image, 200)->header('Content-Type', 'image/jpg');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        //
    }
}
