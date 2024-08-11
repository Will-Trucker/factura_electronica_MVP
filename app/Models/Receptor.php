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
        'NumDocumento',  
        'NRC', 
        'idDepartamento', 
        'idMunicipio', 
        'Complemento', 
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
}
