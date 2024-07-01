<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $table = 'tipo_documento_facturacion';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nombreTipoDocumento','codigoTipoDocumento','abreviatura'
    ];
}
