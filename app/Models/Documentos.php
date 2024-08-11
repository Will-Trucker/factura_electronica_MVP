<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'fecha',
        'codigoGeneracion',
        'selloRecibido',
        'observaciones'
    ];
}
