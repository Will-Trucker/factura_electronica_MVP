<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamento';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'codigoDepartamento','nombreDepartamento'
    ];

    

}
