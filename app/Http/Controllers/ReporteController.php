<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\SalesItems;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class ReporteController extends Controller
{
    
    public function pedidos(Request $request){  

        set_time_limit(0);
        $userId = $request->query('userId');
        $fecha = $request->query('fecha');

        //dd($fecha);
        $sales = Sales::with('items')->where('user_id','=',$userId)->whereDate('created_At','=',$fecha)->get();

        //dd($sales);
        foreach($sales as $sale){

            $client =Client::on('sqlsrvchips')->selectRaw("TRIM(Cliente) AS Cliente, TRIM(IDTributario) AS IDTributario, TRIM(RazonSocial) AS RazonSocial, FORMAT(CreditoLimite, 'C', 'es-gt') AS CreditoLimite, CAST(Saldo AS INT) AS Saldo")->where('Cliente','=',$sale->client_id)->get();

            foreach($sale->items as $itm){
                $product = Product::on('sqlsrvchips')->where('Producto','=', $itm->product_id)->get();
                  
                $itm->nombre = $product[0]->Descripcion;
            }
        }

        return $sales;

    }
}
