<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Helpers\APIHelpers;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        $clientes = Client::all();

        $clientesDB = collect();

        if ($clientes) {

            foreach ($clientes as $cliente) {
                $listaDevolver = [
                    'deleted_at' => $cliente->deleted_at,
                    'directionClient' => $cliente->directionClient,
                    'dniClient' => $cliente->dniClient,
                    'id' => $cliente->id,
                    'lastNameClient' => $cliente->lastNameClient,
                    'mailClient' => $cliente->mailClient,
                    'nameClient' => $cliente->nameClient,
                    'phoneClient' => $cliente->phoneClient,
                    'updated_at' => $cliente->updated_at,
                    'completName' => $cliente->lastNameClient . ", " . $cliente->nameClient
    
                ];
    
                $clientesDB->push($listaDevolver);
            }

            

            $respuesta = APIHelpers::createAPIResponse(true, 200, 'Clientes encontrados', $clientesDB);

            return response()->json($respuesta, 200);
        }
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
