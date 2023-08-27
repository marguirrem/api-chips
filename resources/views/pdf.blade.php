<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
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
        <table class="table table-bordered">
            <thead>
                <th>Cantidad</th>
                <th>Item</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Total</th>
            </thead>
            <tbody>
                @foreach ($sale->items as $item)
                <tr>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->product_id}} </td>
                    <td>{{$item->nombre}}</td>
                    <td>{{$item->price}}</td>
                    <td> {{$item->price * $item->quantity}}</td>
                </tr>
                @endforeach
  
            </tbody>
        </table>
    <br>
    <br>
    <div class="">
        <div class="row border">
            <div class="col-md-9 border">
                <th><b>Observaciones</b></th>
            </div>

            <div class="col-md-3">
                <th><b>Attachment</b></th>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 border">
                <td>{{$sale->notes}}</td>
            </div>

            <div class="col-md-3 border">
                <td>
                    @if (str_contains($sale->attachment, 'data:image'))
                    <?php printf('<img src="%s" class="img" />', $sale->attachment);?>
                    @else
                        <?php printf('<img src="data:image/png;base64,%s" class="img" />', $sale->attachment)?>
                    @endif
                </td>
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