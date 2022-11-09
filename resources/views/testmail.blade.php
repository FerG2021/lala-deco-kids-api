<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Lala Deco Kids</title>
    </head>
    <body>
        <h4>Buenos días, <b>{{ $objEnviarMail['nombreCliente'] }}</b></h4>

        <p>Te enviamos el detalle de tu cuenta corriente</p>

        {{-- {{ $objEnviarMail ['productos'] }} --}}

        <table>
            <tr>
                <td><strong>Fecha</strong></td>
                <td>-</td>
                <td><strong>Venta</strong></td>
                <td>-</td>
                <td><strong>Entregado</strong></td>
                {{-- <td>-</td>
                <td><strong>Subtotal</strong></td> --}}
            </tr>

            @foreach ($objEnviarMail['datosCuentaCorriente'] as $item)
                <tr>
                    <td>{{ $item['date'] }}</td>
                    <td>-</td>
                    <td>{{ $item['pay'] }}</td>
                    <td>-</td>
                    <td>{{ $item['sale'] }}</td>
                    {{-- <td>-</td>
                    <td>{{ $item['observaciones'] }}</td> --}}
                </tr> 
            @endforeach

            <tfoot>          
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">TOTAL:</th>
                <th scope="col">{{ $objEnviarMail['balance'] }}</th> 
              </tfoot>
        </table>

        <h5>Si querés ver información detallada de tu cuenta corriente podes hacer <a href="{{ $objEnviarMail['urlEnviar'] }}">click aquí</a></h5>
        
    </body>
</html>

{{-- Hola {{ $data }}, los correos con Gmail funcionan --}}