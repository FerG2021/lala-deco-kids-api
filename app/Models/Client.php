<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;

    use SoftDeletes;

    //protected $dates = ['delete_at'];
    protected $table = 'clients';
    protected $hidden = ['created_at', 'update_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dniClient',
        'nameClient',
        'lastNameClient',
        'directionClient',
        'phoneClient',
        'mailClient',
    ];

    // funciones publicas
    public function obtenerObjDatos():array{
        return [
            'dniClient' => $this->dniClient,
            'nameClient' => $this->nameClient,
            'lastNameClient' => $this->lastNameClient,
            'directionClient' => $this->directionClient,
            'phoneClient' => $this->phoneClient,
            'mailClient' => $this->mailClient,
        ];
    }
}
