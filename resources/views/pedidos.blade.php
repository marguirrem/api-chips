<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .fondo{
            background-color:#925bab;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
    <div class="container" >
        <h1 class="fondo">Pedidos</h1>
        <table class="table">
            <thead class="fondo table">
                <th>Id</th>
                <th>Factura</th>
                <th>Código Cliente</th>
                <th>Notas</th>
                <th>Total</th>
                <th>Fecha creación</th>
                <th>Geolocalización</th>
                <th>Archivo adjunto</th>
            </thead>
            <tbody >
                @foreach ($sales as $sale)
                    <tr class="table">
                        <td>{{$sale->id}}</td>
                        <td>{{$sale->invoice_code}}</td>
                        <td>{{$sale->client_id}}</td>
                        <td>{{$sale->notes}}</td>
                        <td>{{$sale->total}}</td>
                        <td>{{$sale->created_at}}</td>
                        <td>{{$sale->geolocalizacion}}</td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> 
</body>
</html> 