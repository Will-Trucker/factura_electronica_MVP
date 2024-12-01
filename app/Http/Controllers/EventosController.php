<?php

namespace App\Http\Controllers;

use App\Models\TipoDocumento;
use App\Models\TiposInvalidacion;
use Illuminate\Http\Request;
use App\Models\Emisor;
use App\Models\TipoContingencia;
use App\Models\EventoContingencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\DocumentosRechazados;
use App\Models\EventoInvalidacion;

class EventosController extends Controller
{

    public function listaEContingencia()
    {
        $contingencias = DB::table('evento_contingencia')->get();

        return view('eventos.contingencia.index', compact('contingencias'));
    }

    function obtenerEmisores()
    {
        $emisores = Emisor::all()->toArray();
        return $emisores;
    }

    function generaruuid()
    {

        $apiUrl = 'https://www.uuidgenerator.net/api/version4';
        $response = Http::get($apiUrl);
        return strtoupper($response);
    }

    public function nuevoEContingencia()
    {
        // Para ver configuracion de la hora y zona horaria
        $fechahora = now();
        // con carbon
        $fechaHoraC = Carbon::now();
        /*  */

        $tiposCont = TipoContingencia::get();
        $emisores = $this->obtenerEmisores();

        return view('eventos.contingencia.nuevoEContingencia', compact('fechahora', 'fechaHoraC', 'tiposCont', 'emisores'));
    }

    public function nuevoEContingenciaLotes(){
        $fechahoraL = now();
        $fechaHoraCL = Carbon::now();
        $emisores = $this->obtenerEmisores();
        $tiposCont = TipoContingencia::get();

        return view('eventos.contingencia.lotesC',compact('fechahoraL','fechaHoraCL','emisores','tiposCont'));
    }


    public function eventoContingencia(Request $request)
    {
        if ($request->hasFile('documentos')) {
            // Obtener el archivo
            $archivos = $request->file('documentos');
            if (is_array($archivos)) {
                $cantidadArchivos = count($archivos);
                $mensaje = "Se subieron $cantidadArchivos archivos en contingencia";
            } else {
                // Si solo es un archivo
                $mensaje = "Se subió un archivo en contingencia";
            }
            foreach ($archivos as $archivo) {

                // Verificar si es un archivo valido
                if ($archivo->isValid()) {
                    $nuevoCodGen = $this->generaruuid();
                    $tipoCont = intval($request->tipocontingencia);
                    $documentosContigencia = [
                        "noItem" => 1,
                        "codigoGeneracion" => $nuevoCodGen,
                        "tipoDoc" => $request->tipoDeDocumento
                    ];

                    $nitvendedorx = env('ENCRIPTED_NIT');
                    $passPri = env('ENCRIPTED_PSW_PRI');

                    $documento = [
                        'nit' => $nitvendedorx,
                        'activo' => true,
                        'passwordPri' => $passPri,
                        'dteJson' => [
                            "identificacion" => [
                                "version" => 3,
                                "ambiente" => "00",
                                "codigoGeneracion" => $this->generaruuid(),
                                "fTransmision" => now()->format('Y-m-d'),
                                "hTransmision" => now()->format('H:i:s')
                            ],
                            "emisor" => [
                                "nit" => $request->emisornit,
                                "nombre" => $request->emisornombre,
                                "nombreResponsable" => $request->nombreComercial,
                                "tipoDocResponsable" => "36",
                                "numeroDocResponsable" => $request->emisornit,
                                "tipoEstablecimiento" => "01",
                                "codEstableMH" => null,
                                "codPuntoVenta" => null,
                                "telefono" => $request->emisortelefono,
                                "correo" => $request->emisorcorreo
                            ],
                            "detalleDTE" => [
                                $documentosContigencia
                            ],
                            "motivo" => [
                                "fInicio" => $request->fechainicio,
                                "fFin" => $request->fechafin,
                                "hInicio" => "12:00:00",
                                "hFin" => now()->format('H:i:s'),
                                "tipoContingencia" => $tipoCont,
                                "motivoContingencia" => $request->motivocontingencia
                            ]
                        ]
                    ];

                    $docJSON = json_encode($documento);
                    $this->firmarDocumento($docJSON, $request->emisornit);

                    $contenidoArchivo = file_get_contents($archivo->getRealPath());

                    // Crear una nueva instancia de request
                    $request2 = new Request();

                    // Establecer el valor del parametro 'tipoD'

                    // Enviar el archivo a la otra ruta
                    $facturaController = new FacturaController;
                    $facturaController = $facturaController->docContingencia(
                        $request2,
                        $tipoCont,
                        $request->motivocontingencia,
                        $nuevoCodGen
                    );
                }
                return redirect()->route('documento')
                ->with('success', $mensaje);
            }
        } else {
            echo 'No se detectaron documentos para procesar';
        }
    }


    public function firmarDocumento($documento, $nit)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost:8113/firmardocumento/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $documento,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);

        if (curl_errno($curl)) {
            echo 'Error al realizar la solicitud: ' . curl_error($curl);
            print_r($info);
        }
        curl_close($curl);

        $cuerpojson = json_decode($documento);

        $cuerpojson = json_encode($cuerpojson);

        return $this->mandarDocFirmado(json_decode($response), $nit, $cuerpojson);
    }

    // Solo para Contingencia, para la invalidacion se creara otra funcion

    public function mandarDocFirmado($respuesta, $nit, $esquema)
    {
        $documento = [
            "nit" => $nit,
            "documento" => $respuesta->body,
        ];

        $apiUrl = "https://apitest.dtes.mh.gob.sv/fesv/contingencia";

        $headers = [
            'Authorization' => obtenerUltimoToken(),
            'Content-Type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)->post($apiUrl, $documento);

        return $this->guardarDocumento($response, $esquema);
    }


    public function guardarDocumento($response,$esquema){
        if($response['estado'] == "RECIBIDO"){
            EventoContingencia::create([
                'fechaHora' => $response['fechaHora'],
                'selloRecibido' => $response['selloRecibido'],
                'esquema' => $esquema
            ]);

            return redirect()->route('documento')->with('success','Se realizo el evento de contingencia');
        } else if($response != null && $response['estado'] == "RECHAZADO"){
            DocumentosRechazados::create([
                'fhProcesamiento' => $response['fhProcesamiento'],
                'codigoGeneracion' => 'N/A',
                'observaciones' => implode(',',$response['observaciones'])
            ]);

            return redirect()->route('documento')->with('mensaje','')->with('observ',implode(',',$response['observaciones']));
        }
    }



    // public function guardarDocumento($response, $esquema)
    // {
    //     dump($response);
    //     if ($response['estado'] == "RECIBIDO") {
    //         // Insertar el documento en la tabla evento_contingencia usando el modelo
    //         EventoContingencia::create([
    //             'fecha' => Carbon::createFromFormat('d/m/Y H:i:s', $response['fechaHora']),
    //             'selloRecibido' => $response['selloRecibido'],
    //             'esquema' => $esquema
    //         ]);

    //         return view('respuesta', compact('response'));

    //     } else if ($response && $response['estado'] == "RECHAZADO") {
    //         // Manejar el caso de documentos rechazados
    //         $rechazoData = [
    //             'fhProcesamiento' => Carbon::createFromFormat('d/m/Y H:i:s', $response['fechaHora']),
    //             'codigoGeneracion' => 'COD_GENERACION', // Ajustar según tu lógica
    //             'observaciones' => implode(',', $response['observaciones'])
    //         ];

    //         DB::table('documentos_rechazados')->insert($rechazoData);

    //         return redirect()->view('respuesta')
    //             ->with('mensaje', 'Documento rechazado')
    //             ->with('observ', implode(',', $response['observaciones']));
    //     }
    // }

}

