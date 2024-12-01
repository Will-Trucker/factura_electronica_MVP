<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoContingencia extends Model
{
    use HasFactory;

    protected $table = 'tipo_contingencia';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'tipoContingencia'
    ];
}
