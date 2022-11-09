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
          <h1 style="text-align: center; font-size: 20px">Lala Deco Kids - Compobante de venta</h1>
        </div>

        <div>
          <div>
            <label for=""><b><u>Datos generales de la venta:</u></b></label>
          </div>

          <div style="margin-top: 20px">
            <label for=""><u>Cliente:</u> {{ $saleDB->nameBuyer }}</label>
          </div>

          <div>
            <label for=""><u>Vendedor/a:</u> {{ $saleDB->nameSeller }}</label>
          </div>

          <div>
            <label for=""><u>Fecha:</u> {{ $saleDB->dateSale }}</label>
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
                  Cantidad
                </th>                       
                
                <th scope="col" style="background-color: #c7c7c7
                ">
                  Descripción
                </th>
                
                <th scope="col" style="background-color: #c7c7c7
                ">
                  Precio
                </th>
                
                <th scope="col" style="background-color: #c7c7c7
                ">
                  Subtotal
                </th>  
              </tr>
            </thead>
            <tbody>
              @foreach ($saleProductDB as $saleproduct)
                <tr>
                  <td>{{ $saleproduct->cantProduct }}</td>                
                  <td>{{ $saleproduct->name }}</td>
                  <td>{{ $saleproduct->priceProductSale }}</td>
                  <td>{{ $saleproduct->subtotal }}</td>
                  {{-- <td></td> --}}
                </tr style="margin-bottom: 10px">
                
              @endforeach
              
            </tbody>
            <tfoot>          
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col">TOTAL:</th>
              <th scope="col">{{$saleDB->totalPrice}}</th> 
            </tfoot>
          </table>
        </div>

        <div>
          <h2 style="text-align: center; font-size: 20px">¡¡¡Muchas gracias por su compra!!!</h2>
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