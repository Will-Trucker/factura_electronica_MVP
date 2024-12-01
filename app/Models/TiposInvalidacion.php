<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposInvalidacion extends Model
{
    protected $table = 'tipo_invalidacion';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'tipoInvalidacion',
    ];

}
