<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receptor extends Model
{
    use HasFactory;

    protected $table = 'receptores';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'Nombre', 
        'TipoDocumento', 
        'NumDocumento',  
        'NIT',
        'NRC', 
        'idDepartamento', 
        'idMunicipio', 
        'Complemento', 
        'idActividadEconomica',
        'Telefono', 
        'Correo'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'idDepartamento');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'idMunicipio');
    }

    public function actividades()
    {
        return $this->belongsTo(ActividadEconomica::class, 'idActividadEconomica');
    }

    public function tipos()
    {
        return $this->belongsTo(TipoDocumento::class, 'TipoDocumento');
    }
}
