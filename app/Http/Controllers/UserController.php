<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Hash;
use App\Helpers\APIHelpers;
use Validator, Auth;


use Illuminate\Http\Request;

class UserController extends Controller
{
    // MOSTRAR TODOS LOS USUARIOS
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        $usuarios = User::orderBy('created_at', 'desc')->get();

        if ($usuarios) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Datos encontrados con éxito', $usuarios);

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
    public function crear(Request $request)
    {
            $rules = [
                'nombre' => 'required',
                'apellido' => 'required',
                'email' => 'required | unique:App\Models\User,email',
                'password' => 'required | min: 8',
                'cpassword' => 'required|same:password|min:8'
                // 'repetirContrasena' => 'required|min:8'

            ];

            $messages = [
                'nombre.required' => 'El nombre es requerido',
                'apellido.required' => 'El apellido es requerido',
                'email.required' => 'El email es requerido',
                'email.unique' => 'Ya existe un usuario registrado con el email ingresado',
                'password.required' => 'La contraseña es requerida',
                'password.min' => 'La contraseña debe ser de 8 caracteres como mínimo',
                'cpassword.required' => 'Es necesario repetir la contrasena',
                'cpassword.same' => 'Las contraseñas ingresadas no coinciden',
                'cpassword.min' => 'La confirmación de la contraseña debe ser de 8 caracteres como mínimo',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                // $estado = 5;
                // return response()->json([$validator->errors()]);

                $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

                return response()->json($respuesta, 200);

            }

            $usuario = new User();

            $usuario->name = $request->nombre;
            $usuario->lastname = $request->apellido;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->role = 0;

            $usuario->save();

            if ($usuario->save()) {
                $respuesta = APIHelpers::createAPIResponse(false, 200, 'Usuario creado con éxito', $validator->errors());

                return response()->json($respuesta, 200);
            }

            // return reponse()->json(['data' => usuario]);

    }

    public function crearUsuarioProveedor(){
        $usuarioProveedor = User::whereNotNull('proveedor_id')->get();

        $proveedoresDB = Proveedor::all();

        foreach ($proveedoresDB as $itemProveedor) {
            $b = 0;
            foreach ($usuarioProveedor as $itemUsuarioProveedor) {
                if ($itemProveedor->proveedor_id == $itemUsuarioProveedor->proveedor_id) {
                    $b = 1;
                }
            }

            if ($b == 0) {
                $usuario = new User();

                $usuario->name = $itemProveedor->proveedor_nombre;
                $usuario->email = $itemProveedor->proveedor_email;
                $usuario->password = Hash::make("1234567890");
                $usuario->password_plain = "1234567890";
                $usuario->tipo_usuario = 2;
                $usuario->proveedor_id = $itemProveedor->proveedor_id;
    
                $usuario->save(); 
            }
        }
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
    public function getDatos($id)
    {
        $usuarioDB = User::find($id);

        if ($usuarioDB) {
            $listaDevolver = [
                'id' => $usuarioDB->id,
                'nombre' => $usuarioDB->name,
                'apellido' => $usuarioDB->lastname,
                'email' => $usuarioDB->email,
            ];

            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Usuario encontrado', $listaDevolver);

            return response()->json($respuesta, 200);
        } else {
            return 0;
        }
        
    }

    public function getDatosUsuarioLogin(Request $request)
    {
        // $usuarioDB = User::where('email', '=', $request->mail_usuario)->first();
        // $usuarioDB = User::where('email', '=', $request->mail_usuario)->where('tipo_usuario', '=', 2)->where('proveedor_id', '=', $request->proveedor_id)->first();
        $usuarioDB = User::where('email', '=', $request->mail)->first();

        if ($usuarioDB) {
            $listaDevolver = [
                'id' => $usuarioDB->id,
                'nombre' => $usuarioDB->name,
                'email' => $usuarioDB->email,
            ];

            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Usuario encontrado', $listaDevolver);

            return response()->json($respuesta, 200);
        } else {
            return 1;
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
            // 'email' => 'required | unique:App\Models\User,email',
            'email' => 'required',
            'password' => 'sometimes',
            // 'repetirContrasena' => 'sometimes|required_if:contrasena,!=,null|same:contrasena',
            'cpassword' => 'sometimes|same:password'

            // 'repetirContrasena' => 'required|min:8'

        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.unique' => 'Ya existe un usuario registrado con el email ingresado',
            'cpassword.same' => 'Las contraseñas ingresadas no coinciden',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);

        }


        // modificacion de un registro
        $usuario = User::findOrFail($request->id);

        $usuario->name = $request->nombre;
        $usuario->email = $request->email;
        if ($request->password != null) {
            $usuario->password = Hash::make($request->password);
        }

        if ($usuario->save()) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Usuario actualizado con exito', $usuario);

            return response()->json($respuesta, 200);

        }

        // $usuario->save();

        // return $usuario;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request)
    {
        $usuario = User::destroy($request->id);
        
        $respuesta = APIHelpers::createAPIResponse(false, 200, 'Usuario eliminado con exito', $usuario);

        return response()->json($respuesta, 200);
    }
}
