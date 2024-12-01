<?php
Use App\Models\Token;
Use Carbon\Carbon;

/**
 * Write code on Method
 *
 * @return response()
*/

function verificarConexionInternet($url = 'http://www.google.com', $timeout = 10)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($httpcode >= 200 && $httpcode < 300);
    }

/**
     * Obtén el último token generado.
     *
     * @return string|null El token más reciente o null si no hay tokens.
     */
    function obtenerUltimoToken()
    {
        // Obtén el registro con el mayor id (el último token generado)
        $ultimoToken = Token::latest('id')->first();

        // Verifica si existe un token y retorna el campo `token`
        if ($ultimoToken) {
            return $ultimoToken->token;
        }

        // Si no hay tokens en la base de datos, retorna null
        return null;
    }


    if(!function_exists('obtenerDetalles')){
        function obtenerDetalles($codGeneracion){
            // Consulta a la base de datos para obtener el documento asociado al código de generación
            $documento = DB::table('documentos_procesados') // Suponiendo que la tabla se llama 'documentos'
                            ->where('codigoGeneracion', $codGeneracion) // Filtrar por código de generación
                            ->first(); // Obtener el primer resultado (debería ser único)

            if($documento) {
                // Si se encuentra el documento, decodificar el campo 'esquema' (si es necesario)
                $documentoEsquema = json_decode($documento->esquema);

                if($documentoEsquema && isset($documentoEsquema->cuerpoDocumento)) {
                    return $documentoEsquema->cuerpoDocumento; // Retornar los detalles encontrados
                }
            }

            // Si no se encuentra el documento o los detalles no son válidos
            return null; // O manejar con un error apropiado si lo prefieres
        }
    }
