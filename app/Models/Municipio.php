<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipio';

    protected $primaryKey = 'idMunicipio';

    public $timestamps = false;

    protected $fillable = [
        'codMunicipio',
        'nombreMunicipio',
        'idDepartamento'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'idDepartamento',);
    }
}
