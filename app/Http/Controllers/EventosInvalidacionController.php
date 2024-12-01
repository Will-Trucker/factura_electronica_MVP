<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TiposInvalidacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\DocumentosRechazados;
use App\Models\EventoInvalidacion;
use App\Models\Emisor;


class EventosInvalidacionController extends Controller
{
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

    public function listaEInvalidacion()
    {
        $invalidacion = DB::table('evento_invalidacion')->get();
        return view('eventos.invalidacion.index',compact('invalidacion'));
    }
    public function nuevoEInvalidacion(){

        $fechahoraI = now();
        $fechaHoraIC = Carbon::now();

        $emisores = $this->obtenerEmisores();
        $tiposInv = TiposInvalidacion::all();

        return view('eventos.invalidacion.nuevoEinvalidacion',compact('emisores','tiposInv','fechahoraI','fechaHoraIC'));
    }

    public function eventoInvalidacion(Request $request)
    {
        if ($request->hasFile('documentos')) {
            // Obtener los archivos
            $archivos = $request->file('documentos');

            // Determinar el mensaje según la cantidad de archivos
            $mensaje = is_array($archivos)
                ? "Se subieron " . count($archivos) . " archivos en invalidación."
                : "Se subió un archivo en invalidación.";

            foreach ($archivos as $archivo) {
                // Verificar si el archivo es válido
                if ($archivo->isValid()) {
                    // Leer y decodificar el contenido del archivo JSON
                    $contenidoArchivo = file_get_contents($archivo->getRealPath());
                    $data = json_decode($contenidoArchivo, true);

                    // Validar que el archivo contiene un JSON válido
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $nuevoCodGen = $this->generaruuid();
                        $tipoInvalidacion = intval($request->tipoInvalidacion);

                        // Crear la estructura de documentos para invalidación
                        $documentosInvalidacion = [
                            "codigoGeneracion" => $data['dteJson']['identificacion']['codigoGeneracion'] ?? null,
                            "codigoGeneracionR" => $request->codigoGeneracionR,
                            "fecEmi" => $data['dteJson']['identificacion']['fecEmi'] ?? null,
                            "montoIva" => $data['dteJson']['resumen']['totalIva'] ?? null,
                            "numeroControl" => $data['dteJson']['identificacion']['numeroControl'] ?? null,
                            "selloRecibido" => $request->selloRecibido,
                            "tipoDte" => $data['dteJson']['identificacion']['tipoDte'] ?? null,
                            "tipoDocumento" => "36",
                            "numDocumento" => $data['dteJson']['receptor']['numDocumento'] ?? null,
                            "correo" => $data['dteJson']['receptor']['correo'] ?? null,
                            "telefono" => $data['dteJson']['receptor']['telefono'] ?? null,
                        ];

                        // Crear el documento JSON
                        $nitvendedorx = env('ENCRIPTED_NIT');
                        $passPri = env('ENCRIPTED_PSW_PRI');

                        $documento = [
                            'nit' => $nitvendedorx,
                            'activo' => true,
                            'passwordPri' => $passPri,
                            'dteJson' => [
                                "identificacion" => [
                                    "version" => 2,
                                    "ambiente" => "00",
                                    "codigoGeneracion" => $nuevoCodGen,
                                    "fecAnula" => $request->fechainicio,
                                    "horAnula" => now()->format('H:i:s'),
                                ],
                                "emisor" => [
                                    "nit" => $request->emisornit,
                                    "nombre" => $request->emisornombre,
                                    "tipoEstablecimiento" => "01",
                                    "telefono" => $request->emisortelefono,
                                    "correo" => $request->emisorcorreo,
                                ],
                                "documento" => [$documentosInvalidacion],
                                "motivo" => [
                                    "tipoAnulacion" => $tipoInvalidacion,
                                    "motivoInvalidacion" => $request->motivoinvalidacion,
                                    "nombreResponsable" => $request->emisornombre,
                                    "tipDocResponsable" => "36",
                                    "numDocResponsable" => $request->emisornit,
                                ],
                            ],
                        ];

                        // Convertir el documento a JSON y firmarlo
                        $docJSON = json_encode($documento);
                        $this->firmarDocumento($docJSON, $request->emisornit);

                        // Crear una nueva instancia de request y enviar a la otra ruta
                        $request2 = new Request();

                        $facturaController = new FacturaController();
                        $facturaController->docInvalidacion(
                            $request2,
                            $tipoInvalidacion,
                            $request->motivoinvalidacion,
                            $nuevoCodGen
                        );
                    } else {
                        return redirect()->route('documento')->with('error', 'El archivo contiene un JSON no válido.');
                    }
                } else {
                    return redirect()->route('documento')->with('error', 'Uno de los archivos no es válido.');
                }
            }

            return redirect()->route('documento')->with('success', $mensaje);
        }

        return redirect()->route('documento')->with('error', 'No se detectaron documentos para procesar.');
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

    public function mandarDocFirmado($respuesta, $nit, $esquema)
    {
        $documento = [
            "nit" => $nit,
            "documento" => $respuesta->body,
        ];

        $apiUrl = "https://apitest.dtes.mh.gob.sv/fesv/anulardte";

        $headers = [
            'Authorization' => obtenerUltimoToken(),
            'Content-Type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)->post($apiUrl, $documento);

        return $this->guardarDocumento($response, $esquema);
    }

    public function guardarDocumento($response, $esquema)
    {
        // Validar que $response es un array y contiene la clave 'estado'
        if (!is_array($response) || !isset($response['estado'])) {
            return redirect()->route('documento')->with('error', 'La respuesta del servidor no es válida.');
        }

        // Procesamiento si el estado es "PROCESADO"
        if ($response['estado'] === "PROCESADO") {
            EventoInvalidacion::create([
                'fechaHoraI' => $response['fhProcesamiento'] ?? now()->format('Y-m-d H:i:s'),
                'selloRecibido' => $response['selloRecibido'] ?? 'Sin Sello',
                'descripcionMsg' => $response['descripcionMsg'] ?? 'Sin descripción',
                'esquema' => $esquema,
            ]);

            return redirect()->route('documento')->with('success', 'Se realizó el evento de invalidación correctamente.');
        }
        // Procesamiento si el estado es "RECHAZADO"
        elseif ($response['estado'] === "RECHAZADO") {
            DocumentosRechazados::create([
                'fhProcesamiento' => $response['fhProcesamiento'] ?? now()->format('Y-m-d H:i:s'),
                'codigoGeneracion' => $response['codigoGeneracion'] ?? 'N/A',
                'observaciones' => !empty($response['observaciones']) && is_array($response['observaciones'])
                    ? implode(',', $response['observaciones'])
                    : 'Sin observaciones',
                'descripcionMsg' => $response['descripcionMsg'] ?? 'Sin descripción',
            ]);

            return redirect()->route('documento')
                ->with('mensaje', 'El evento fue rechazado.')
                ->with('observ', !empty($response['observaciones']) && is_array($response['observaciones'])
                    ? implode(',', $response['observaciones'])
                    : 'Sin observaciones');
        }

        return redirect()->route('documento')->with('error', 'Estado desconocido en la respuesta.');
    }
}
