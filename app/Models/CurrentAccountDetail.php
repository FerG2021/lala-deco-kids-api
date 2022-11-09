<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrentAccountDetail extends Model
{
    use HasFactory;

    use HasFactory;

    use SoftDeletes;

    //protected $dates = ['delete_at'];
    protected $table = 'current_account_details';
    protected $hidden = ['created_at', 'update_at'];

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idCurrentAccount',
        'idClient',
        'idsale',
        'date',
        'typemovement',
        'pay',
        'sale',
    ];

    // funciones publicas
    public function obtenerObjDatos():array{
        return [
            'idCurrentAccount' => $this->idCurrentAccount,
            'idClient' => $this->idClient,
            'idsale' => $this->idsale,
            'date' => $this->date,
            'typemovement' => $this->typemovement,
            'pay' => $this->pay,
            'sale' => $this->sale,
        ];
    }

}
