<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;

class EventosController extends Controller
{
    public function listaEInvalidacion(){
        return view('eInvalidacion');
    }

    public function listaEContingencia(){
        return view('eContingencia');
    }

    public function nuevoEContingencia(){
        return view('nuevoEContingencia');
    }
}
