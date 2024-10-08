<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emisor extends Model
{
    use HasFactory;

    protected $table = 'emisores';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'Nombre', 
        'NombreComercial', 
        'idActividadEconomica', 
        'NIT', 
        'NRC', 
        'idDepartamento', 
        'idMunicipio', 
        'Complemento', 
        'Telefono', 
        'Correo'
    ];

    // Relación con el modelo Departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'idDepartamento','codigoDepartamento');
    }

    // public function municipio()
    // {
    //     return $this->belongsTo(Municipio::class, 'idMunicipio','codMunicipio');
    // }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'idMunicipio', 'codMunicipio');
    }

    public function actividades()
    {
        return $this->belongsTo(ActividadEconomica::class, 'idActividadEconomica','codigoGiro');
    }
}
