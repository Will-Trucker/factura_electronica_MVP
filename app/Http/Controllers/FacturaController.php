<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Revolution\Google\Sheets\Facades\Sheets;
use function PHPUnit\Framework\returnSelf;

class FacturaController extends Controller
{
    public function registro(){
        return view('facturacion');
    }   
}
