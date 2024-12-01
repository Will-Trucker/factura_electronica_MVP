<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;

    protected $table = 'documentos_procesados';

    protected $primaryKey = 'id';

    protected $fillable = [
        'fhProcesamiento',
        'codigoGeneracion',
        'selloRecibido',
        'numeroControl',
        'esquema',
        'tipoDte'
    ];
}
