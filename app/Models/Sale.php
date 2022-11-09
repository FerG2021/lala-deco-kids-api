<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;    

    use SoftDeletes;

    //protected $dates = ['delete_at'];
    protected $table = 'sales';
    protected $hidden = ['created_at', 'update_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'typeSale',
        'idClient',
        'nameSeller',
        'nameBuyer',
        'dateSale',
        'totalPrice',
        'urlpdf',
    ];

    // funciones publicas
    public function obtenerObjDatos():array{
        return [
            'typeSale' => $this->typeSale,
            'idClient' => $this->idClient,
            'nameSeller' => $this->nameSeller,
            'nameBuyer' => $this->nameBuyer,
            'dateSale' => $this->dateSale,
            'totalPrice' => $this->totalPrice,
            'urlpdf' => $this->urlpdf,

        ];
    }

}
