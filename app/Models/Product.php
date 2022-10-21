<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codeProduct',
        'nameProduct',
        'priceSaleProduct',
        'porcPriceTrustProduct',
        'priceTrustProduct',
        'cantStockProduct',
        'cantStockMinProduct',
        'uuid',
        'image',
    ];

    // funciones publicas
    public function obtenerObjDatos():array{
        return [
            'codeProduct' => $this->codeProduct,
            'nameProduct' => $this->nameProduct,
            'priceSaleProduct' => $this->priceSaleProduct,
            'porcPriceTrustProduct' => $this->porcPriceTrustProduct,
            'priceTrustProduct' => $this->priceTrustProduct,
            'cantStockProduct' => $this->cantStockProduct,
            'cantStockMinProduct' => $this->cantStockMinProduct,
            'uuid' => $this->uuid,
            'image' => $this->image,
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
