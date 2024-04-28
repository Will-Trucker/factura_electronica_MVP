<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmisorController extends Controller
{
    public function index(){
        return view('emisor');
    }
}
