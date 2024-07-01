<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $table = 'registro_tokens';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
      'token',
      'fechaGeneracion'
    ];
}
