<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Revolution\Google\Sheets\Facades\Sheets;
class GoogleSheetController extends Controller
{
    public function index(){

        // $sheetData = Sheets::spreadsheet('1tycmeUUxyTqgMAuoeVcTIiMi-Szhqu5R3OJV4uwV5dw')->sheet('prueba1')->all();
        
        // $header = array_shift($sheetData);
        
        // $collection = collect($sheetData);
        
        // dd($collection);

        return view('form-test');

    }

    public function storeForm(Request $request){
        $data = [
            $request->input('name'),
            $request->input('email'),
            $request->input('message')
        ];

        $sheetData = Sheets::spreadsheet('1tycmeUUxyTqgMAuoeVcTIiMi-Szhqu5R3OJV4uwV5dw')->sheet('prueba1')->append([$data]);

        return redirect()->back()->with('success', 'Los datos se han almacenado correctamente.');

    }
}
