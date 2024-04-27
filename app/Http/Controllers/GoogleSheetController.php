<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Revolution\Google\Sheets\Facades\Sheets;
class GoogleSheetController extends Controller
{
    public function index(){
        // $shhet = Sheets::spreadsheet('1tycmeUUxyTqgMAuoeVcTIiMi-Szhqu5R3OJV4uwV5dw')->sheet('prueba1')->all();
        // $header = $shhet->pull(0);
        // $values = Sheets::collection($header,$shhet);
        // $data = array_values($values->toArray());

        // dd($values);

        $sheetData = Sheets::spreadsheet('1tycmeUUxyTqgMAuoeVcTIiMi-Szhqu5R3OJV4uwV5dw')->sheet('prueba1')->all();
        
        // Extract the header (first row) from the sheet data
        $header = array_shift($sheetData);
        
        // Create a collection from the remaining sheet data
        $collection = collect($sheetData);
        
        // Optionally, if you want to include the header in the collection
        // $collection->prepend($header);
        
        dd($collection);
    }
}
