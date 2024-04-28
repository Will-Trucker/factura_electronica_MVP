<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;

class TokenController extends Controller
{
    public function index(){
        return view('token');
    }
}
