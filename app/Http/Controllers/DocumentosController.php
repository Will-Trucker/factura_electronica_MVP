<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\DB;
use App\Mail\EnvioDTE;
use Illuminate\Support\Facades\Mail;

class DocumentosController extends Controller
{
    public function index()
    {
        $documentos = DB::table('documentos_procesados')->orderBy('id', 'desc')->get();
        return view('documentos.index', compact('documentos'));
    }

    public function filtrarDoc(Request $request)
    {
        // Filtrar documentos por 'tipoDTE' en la tabla 'documentos_procesados'
        $documentos = DB::table('documentos_procesados')
            ->where('tipoDte', $request->tipoDte)
            ->orderBy('id', 'desc')
            ->get();

        return view('documentos', compact('documentos'));
    }

    function obtenerPdf($codGeneracion)
    {
        return $this->verPdfEnLinea($codGeneracion);
    }

    function verPdfEnLinea($codGeneracion)
    {
        $authToken = obtenerUltimoToken();
        $url = "https://admin.factura.gob.sv/test/generardte/generar-pdf/descargar/base64/codigo-generacion/1/{$codGeneracion}";

        try {
            $response = Http::withHeaders([
                'Authorization' => $authToken,
            ])->post($url);

            if ($response->status() == 200) {
                $pdf = $response->body();
                if ($pdf) {
                    $headers = [
                        'Content-Type' => 'application/pdf',
                    ];

                    // En lugar de "attachment", usa inline para mostrar el PDF en el navegador
                    return Response::make(base64_decode($pdf), 200, $headers);
                } else {
                    return "ERROR";
                }
            }
        } catch (\Exception $e) {
            echo ("Error interno del servidor: {$e->getMessage()}");
        }

        return false;
    }

    function ponerpdfSTRG($codGeneracion)
    {
        $authToken = obtenerUltimoToken();
        $url = "https://admin.factura.gob.sv/test/generardte/generar-pdf/descargar/base64/codigo-generacion/1/{$codGeneracion}";

        try {
            $response = Http::withHeaders([
                'Authorization' => $authToken,
            ])->post($url);

            if ($response->status() == 200) {
                $pdf = $response->body();
                if ($pdf) {
                    $pdfPath = 'contingencia/' . $codGeneracion . '.pdf';
                    Storage::put($pdfPath, base64_decode($pdf));
                } else {
                    return "ERROR";
                }
            }
        } catch (\Exception $e) {
            echo ("Error interno del servidor: {$e->getMessage()}");
        }

        return false;
    }

    public function obtenerJsonGuardado($codGeneracion)
    {
        // Buscar el registro en la base de datos
        $registro = DB::table('documentos_procesados')->where('codigoGeneracion', $codGeneracion)->first();

        if ($registro) {
            $filename = $codGeneracion . '.json';

            $headers = [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ];

            return Response::make($registro->esquema, 200, $headers);
        } else {
            return "Documento no encontrado";
        }
    }

    public function obtenerJsonGuardadoC($sello)
    {
        // Buscar el registro en la base de datos en la tabla correspondiente
        $registro = DB::table('eventos_contingencia')->where('selloRecibido', $sello)->first();

        if ($registro) {
            $filename = $sello . '.json';

            $headers = [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ];

            return Response::make($registro->esquema, 200, $headers);
        } else {
            return "Documento no encontrado";
        }
    }

    public function verJson($codGeneracion)
    {
        $register = DB::table('documentos_procesados')->where('codigoGeneracion', $codGeneracion)->first();

        if ($register) {
            // Descodificar el json generado desde la bd
            $json = json_decode($register->esquema);

            // Chekar si el esquema es un json valido
            if (json_last_error() === JSON_ERROR_NONE) {
                $jsonFormat = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                return response($jsonFormat, 200)->header('Content-Type', 'application/json');
            } else {
                return response()->json(['error' => 'El esquema brindado no es un json valido'], 400);
            }
        } else {
            return response()->json(['error' => 'Documento no encontrado'], 404);
        }
    }

    public function obtenerDocumento()
    {
        $esquema = session()->get('descargarjson');
        $doc = json_decode($esquema);
        $filename = $doc->identificacion->codigoGeneracion . '.json';

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return Response::make($esquema, 200, $headers);
    }

    public function enviarCorreoConDocumentos($codGeneracion) {
        // Obtener el registro de la base de datos
        $registro = DB::table('documentos_procesados')->where('codigoGeneracion', $codGeneracion)->first();

        if ($registro) {
            // Decodificar el JSON del registro (almacenado en la columna 'esquema')
            $jsonData = $registro->esquema;
            $jsonObject = json_decode($jsonData);

            // Verificar si el JSON es válido
            if (json_last_error() === JSON_ERROR_NONE) {
                // Verificar si existe el tipo de DTE
                if (isset($jsonObject->identificacion->tipoDte)) {
                    $tipoDte = $jsonObject->identificacion->tipoDte;

                    // Verificar el tipo de DTE (15 es para Donaciones, otros para Factura, Crédito Fiscal, etc.)
                    if ($tipoDte == '15') {
                        // Obtener el correo del donatario para donaciones
                        if (isset($jsonObject->donante->correo)) {
                            $receptorEmail = $jsonObject->donante->correo;

                            // Ruta para obtener el PDF de forma remota
                            $authToken = obtenerUltimoToken();
                            $url = "https://admin.factura.gob.sv/test/generardte/generar-pdf/descargar/base64/codigo-generacion/1/{$codGeneracion}";

                            try {
                                $response = Http::withHeaders([
                                    'Authorization' => $authToken,
                                ])->post($url);

                                // Agregar registro de la respuesta del servidor
                                Log::info('Código de estado: ' . $response->status());
                                Log::info('Cuerpo de la respuesta: ' . $response->body());

                                if ($response->status() == 200) {
                                    $pdfBase64 = $response->body();
                                    if ($pdfBase64) {
                                        // Decodificar el PDF
                                        $pdfDecoded = base64_decode($pdfBase64);

                                        // Crear un archivo temporal para adjuntar al correo
                                        $pdfTempPath = storage_path('app/temp/') . $codGeneracion . '.pdf';
                                        Storage::put('temp/' . $codGeneracion . '.pdf', $pdfDecoded);

                                        // Enviar el correo con el JSON y el PDF adjuntos
                                        Mail::to($receptorEmail)->send(new EnvioDTE($jsonData, $pdfTempPath, $receptorEmail));

                                        // Eliminar el archivo temporal después de enviar el correo
                                        Storage::delete('temp/' . $codGeneracion . '.pdf');

                                        return response()->json(['success' => 'Correo enviado con éxito']);
                                    } else {
                                        return response()->json(['error' => 'No se pudo decodificar el PDF del servidor remoto'], 500);
                                    }
                                } else {
                                    return response()->json(['error' => 'Error al obtener el PDF desde el servidor remoto'], 500);
                                }
                            } catch (\Exception $e) {
                                return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
                            }
                        } else {
                            return response()->json(['error' => 'Correo electrónico del receptor no encontrado en el JSON'], 400);
                        }
                    } else if (in_array($tipoDte, ['01', '03','11'])) {
                        // Lógica para otros tipos de DTE
                        if (isset($jsonObject->receptor->correo)) {
                            $receptorEmail = $jsonObject->receptor->correo;

                            // Ruta para obtener el PDF de forma remota
                            $authToken = obtenerUltimoToken();
                            $url = "https://admin.factura.gob.sv/test/generardte/generar-pdf/descargar/base64/codigo-generacion/1/{$codGeneracion}";

                            try {
                                $response = Http::withHeaders([
                                    'Authorization' => $authToken,
                                ])->post($url);

                                // Agregar registro de la respuesta del servidor
                                Log::info('Código de estado: ' . $response->status());
                                Log::info('Cuerpo de la respuesta: ' . $response->body());

                                if ($response->status() == 200) {
                                    $pdfBase64 = $response->body();
                                    if ($pdfBase64) {
                                        // Decodificar el PDF
                                        $pdfDecoded = base64_decode($pdfBase64);

                                        // Crear un archivo temporal para adjuntar al correo
                                        $pdfTempPath = storage_path('app/temp/') . $codGeneracion . '.pdf';
                                        Storage::put('temp/' . $codGeneracion . '.pdf', $pdfDecoded);

                                        // Enviar el correo con el JSON y el PDF adjuntos
                                        Mail::to($receptorEmail)->send(new EnvioDTE($jsonData, $pdfTempPath, $receptorEmail));

                                        // Eliminar el archivo temporal después de enviar el correo
                                        Storage::delete('temp/' . $codGeneracion . '.pdf');

                                        return response()->json(['success' => 'Correo enviado con éxito']);
                                    } else {
                                        return response()->json(['error' => 'No se pudo decodificar el PDF del servidor remoto'], 500);
                                    }
                                } else {
                                    return response()->json(['error' => 'Error al obtener el PDF desde el servidor remoto'], 500);
                                }
                            } catch (\Exception $e) {
                                return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
                            }
                        } else {
                            return response()->json(['error' => 'Correo electrónico del receptor no encontrado en el JSON'], 400);
                        }
                    } else {
                        return response()->json(['error' => 'Tipo de DTE no válido para el envío de correos'], 400);
                    }
                } else {
                    return response()->json(['error' => 'El JSON no contiene el campo tipoDte'], 400);
                }
            } else {
                return response()->json(['error' => 'El JSON en el esquema no es válido'], 400);
            }
        } else {
            return response()->json(['error' => 'Documento no encontrado'], 404);
        }
    }

}
