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

        <p>Te enviamos el detalle de tu compra</p>

        {{-- {{ $objEnviarMail ['productos'] }} --}}

        <table>
            <tr>
                <td><strong>Nombre</strong></td>
                <td> </td>
                <td><strong>Cantidad</strong></td>
                <td> </td>
                <td><strong>Precio</strong></td>
                <td> </td>
                <td><strong>Subtotal</strong></td>
            </tr>

            @foreach ($objEnviarMail['ventaproductos'] as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td> </td>
                    <td>{{ $item['cantProduct'] }}</td>
                    <td> </td>
                    <td>{{ $item['priceProductTrust'] }}</td>
                    <td> </td>
                    <td>{{ $item['subtotal'] }}</td>
                </tr> 
            @endforeach

            <tfoot>          
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">TOTAL:</th>
                <th scope="col">$ {{ $objEnviarMail['total'] }}</th> 
              </tfoot>
        </table>

        <h5>Si querés ver información detallada de tu compra podes hacer <a href="{{ $objEnviarMail['urlEnviar'] }}">click aquí</a></h5>
        
    </body>
</html>

{{-- Hola {{ $data }}, los correos con Gmail funcionan --}}