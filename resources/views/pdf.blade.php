<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        @page { 
            margin: 10px;
            size: 35cm 22cm landscape;
        }

        body {
             margin: 0px;
        }

        .img{
            width:200px;
            height: 200px;
        }

        .bordes{
            border:solid  1px;
            border-color:#eeeded;
        }
    </style>
</head>
<body>
    <div class="container" >

        <div class="" style="text-align: center;">
        <div class="" style=" width:150px; display:inline-block;"  >
                <img src="data:image/png;base64,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" class="border"  alt="logo" style="with:50px; height:50px;border-radius:10px;">
            </div>
       

            <div class="" style=" width:950px; display:inline-block; text-agling:left;">
                <h1>- DETALLE DEL PEDIDO - <br>
                    {{$sale->created_at}}
                </h1>
            </div>

        </div>
        <hr>
        <br>
        <div class="" style="text-align:center">
            <div class="" style=" width:500px; display:inline-block;">
            <b>Numero de Documento/#:</b><br>
                <b>{{$sale->invoice_code}}</b>
            </div>

            <div class="" style=" width:500px;display:inline-block;">
                <b>Clinte:</b> <br>
                <b>{{$sale->client_id}} / {{$cliente[0]->RazonSocial}} </b>
            </div>
        </div>


   
        <br>
        <div class="border" style="text-align:center">
            <div class="" style=" width:500px; display:inline-block;">
                <b>Forma de Pago:</b><br>
                <b>{{$sale->forma_pago}}</b>
            </div>

            <div class="" style=" width:500px;display:inline-block;">
                <b>Transporte:</b> <br>
                <b>{{$sale->transporte}}</b>
            </div>

         
        </div>

        <br>
        <div class="" style="text-align:center">
            <div class="bordes" style=" width:100px;display:inline-block;">
                <b>Cantidad</b>
            </div>
            <div class="bordes" style=" width:100px;display:inline-block;">
                <b>Item</b>
            </div>
            <div class="bordes" style=" width:400px;display:inline-block;">
                <b>Producto</b>
            </div>
            <div class="bordes" style=" width:100px;display:inline-block;">
                <b>Precio</b>
            </div>
            <div class="bordes" style=" width:400px;display:inline-block;">
                <b>Total</b>
            </div>
        </div>
        @foreach ($sale->items as $item)
        <div class="" style="text-align:center">

            <div class="bordes" style=" width:100px;display:inline-block;">
                {{$item->quantity}}
            </div>
            <div class="bordes" style=" width:100px;display:inline-block;">
                {{$item->product_id}}
            </div>
            <div class="bordes" style=" width:400px;display:inline-block;">
                {{$item->nombre}}
            </div>
            <div class="bordes" style=" width:100px;display:inline-block;">
                {{$item->price}}
            </div>
            <div class="bordes" style=" width:400px;display:inline-block;">
                {{$item->price * $item->quantity}}
            </div>
        </div>
        
        @endforeach
        <div class=" " style="text-align: center">
            <div class="" style=" width:100px;display:inline-block;">
                
            </div>
            <div class="" style=" width:100px;display:inline-block;">
              
            </div>
            <div class="" style=" width:400px;display:inline-block;">
               
            </div>
            <div class="" style=" width:100px;display:inline-block;">
               <b>Total</b>
            </div>
            <div class="bordes" style=" width:400px;display:inline-block;">
                <b>{{$sale->total}}</b>
            </div>
        </div>
        <br>
        <br>
        
            <div class="bordes" style="text-align:center">
                <div class="" style=" width:500px;display:inline-block;">
                    <b>Observaciones</b>
                </div>

                <div class="" style=" width:500px;display:inline-block;">
                    <b>Attachment</b>
                </div>
            </div>
            <div class="bordes" style="text-align:center">
                <div class="" style=" width:500px;display:inline-block; ">
                   <p>{{$sale->notes}}</p> 
                </div>

                <div class="" style=" width:500px;display:inline-block; ">
                     <br>
                     <br>
                     <br>
                        @if (str_contains($sale->attachment, 'data:image'))
                        <img src="{{$sale->attachment}}" alt="attachment" class="img">
                       
                        @else
                            <img src="data:image/png;base64,{{$sale->attachment}}" alt="">
                  
                        @endif
                    
                </div>
            </div>

       

        <br>
        <div class="bordes" style="text-align: center; padding:20px;margin-buttom:20px;">
            Realizado por {{$sale->user->firstname }} {{$sale->user->lastname }}
        </div>

    </div> 
</body>
</html> 