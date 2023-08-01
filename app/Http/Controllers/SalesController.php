<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Sales;

class SalesController extends Controller
{
    //
    public function getImage($saleId){
        $productID=explode(".",$saleId);

        //return Sales::all()->find($saleId);
        $rendered_buffer= Sales::all()->find($saleId)->attachment;
        if($rendered_buffer == ''){
            return response()->json(['message'=>'Not found'],404);
        }
        $base64 = base64_encode(file_get_contents($rendered_buffer));
        $response = Response::make($base64);
        $response->header('Content-Type', 'image/png');
        return $response;
    }
}
