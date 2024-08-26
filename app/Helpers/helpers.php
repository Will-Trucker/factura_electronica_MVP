<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
// use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Facades\Response;
use Google\Exception as GoogleException;
use App\Models\Token;
use App\Models\NumeroControl;

if(!function_exists('algo')){
    function objeto(){
        return "Hola Mundo!";
    }
}

if(!function_exists('buscar_algo')){
    function buscar($campo, $busqueda){
        if(verificarConexionInternet()){
            return DB::table('numerocontrol')
            ->where($campo, $busqueda)
            ->first();
            //->get();
            return $resultado;
        } else {
            return null;
        }
    }
}


if (!function_exists('verificarConexionInternet')) {
    function verificarConexionInternet()
    {
        $url = 'http://www.google.com';
        $headers = @get_headers($url);

        if ($headers && strpos($headers[0], '200')) {
            // Hay conexión a Internet
            return true;
        } else {
            // No hay conexión a Internet
            return false;
        }
    }
}

if(!function_exists('ultimoToken')){
    function ultimoToken(){
        if(checkInternetConnection()){
            $respuesta = DB::table('tokens')
            ->orderBy('id','desc')
            ->first();

            return $respuesta ? $respuesta->token : null;
            // Tomar el ultimo token de la bd
            // $ultimoToken = Token::orderBy('fechaGeneracion','desc')->first();
            // return $ultimoToken ? $ultimoToken->token : null;
        } else {
            return 0;
        }
    }
}

if(!function_exists('ultimoID')){
    function ultimoID($tabla){
        $respuesta = DB::table($tabla)
        ->orderBy('id','desc')
        ->first();

        return $respuesta ? $respuesta->id : null;
    }
}
?>