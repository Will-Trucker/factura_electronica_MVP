<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumeroControl extends Model
{
    use HasFactory;

    protected $table = 'numerocontrol';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'tipoDTE',
        'numero'
    ];
}
