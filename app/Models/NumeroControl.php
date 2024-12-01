<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NumeroControl extends Model
{
    use HasFactory;

    protected $table = 'numero_control';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'tipo_dte',
        'ultimo_numero'
    ];

    public static function obtenerNumeroDeControl($tipoDte)
    {
        // Buscar el registro en la base de datos
        $registro = self::where('tipo_dte', $tipoDte)->first();

        // Si el registro no existe, inicializarlo en 5000
        if (!$registro) {
            $registro = self::create([
                'tipo_dte' => $tipoDte,
                'numero' => 5000,
            ]);
        }

        return $registro->numero;
    }

    public static function actualizarNumeroControl($tipoDte)
    {
        // Buscar el registro y aumentar el número en 1
        $registro = self::where('tipo_dte', $tipoDte)->first();

        if ($registro) {
            $registro->numero += 1;
            $registro->save();
            return $registro->numero;
        }

        // Si no existe, retornar un error o lanzar una excepción
        throw new \Exception("No se pudo actualizar el número de control para el tipo DTE: $tipoDte");
    }
}
