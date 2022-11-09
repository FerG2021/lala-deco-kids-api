<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrentAccount;
use App\Models\CurrentAccountDetail;
use App\Models\Client;
use App\Helpers\APIHelpers;
use Validator, Auth;
// use Carbon\Carbon;

use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

use App\Mail\TestMail;
use Mail;


class CurrentAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        $cuentasCorrientesDB = CurrentAccount::all();

        if ($cuentasCorrientesDB) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Datos encontrados con éxito', $cuentasCorrientesDB);

            return response()->json($respuesta, 200);
            // return $usuarios;
        } else {
            return 0;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDatos($id)
    {
        $cuentaCorrienteDB = CurrentAccount::where('id', '=', $id)->first();

        if ($cuentaCorrienteDB) {
            $cuentaCorrienteProductosDB = CurrentAccountDetail::where('idCurrentAccount', '=', $cuentaCorrienteDB->id)->get();

            if ($cuentaCorrienteProductosDB) {
                $datos = [
                    'datosCuentaCorriente' => $cuentaCorrienteDB,
                    'datosCuentaCorrienteProducto' => $cuentaCorrienteProductosDB,
                ];
            }

            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Datos encontrados con éxito', $datos);

            return response()->json($respuesta, 200);
            // return $usuarios;
        } else {
            return 0;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevoPagoCliente(Request $request)
    {
        $rules = [
            'id' => 'required',
            'montoPagado' => 'required',
        ];

        $messages = [
            'id.required' => 'El id del cliente es requerido',
            'montoPagado.required' => 'El monto abonado por el cliente es requerido',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);

        }


        $cuentaCorrienteDB = CurrentAccount::where('id', '=', $request->id)->first();

        if ($cuentaCorrienteDB) {
            
            $cuentaCorrienteDB->balance = $cuentaCorrienteDB->balance - $request->montoPagado;

            if ($cuentaCorrienteDB->save()) {
                $now = Carbon::now();
                $cuentaCorrienteDetalleDB = new CurrentAccountDetail();

                $cuentaCorrienteDetalleDB->idCurrentAccount = $cuentaCorrienteDB->id;
                $cuentaCorrienteDetalleDB->idClient = $request->id;
                $cuentaCorrienteDetalleDB->date = $now;
                $cuentaCorrienteDetalleDB->typemovement = 1;
                $cuentaCorrienteDetalleDB->pay = $request->montoPagado;
                $cuentaCorrienteDetalleDB->sale = 0;

                if ($cuentaCorrienteDetalleDB->save()) {
                    $respuesta = APIHelpers::createAPIResponse(false, 200, 'Datos encontrados con éxito', 'Pago procesado con éxito');

                    return response()->json($respuesta, 200);
                    // return $usuarios;
                }
            }

            
        } else {
            return 0;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportarPDF($id)
    {
        $cuentaCorrienteDB = CurrentAccount::where('id', '=', $id)->first();

        $cuentaCorrienteDetalleDB = CurrentAccountDetail::where('idCurrentAccount', '=', $id)->get();

        $objDevolver = [
            'cuentacorriente' => $cuentaCorrienteDB,
            'cuentacorrientedetalles' => $cuentaCorrienteDetalleDB,
        ];

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Venta encontrada', $objDevolver);

        // METODO PARA GENERAR, GUARDAR Y MOSTRAR EL PDF
        $today = Carbon::now()->format('d/m/Y'); // paso datos
        $pdf = \PDF::loadView('cuentacorriente',compact('today', 'cuentaCorrienteDB', 'cuentaCorrienteDetalleDB'));
        $content = $pdf->download()->getOriginalContent();
        $nombreGuardar = 'public/pdf/' . time() . '_' . 'detalleCuentaCorriente.pdf';
        Storage::put($nombreGuardar, $content) ;
        //  return $pdf->stream('ejemplo.pdf');


        $cuentaCorrienteDB = CurrentAccount::where('id', '=', $id)->first();

        if ($cuentaCorrienteDB) {
            // if ($saleDB->urlpdf == null) {
                $cuentaCorrienteDB->urlpdf = 'storage/'.$nombreGuardar;
                $cuentaCorrienteDB->save();
                $urlEnviar = env('IMAGE_URL'). '/' . 'storage/' . $nombreGuardar;
            // } else {
            //     $urlEnviar = env('IMAGE_URL'). '/' .$saleDB->urlpdf;
            // }
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

        $cuentaCorrienteDB = CurrentAccount::where('id', '=', $id)->first();

        $cuentaCorrienteDetalleDB = CurrentAccountDetail::where('idCurrentAccount', '=', $id)->get();

        // obtener los datos del cliente
        $clienteDB = Client::where('id', '=', $cuentaCorrienteDB->clientId)->first();

        $objDevolver = [
            'cuentacorriente' => $cuentaCorrienteDB,
            'cuentacorrientedetalles' => $cuentaCorrienteDetalleDB,
        ];

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Venta encontrada', $objDevolver);

        // METODO PARA GENERAR, GUARDAR Y MOSTRAR EL PDF
        $today = Carbon::now()->format('d/m/Y'); // paso datos
        $pdf = \PDF::loadView('cuentacorriente',compact('today', 'cuentaCorrienteDB', 'cuentaCorrienteDetalleDB'));
        $content = $pdf->download()->getOriginalContent();
        $nombreGuardar = 'public/pdf/' . time() . '_' . 'detalleCuentaCorriente.pdf';
        Storage::put($nombreGuardar, $content) ;
        //  return $pdf->stream('ejemplo.pdf');


        $cuentaCorrienteDB = CurrentAccount::where('id', '=', $id)->first();

        if ($cuentaCorrienteDB) {
            // if ($saleDB->urlpdf == null) {
                $cuentaCorrienteDB->urlpdf = 'storage/'.$nombreGuardar;
                $cuentaCorrienteDB->save();
                $urlEnviar = env('IMAGE_URL'). '/' . 'storage/' . $nombreGuardar;
            // } else {
            //     $urlEnviar = env('IMAGE_URL'). '/' .$saleDB->urlpdf;
            // }
        }

        $objEnviar = [
            'urlEnviar' => $urlEnviar,
            'datosClient' => $clienteDB,
        ];

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'PDF generado con éxito', $objEnviar);

        return $respuesta;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function enviarMail(Request $request)
    {
        $cuentaCorrienteDB = CurrentAccount::where('id', '=', $request->id)->first();

        $cuentaCorrienteDetalleDB = CurrentAccountDetail::where('idCurrentAccount', '=', $request->id)->get();

        $listaDetalleCuentaCorriente = collect();

        foreach ($cuentaCorrienteDetalleDB as $itemDetalle) {
           $datos = [
            'idCurrentAccount' => $itemDetalle->idCurrentAccount,
            'idClient' => $itemDetalle->idClient,
            'idsale' => $itemDetalle->idsale,
            'date' => $itemDetalle->date,
            'typemovement' => $itemDetalle->typemovement,
            'pay' => $itemDetalle->pay,
            'sale' => $itemDetalle->sale,
           ];

           $listaDetalleCuentaCorriente->push($datos);
        }

        // obtener los datos del cliente
        $clienteDB = Client::where('id', '=', $cuentaCorrienteDB->clientId)->first();

        $objDevolver = [
            'cuentacorriente' => $cuentaCorrienteDB,
            'cuentacorrientedetalles' => $cuentaCorrienteDetalleDB,
        ];

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Venta encontrada', $objDevolver);

        // METODO PARA GENERAR, GUARDAR Y MOSTRAR EL PDF
        $today = Carbon::now()->format('d/m/Y'); // paso datos
        $pdf = \PDF::loadView('cuentacorriente',compact('today', 'cuentaCorrienteDB', 'cuentaCorrienteDetalleDB'));
        $content = $pdf->download()->getOriginalContent();
        $nombreGuardar = 'public/pdf/' . time() . '_' . 'detalleCuentaCorriente.pdf';
        Storage::put($nombreGuardar, $content) ;
        //  return $pdf->stream('ejemplo.pdf');


        $cuentaCorrienteDB = CurrentAccount::where('id', '=', $request->id)->first();

        if ($cuentaCorrienteDB) {
            // if ($saleDB->urlpdf == null) {
                $cuentaCorrienteDB->urlpdf = 'storage/'.$nombreGuardar;
                $cuentaCorrienteDB->save();
                $urlEnviar = env('IMAGE_URL'). '/' . 'storage/' . $nombreGuardar;
            // } else {
            //     $urlEnviar = env('IMAGE_URL'). '/' .$saleDB->urlpdf;
            // }
        }

        $objEnviarMail = [
            'urlEnviar' => $urlEnviar,
            'nombreCliente' => $clienteDB->nameClient,
            'balance' => $cuentaCorrienteDB->balance,
            'datosCuentaCorriente' => $listaDetalleCuentaCorriente,
        ];

        Mail::to($request->mailCliente)
            ->send(new TestMail($objEnviarMail, $urlEnviar)); 

        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Mail enviado con éxito', $objEnviarMail);

        return $respuesta;
    }


    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
