<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\APIHelpers;
use Validator, Auth;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        $productos = Product::all();

        $productosDB = collect();

        foreach ($productos as $producto) {
            $pathToFile = storage_path("app/public/imagenes/" . $producto->image);
            
            $listaDevolver = [
                'codeProduct' => $producto->codeProduct,
                'nameProduct' => $producto->nameProduct,
                'priceSaleProduct' => $producto->priceSaleProduct,
                'porcPriceTrustProduct' => $producto->porcPriceTrustProduct,
                'priceTrustProduct' => $producto->priceTrustProduct,
                'cantStockProduct' => $producto->cantStockProduct,
                'cantStockMinProduct' => $producto->cantStockMinProduct,
                'uuid' => $producto->uuid,
                'image' => $producto->image,
                'imageURL' => $pathToFile,
            ];

            $productosDB->push($listaDevolver);
        }
        
        $respuesta = APIHelpers::createAPIResponse(true, 200, 'Se ha producido un error', $productosDB);

        return response()->json($respuesta, 200);
        // return $productosDB;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear(Request $request)
    {
        $rules = [
            'codigo' => 'numeric | required',
            'nombre' => 'string | required',
            'precioVenta' => 'numeric | required',
            'procPrecioFiado' => 'numeric | required',
            'stock' => 'numeric | required',
            'stockMinimo' => 'numeric | required'
            // 'repetirContrasena' => 'required|min:8'

        ];

        $messages = [
            'codigo.numeric' => 'El codigo es requerido',
            'nombre.string' => 'El nombre es requerido',
            'precioVenta.numeric' => 'El precio de venta es requerido',
            'procPrecioFiado.numeric' => 'El porcentaje del precio de fiado es requerido',
            'stock.numeric' => 'El stock es requerido',
            'stockMinimo.numeric' => 'El stock minimo es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // $estado = 5;
            // return response()->json([$validator->errors()]);

            $respuesta = APIHelpers::createAPIResponse(true, 400, 'Se ha producido un error', $validator->errors());

            return response()->json($respuesta, 200);

        }

        $form = $request->all();
        $form['uuid'] = (string) Str::uuid();

        if ($request->hasFile('imagen')) {
            $form['imagen'] = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->storeAs('imagenes', $form['imagen']);
        }

        $producto = new Product();

        $producto->codeProduct =  $form['codigo'];
        $producto->nameProduct =  $form['nombre'];
        $producto->priceSaleProduct =  $form['precioVenta'];
        $producto->porcPriceTrustProduct =  $form['procPrecioFiado'];
        $porc = $form['procPrecioFiado'] / 100;
        $producto->priceTrustProduct =  ($form['precioVenta'] * $porc) + $form['precioVenta'];
        $porc = $request->get('porcpricetrust') / 100;
        $producto->cantStockProduct =  $form['stock'];
        $producto->cantStockMinProduct =  $form['stockMinimo'];
        $producto->uuid =  $form['uuid'];
        $producto->image =  $form['imagen'];

        if ($producto->save()) {
            $respuesta = APIHelpers::createAPIResponse(false, 200, 'Producto creado con éxito', $validator->errors());

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