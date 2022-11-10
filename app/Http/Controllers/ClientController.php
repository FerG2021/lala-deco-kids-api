<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Helpers\APIHelpers;
use Validator, Auth;

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
    public function getDatos($id)
    {
        //
        $clienteDB = Client::where('id', '=', $id)->first();

        if ($clienteDB) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Datos encontrados con éxito', $clienteDB);

            return response()->json($respuesta, 200);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            // 'email' => 'required | unique:App\Models\User,email',
            // 'email' => 'required',
            // 'password' => 'sometimes',
            // 'repetirContrasena' => 'sometimes|required_if:contrasena,!=,null|same:contrasena',
            // 'cpassword' => 'sometimes|same:password'
            // 'repetirContrasena' => 'required|min:8'

        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'apellido.required' => 'El apellido es requerido',
            // 'email.unique' => 'Ya existe un usuario registrado con el email ingresado',
            // 'cpassword.same' => 'Las contraseñas ingresadas no coinciden',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);

        }


        // modifico el cliente
        $cliente = Client::findOrFail($request->id);

        $cliente->nameClient = $request->nombre;
        $cliente->lastNameClient = $request->apellido;

        if ($request->dni != null) {
            $cliente->dniClient = $request->dni;
        } else {
            $cliente->dniClient = $request->id;
        }

        if ($request->email != null) {
            $cliente->mailClient = $request->email;
        } else {
            $cliente->mailClient = "-";
        }

        if ($request->telefono != null) {
            $cliente->phoneClient = $request->telefono;
        } else {
            $cliente->phoneClient = 0;
        }

        if ($request->direccion != null) {
            $cliente->directionClient = $request->direccion;
        } else {
            $cliente->directionClient = "-";
        }

        if ($cliente->save()) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Cliente actualizado con exito', $cliente);

            return response()->json($respuesta, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function crear(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            // 'email' => 'required | unique:App\Models\User,email',
            // 'email' => 'required',
            // 'password' => 'sometimes',
            // 'repetirContrasena' => 'sometimes|required_if:contrasena,!=,null|same:contrasena',
            // 'cpassword' => 'sometimes|same:password'
            // 'repetirContrasena' => 'required|min:8'

        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'apellido.required' => 'El apellido es requerido',
            // 'email.unique' => 'Ya existe un usuario registrado con el email ingresado',
            // 'cpassword.same' => 'Las contraseñas ingresadas no coinciden',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);

        }


        // creo el cliente
        $cliente = new Client();

        $cliente->nameClient = $request->nombre;
        $cliente->lastNameClient = $request->apellido;

        if ($request->dni != null) {
            $cliente->dniClient = $request->dni;
        } else {
            $cliente->dniClient = 0;
        }

        if ($request->direccion != null) {
            $cliente->directionClient = $request->direccion;
        } else {
            $cliente->directionClient = "-";
        }

        if ($request->email != null) {
            $cliente->mailClient = $request->email;
        } else {
            $cliente->mailClient = "-";
        }

        if ($request->telefono != null) {
            $cliente->phoneClient = $request->telefono;
        } else {
            $cliente->phoneClient = 0;
        }

        if ($cliente->save()) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Cliente creado con exito', $cliente);

            return response()->json($respuesta, 200);
        }
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
