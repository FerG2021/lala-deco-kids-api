<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrentAccount extends Model
{
    use HasFactory;

    use SoftDeletes;

    //protected $dates = ['delete_at'];
    protected $table = 'current_accounts';
    protected $hidden = ['created_at', 'update_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clientId',
        'dniClient',
        'nameClient',
        'lastNameClient',
        'balance',
        'datelastaction',
        'deudors',
    ];

    // funciones publicas
    public function obtenerObjDatos():array{
        return [
            'clientId' => $this->clientId,
            'dniClient' => $this->dniClient,
            'nameClient' => $this->nameClient,
            'lastNameClient' => $this->lastNameClient,
            'balance' => $this->balance,
            'datelastaction' => $this->datelastaction,
            'deudors' => $this->deudors,
        ];
    }

}
