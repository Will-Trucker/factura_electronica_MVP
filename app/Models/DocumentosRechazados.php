<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosRechazados extends Model
{
    use HasFactory;

    protected $table = 'documentos_rechazados';

    protected $primaryKey = 'id';

    protected $fillable = [
        'fecha',
        'codigoGeneracion',
        'selloRecibido',
        'observaciones'
    ];


}
