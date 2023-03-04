<!DOCTYPE html>
<html lang="es">
    <head>
      <meta charset="UTF-8">
      <title>Lala Deco Kids - Comprobante de venta</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    </head>


    <body>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <div>
          <h1 style="text-align: center; font-size: 20px">Lala Deco Kids - Compobante de cuenta corriente</h1>
        </div>

        <div>
          <div>
            <label for=""><b><u>Datos del cliente:</u></b></label>
          </div>

          <div style="margin-top: 20px">
            <label for=""><u>Nombre:</u> {{ $cuentaCorrienteDB->nameClient }}</label>
          </div>

          <div>
            <label for=""><u>Apellido:</u> {{ $cuentaCorrienteDB->lastNameClient }}</label>
          </div>

          <div>
            <label for=""><u>Fecha:</u> {{ $today }}</label>
          </div>
        </div>

        <div style="margin-top: 20px">
          <table class="table table-striped text-center" >
            <thead>
              <tr>
                <th 
                  scope="col" 
                  style="background-color: #c7c7c7"
                >
                  Fecha
                </th>                       
                
                <th scope="col" style="background-color: #c7c7c7
                ">
                  Pago
                </th>
                
                <th scope="col" style="background-color: #c7c7c7
                ">
                  Compra
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($cuentaCorrienteDetalleDB as $cuentaCorrienteDetalle)
                <tr>
                  <td>{{ $cuentaCorrienteDetalle->date }}</td>                
                  <td>{{ $cuentaCorrienteDetalle->pay }}</td>
                  <td>{{ $cuentaCorrienteDetalle->sale }}</td>
                </tr style="margin-bottom: 10px">
                
              @endforeach
              
            </tbody>
            <tfoot>          
              <th scope="col"></th>
              <th scope="col">MONTO ADEUDADO:</th>
              <th scope="col">{{$cuentaCorrienteDB->balance}}</th> 
            </tfoot>
          </table>
        </div>

        <div>
          <h2 style="text-align: center; font-size: 20px">¡¡¡Muchas gracias por elegirnos!!!</h2>
        </div>



        {{-- <h1>Titulo de prueba</h1>
        <hr>
        <div class="contenido">
            <p id="primero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
            <p id="segundo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
            <p id="tercero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
        </div> --}}
    </body>

    <style>
      h1{
        text-align: center;
        text-transform: uppercase;
      }
      .contenido{
          font-size: 20px;
      }
      #primero{
          background-color: #ccc;
      }
      #segundo{
          color:#44a359;
      }
      #tercero{
        text-decoration:line-through;
      }
    </style>
</html>