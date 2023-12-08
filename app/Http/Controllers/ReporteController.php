<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\SalesItems;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ReportExport;

class ReporteController extends Controller
{
    
    //
    /**
     * Listar pedidos
     * @OA\Get (
     *     path="/api/reporte/productividad",
     *     tags={"Reporte"},
     *  security={ {"sanctum": {} }},
     * @OA\Response(response=200,description="successful operation",
     *          @OA\MediaType(mediaType="application/json")
     *      ),
     * @OA\Response(response=404, description="Resource Not Found",
     * 
     * ),
     *)
     */ 
    public function pedidos(Request $request){  

        set_time_limit(0);
        $userId = $request->query('userId');
        $fecha = $request->query('fecha');

        if($request->query('fecha')){
            return (new ReportExport($request->user()->id,$request->user()->username,$fecha))->download('reporte_'.$fecha.'.xlsx');
           //return (new ReportExport(5,"mar",$fecha))->download('reporte_'.$fecha.'.xlsx');
        }
        //dd($fecha);
       // $sales = Sales::with('items')->where('user_id','=',$request->user()->id)->whereDate('created_At','=',Carbon::today())->get();

        //dd($sales);
        /*        foreach($sales as $sale){

            $client =Client::on('sqlsrvchips')->selectRaw("TRIM(Cliente) AS Cliente, TRIM(IDTributario) AS IDTributario, TRIM(RazonSocial) AS RazonSocial, FORMAT(CreditoLimite, 'C', 'es-gt') AS CreditoLimite, CAST(Saldo AS INT) AS Saldo")->where('Cliente','=',$sale->client_id)->get();

            foreach($sale->items as $itm){
                $product = Product::on('sqlsrvchips')->where('Producto','=', $itm->product_id)->get();
                  
                $itm->nombre = $product[0]->Descripcion;
            }
        }
        */
        //return $sales;

        //return view('pedidos', ['sales' =>$sales ]);

//        $pdf = Pdf::loadView('pedidos', ['sales' => $sales]);
        //$pdf->render();
        // download PDF file with download method

       
        return (new ReportExport($request->user()->id,$request->user()->username,Carbon::today()))->download('reporte_'.Carbon::today().'.xlsx');
       //return (new ReportExport(5,"mar",Carbon::today()))->download('reporte_'.Carbon::today().'.xlsx');

        //return $pdf->download('pedidos_'. $request->user()->username);

    }
}
