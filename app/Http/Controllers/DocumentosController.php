<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentosController extends Controller
{
    public function index(){
        return view('documentos');
    }
}
