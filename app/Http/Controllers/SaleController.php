<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Product;
use App\Models\CurrentAccount;
use App\Models\CurrentAccountDetail;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use App\Helpers\APIHelpers;
use Validator, Auth;

use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

use App\Mail\TestMailVenta;
use Mail;



class SaleController extends Controller
{
    // MOSTRAR TODAS LAS VENTAS
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        $ventas = Sale::orderBy('created_at', 'desc')->get();

        if ($ventas) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Datos encontrados con éxito', $ventas);

            return response()->json($respuesta, 200);
            // return $usuarios;
        } else {
            return 0;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filtrarFecha(Request $request)
    {
        $rules = [
            'fechaInicio' => 'date | required',
            'fechaFin' => 'date | required',
        ];

        $messages = [
            'fechaInicio.required' => 'La fecha de inicio es requerida',
            'fechaInicio.date' => 'La fecha de inicio debe ser una fecha',
            'fechaFin.required' => 'La fecha de fin es requerida',
            'fechaFin.date' => 'La fecha de fin debe ser una fecha',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);
        } 

        $ventas = Sale::orderBy('created_at', 'desc')->whereDate('created_at','>=', $request->fechaInicio)->whereDate('created_at','<=', $request->fechaFin)->get();

        if ($ventas) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Datos encontrados con éxito', $ventas);

            return response()->json($respuesta, 200);
            // return $usuarios;
        } else {
            return 0;
        }

        
    }

    // 
    // GUARDAR UNA VENTA
    // 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear(Request $request)
    {
        // 

        $rules = [
            'fechaVenta' => 'date | required',
            'tipoCliente' => 'numeric | required',
            'arrayProductosVenta' => 'required',
            'precioTotal' => 'numeric | required',
            'idCliente' => 'numeric | required',
            'nombreCliente' => 'string | required',
            'nombreVendedor' => 'string | required',
        ];

        $messages = [
            'fechaVenta.required' => 'La fecha de venta es requerida',
            'fechaVenta.date' => 'La fecha de venta debe ser una fecha',
            'tipoCliente.required' => 'El tipo de cliente es requerido',
            'arrayProductosVenta.required' => 'Los productos a vender son requeridos',
            'precioTotal.numeric' => 'El precio total de venta debe ser un número',
            'precioTotal.required' => 'El precio total de venta es requerido',
            'idCliente.numeric' => 'El ID del cliente debe ser un número',
            'idCliente.required' => 'El ID del cliente es requerido',
            'nombreCliente.string' => 'El nombre del cliente debe ser un string',
            'nombreCliente.required' => 'El nombre del cliente es requerido',
            'nombreVendedor.string' => 'El nombre del vendedor debe ser un string',
            'nombreVendedor.required' => 'El nombre del vendedor es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);
        } 

        // si todos los datos son correctos creo la venta segun el tipo de usuario

            if ($request->tipoCliente == 0) {
                // CONSUMIDOR FINAL
                $sale = new Sale();

                $sale->typeSale = $request->tipoCliente;
                $sale->idClient = $request->idCliente;
                $sale->nameSeller = $request->nombreVendedor;
                $sale->nameBuyer = $request->nombreCliente;
                $sale->dateSale = $request->fechaVenta;
                $sale->totalPrice = $request->precioTotal;

                if ($sale->save()) {
                    
                    // si la venta se guarda guardo los productos
                    $arrProductosVenta = json_decode($request->arrayProductosVenta);
                    
                    $sale = Sale::orderBy('id', 'desc')->first();

                    foreach ($arrProductosVenta as $item) {
                        // creo el producto para la venta
                        $saleProduct = new SaleProduct();

                        $saleProduct->saleId = $sale->id;
                        $saleProduct->idProduct = $item->id;
                        $saleProduct->name = $item->nombre;
                        $saleProduct->cantProduct = $item->cantidad;
                        $saleProduct->priceProductSale = $item->precioVenta;
                        $saleProduct->priceProductTrust = $item->priceTrustProduct;
                        $saleProduct->subtotal = $item->subtotal;

                        $saleProduct->save();


                        // busco el producto y lo descuento del stock
                        $product = Product::where('id', '=', $item->id)->first();

                        $product->cantStockProduct = $product->cantStockProduct - $item->cantidad;

                        $product->save();
                    }

                    $respuesta = APIHelpers::createAPIResponse(false, 200, 'Venta generada con éxito', 'Venta generada con éxito');
    
                    return response()->json($respuesta, 200);
                }

            } else {
                // CUENTA CORRIENTE
                $sale = new Sale();

                $sale->typeSale = $request->tipoCliente;
                $sale->idClient = $request->idCliente;
                $sale->nameSeller = $request->nombreVendedor;
                $sale->nameBuyer = $request->nombreCliente;
                $sale->dateSale = $request->fechaVenta;
                $sale->totalPrice = $request->precioTotal;

                
                if ($sale->save()) {
                    // si la venta se guarda guardo los productos
                    $arrProductosVenta = json_decode($request->arrayProductosVenta);
                        
                    $sale = Sale::orderBy('id', 'desc')->first();

                    foreach ($arrProductosVenta as $item) {
                        // creo el producto para la venta
                        $saleProduct = new SaleProduct();

                        $saleProduct->saleId = $sale->id;
                        $saleProduct->idProduct = $item->id;
                        $saleProduct->name = $item->nombre;
                        $saleProduct->cantProduct = $item->cantidad;
                        $saleProduct->priceProductSale = $item->precioVenta;
                        $saleProduct->priceProductTrust = $item->priceTrustProduct;
                        $saleProduct->subtotal = $item->subtotal;

                        $saleProduct->save();


                        // busco el producto y lo descuento del stock
                        $product = Product::where('id', '=', $item->id)->first();

                        $product->cantStockProduct = $product->cantStockProduct - $item->cantidad;

                        $product->save();
                    }

                    // si se guardan los productos guardo la venta en la cuenta corriente del cliente

                    // 1 - pregunto si el cliente ya tiene una cuenta corriente
                    $clienteCuentaCorriente = CurrentAccount::where('clientId', '=', $request->idCliente)->first();
                    
                    if ($clienteCuentaCorriente) {
                        // el cliente tiene cuenta corriente

                        $clienteCuentaCorriente->balance = $clienteCuentaCorriente->balance + ($request->precioTotal - $request->montoPagado);
                        $clienteCuentaCorriente->datelastaction = $request->fechaVenta;

                        $clienteCuentaCorriente->save();

                        // detalles de la cuenta corriente
                        // 0 - venta
                        // 1 - pago

                        $sale = Sale::orderBy('id', 'desc')->first();
                        
                        $detalleCuentaCorriente = new CurrentAccountDetail();

                        $detalleCuentaCorriente->idCurrentAccount = $clienteCuentaCorriente->id;
                        
                        $detalleCuentaCorriente->idClient = $clienteCuentaCorriente->clientId;

                        $detalleCuentaCorriente->idsale = $sale->id;

                        $detalleCuentaCorriente->date = $request->fechaVenta;

                        $detalleCuentaCorriente->typemovement = 0;

                        $detalleCuentaCorriente->pay = 0;

                        $detalleCuentaCorriente->sale = $request->precioTotal;

                        $detalleCuentaCorriente->save();


                        // ahora pregunto si me realizar algun pago para ahi mismo guardarlo

                        if ($request->montoPagado != 0) {
                            $detalleCuentaCorriente = new CurrentAccountDetail();

                            $detalleCuentaCorriente->idCurrentAccount = $clienteCuentaCorriente->id;
                            
                            $detalleCuentaCorriente->idClient = $clienteCuentaCorriente->clientId;

                            $detalleCuentaCorriente->idsale = $sale->id;

                            $detalleCuentaCorriente->date = $request->fechaVenta;

                            $detalleCuentaCorriente->typemovement = 1;

                            $detalleCuentaCorriente->pay = $request->montoPagado;

                            $detalleCuentaCorriente->sale = 0;

                            $detalleCuentaCorriente->save();
                        }

                    } else {
                        // el cliente no tiene cuenta corriente
                        $cuentaCorriente = new CurrentAccount();

                        $cuentaCorriente->clientId = $request->idCliente;
                        $cuentaCorriente->dniClient = $request->dniClient;
                        $cuentaCorriente->nameClient = $request->nameClient;
                        $cuentaCorriente->lastNameClient = $request->lastNameClient;
                        $cuentaCorriente->balance = $request->precioTotal - $request->montoPagado;
                        $cuentaCorriente->datelastaction = $request->fechaVenta;

                        $cuentaCorriente->save();

                        // detalles de la cuenta corriente
                        // 0 - venta
                        // 1 - pago

                        $sale = Sale::orderBy('id', 'desc')->first();
                        $cuentaCorrienteDB = CurrentAccount::orderBy('id', 'desc')->first();
                        
                        $detalleCuentaCorriente = new CurrentAccountDetail();

                        $detalleCuentaCorriente->idCurrentAccount = $cuentaCorrienteDB->id;
                        
                        $detalleCuentaCorriente->idClient = $cuentaCorrienteDB->clientId;

                        $detalleCuentaCorriente->idsale = $sale->id;

                        $detalleCuentaCorriente->date = $request->fechaVenta;

                        $detalleCuentaCorriente->typemovement = 0;

                        $detalleCuentaCorriente->pay = 0;

                        $detalleCuentaCorriente->sale = $request->precioTotal;

                        $detalleCuentaCorriente->save();


                        // ahora pregunto si me realizar algun pago para ahi mismo guardarlo

                        if ($request->montoPagado != 0) {
                            $detalleCuentaCorriente = new CurrentAccountDetail();

                            $detalleCuentaCorriente->idCurrentAccount = $cuentaCorrienteDB->id;
                            
                            $detalleCuentaCorriente->idClient = $cuentaCorrienteDB->clientId;

                            $detalleCuentaCorriente->idsale = $sale->id;

                            $detalleCuentaCorriente->date = $request->fechaVenta;

                            $detalleCuentaCorriente->typemovement = 1;

                            $detalleCuentaCorriente->pay = $request->montoPagado;

                            $detalleCuentaCorriente->sale = 0;

                            $detalleCuentaCorriente->save();
                        }
                    }

                    $respuesta = APIHelpers::createAPIResponse(false, 200, 'Venta generada con éxito', 'Venta generada con éxito');
    
                    return response()->json($respuesta, 200); 
                }
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDatos($id)
    {
        $saleDB = Sale::where('id', '=', $id)->first();

        $saleProductDB = SaleProduct::where('saleId', '=', $id)->get();

        $objDevolver = [
            'venta' => $saleDB,
            'productos' => $saleProductDB,
        ];

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Venta encontrada', $objDevolver);


    

        return $respuesta;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportarPDF($id)
    {
        $saleDB = Sale::where('id', '=', $id)->first();

        $saleProductDB = SaleProduct::where('saleId', '=', $id)->get();

        $objDevolver = [
            'venta' => $saleDB,
            'productos' => $saleProductDB,
        ];



        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Venta encontrada', $objDevolver);

        // METODO PARA GENERAR, GUARDAR Y MOSTRAR EL PDF
        $today = Carbon::now()->format('d/m/Y'); // paso datos
        $pdf = \PDF::loadView('ejemplo',compact('today', 'saleDB', 'saleProductDB'));
        $content = $pdf->download()->getOriginalContent();
        $nombreGuardar = 'public/csv/' . time() . '_' . 'ejemplo.pdf';
        Storage::put($nombreGuardar, $content) ;
        //  return $pdf->stream('ejemplo.pdf');


        $saleDB = Sale::where('id', '=', $id)->first();

        if ($saleDB) {
            if ($saleDB->urlpdf == null) {
                $saleDB->urlpdf = 'storage/'.$nombreGuardar;
                $saleDB->save();
                $urlEnviar = env('IMAGE_URL'). '/' . 'storage/' . $nombreGuardar;
            } else {
                $urlEnviar = env('IMAGE_URL'). '/' .$saleDB->urlpdf;
            }
        }

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'PDF generado con éxito', $urlEnviar);

        return $respuesta;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datosWhatsApp($id)
    {

        $saleDB = Sale::where('id', '=', $id)->first();

        $saleProductDB = SaleProduct::where('saleId', '=', $id)->get();

        $objDevolver = [
            'venta' => $saleDB,
            'productos' => $saleProductDB,
        ];

        // obtener los datos del cliente
        $clienteDB = Client::where('id', '=', $saleDB->idClient)->first();

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Venta encontrada', $objDevolver);

        // METODO PARA GENERAR, GUARDAR Y MOSTRAR EL PDF
        $today = Carbon::now()->format('d/m/Y'); // paso datos
        $pdf = \PDF::loadView('ejemplo',compact('today', 'saleDB', 'saleProductDB'));
        $content = $pdf->download()->getOriginalContent();
        $nombreGuardar = 'public/csv/' . time() . '_' . 'ejemplo.pdf';
        Storage::put($nombreGuardar, $content) ;
        //  return $pdf->stream('ejemplo.pdf');


        $saleDB = Sale::where('id', '=', $id)->first();

        if ($saleDB) {
            if ($saleDB->urlpdf == null) {
                $saleDB->urlpdf = 'storage/'.$nombreGuardar;
                $saleDB->save();
                $urlEnviar = env('IMAGE_URL'). '/' . 'storage/' . $nombreGuardar;
            } else {
                $urlEnviar = env('IMAGE_URL'). '/' .$saleDB->urlpdf;
            }
        }

        $objDevolver = [
            'urlEnviar' => $urlEnviar,
            'venta' => $saleDB,
            'ventaproductos' => $saleProductDB,
            'datosClient' => $clienteDB,
        ];

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'PDF generado con éxito', $objDevolver);

        return $respuesta;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function enviarMail(Request $request)
    {
        $saleDB = Sale::where('id', '=', $request->id)->first();

        $saleProductDB = SaleProduct::where('saleId', '=', $request->id)->get();

        $objDevolver = [
            'venta' => $saleDB,
            'productos' => $saleProductDB,
        ];

        // obtener los datos del cliente
        $clienteDB = Client::where('id', '=', $saleDB->idClient)->first();

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Venta encontrada', $objDevolver);

        // METODO PARA GENERAR, GUARDAR Y MOSTRAR EL PDF
        $today = Carbon::now()->format('d/m/Y'); // paso datos
        $pdf = \PDF::loadView('ejemplo',compact('today', 'saleDB', 'saleProductDB'));
        $content = $pdf->download()->getOriginalContent();
        $nombreGuardar = 'public/csv/' . time() . '_' . 'ejemplo.pdf';
        Storage::put($nombreGuardar, $content) ;
        //  return $pdf->stream('ejemplo.pdf');


        $saleDB = Sale::where('id', '=', $request->id)->first();

        if ($saleDB) {
            if ($saleDB->urlpdf == null) {
                $saleDB->urlpdf = 'storage/'.$nombreGuardar;
                $saleDB->save();
                $urlEnviar = env('IMAGE_URL'). '/' . 'storage/' . $nombreGuardar;
            } else {
                $urlEnviar = env('IMAGE_URL'). '/' .$saleDB->urlpdf;
            }
        }

        $objEnviarMail = [
            'nombreCliente' => $clienteDB->nameClient,
            'urlEnviar' => $urlEnviar,
            'total' => $saleDB->totalPrice,
            'ventaproductos' => $saleProductDB,
        ];

        Mail::to($request->mailCliente)
            ->send(new TestMailVenta($objEnviarMail, $urlEnviar)); 

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Mail enviado con éxito', $objEnviarMail);

        return $respuesta;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
