<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoContingencia extends Model
{
    protected $table = 'evento_contingencia';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'fechaHora',
        'selloRecibido',
        'esquema'
    ];

    public $timestamps = false;

}
