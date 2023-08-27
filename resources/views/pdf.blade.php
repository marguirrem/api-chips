<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
     <style>
        .img{
            width:200px;
            height: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row " style="text-align: center;">

            <div class="col-md-2">
                <img src="{{ asset('images/logo_chipsa.webp') }}" class="border"  alt="logo" style="with:50px; height:50px;border-radius:10px;">
            </div>
            
            <div class="col-md-10">
                <h1>- DETALLE DEL PEDIDO - <br>
                    {{$sale->created_at}}
                </h1>
            </div>
             
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
            <b>Numero de Documento/#:</b><br>
            <b>{{$sale->invoice_code}}</b>
            </div>
            <div class="col-md-6">
            <b>Clinte:</b> <br>
            <b>{{$sale->client_id}} / {{$cliente[0]->RazonSocial}} </b>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
            <b>Forma de Pago:</b><br>
            <b>{{$sale->forma_pago}}</b>
            </div>
            <div class="col-md-6">
            <b>Transporte:</b> <br>
            <b>{{$sale->transporte}}</b>
            </div>
        </div>
        <br>

    <br>
        <div class="row border">
            <div class="col-md-2">
                <b>Cantidad</b>
            </div>
            <div class="col-md-2">
                <b>Item</b>
            </div>
            <div class="col-md-4">
                <b>Producto</b>
            </div>
            <div class="col-md-2">
                <b>Precio</b>
            </div>
            <div class="col-md-2">
                <b>Total</b>
            </div>
        </div>
        @foreach ($sale->items as $item)
        <div class="row border">

            <div class="col-md-2">
                {{$item->quantity}}
            </div>
            <div class="col-md-2">
                {{$item->product_id}}
            </div>
            <div class="col-md-4">
                {{$item->nombre}}
            </div>
            <div class="col-md-2">
                {{$item->price}}
            </div>
            <div class="col-md-2">
                {{$item->price * $item->quantity}}
            </div>
        </div>
        @endforeach

    <br>
    <div >
        <div class="row border">
            <div class="col-md-9 border">
                <b>Observaciones</b>
            </div>

            <div class="col-md-3">
                <b>Attachment</b> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 border">
                {{$sale->notes}}
            </div>

            <div class="col-md-3 border">
               
                    @if (str_contains($sale->attachment, 'data:image'))
                    <?php printf('<img src="%s" class="img" />', $sale->attachment);?>
                    @else
                        <?php printf('<img src="data:image/png;base64,%s" class="img" />', $sale->attachment)?>
                    @endif
                
            </div>
        </div>

    </div>
      
    <br>
    <div class="border" style="text-align: center; padding:20px;margin-buttom:20px;">
        Realizado por {{$sale->user->firstname }} {{$sale->user->lastname }}
    </div>
    
    </div>  
   </body>
</html>