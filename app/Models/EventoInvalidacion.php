<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoInvalidacion extends Model
{
    protected $table = 'evento_invalidacion';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'fhProcesamiento',
        'selloRecibido',
        'esquema',
        'descripcionMsg'
    ];
}
