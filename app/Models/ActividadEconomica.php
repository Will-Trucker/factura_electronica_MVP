<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadEconomica extends Model
{
    use HasFactory;

    protected $table = 't_giro_comercial';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'codigoGiro','nombreGiro'
    ];
}
