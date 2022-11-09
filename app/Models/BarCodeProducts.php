<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BarCodeProducts extends Model
{
    use HasFactory;

    use SoftDeletes;

    //protected $dates = ['delete_at'];
    protected $table = 'bar_code_products';
    protected $hidden = ['created_at', 'update_at'];

    protected $fillable = [
        'barcodeBarCodeProduct',
        'nameBarCodeProduct',
    ];

     // funciones publicas
     public function obtenerObjDatos():array{
        return [
            'barcodeBarCodeProduct' => $this->barcodeBarCodeProduct,
            'nameBarCodeProduct' => $this->nameBarCodeProduct,
        ];
    }

}
