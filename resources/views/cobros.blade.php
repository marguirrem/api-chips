
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <br>
    <br>
    <br>


        <h1 style="background-color:red;">Cobros</h1>

        <table class="table">
            <thead class="fondo">
                <th>Id</th>
                <th>Recibo</th>
                <th>Código Cliente</th>
                <th>Tipo de abono</th>
                <th>Observaciones</th>
                <th>Cantidad</th>
                <th>Fecha pago</th>
                <th>Banco</th>
                <th>Documento</th>
                <th>Fecha documento</th>
                <th>Fotografía</th>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td class="cell" >{{$payment->payment_id}}</td>
                        <td>{{$payment->recibo}}</td>
                        <td>{{$payment->tipo_abono}}</td>
                        <td>{{$payment->observaciones}}</td>
                        <td>{{$payment->cantidad}}</td>
                        <td>{{$payment->banco}}</td>
                        <td>{{$payment->documento}}</td>
                        
                        <td>{{$payment->fechadocumento}}</td>
                        <td>{{$payment->geolocalizacion}}</td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
 




  
</html> 