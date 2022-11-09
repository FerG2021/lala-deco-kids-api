<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleProduct extends Model
{
    use HasFactory;

    use SoftDeletes;

    //protected $dates = ['delete_at'];
    protected $table = 'sale_products';
    protected $hidden = ['created_at', 'update_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'saleId',
        'idProduct',
        'name',
        'cantProduct',
        'priceProductSale',
        'priceProductTrust',
        'subtotal',
    ];

    // funciones publicas
    public function obtenerObjDatos():array{
        return [
            'saleId' => $this->saleId,
            'idProduct' => $this->idProduct,
            'name' => $this->name,
            'cantProduct' => $this->cantProduct,
            'priceProductSale' => $this->priceProductSale,
            'priceProductTrust' => $this->priceProductTrust,
            'subtotal' => $this->subtotal,
        ];
    }

}
