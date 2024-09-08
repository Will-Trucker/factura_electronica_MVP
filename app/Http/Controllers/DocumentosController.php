<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\DB;

class DocumentosController extends Controller
{
    public function index(){
        $documentos = DB::table('documentos_procesados')->orderBy('id', 'desc')->get();
        return view('documentos',compact('documentos'));
    }

    public function filtrarDoc(Request $request) {
        // Filtrar documentos por 'tipoDTE' en la tabla 'documentos_procesados'
        $documentos = DB::table('documentos_procesados')
                        ->where('tipoDTE', $request->tipoDeDocumento)
                        ->orderBy('id', 'desc')
                        ->get();

        return view('documentos', compact('documentos'));
    }

    // function obtenerPdf($codGeneracion) {
    //     return $this->otropdf($codGeneracion);
    // }

    // function otropdf($codGeneracion) {
    //     $authToken = obtenerUltimoToken();
    //     $url = "https://admin.factura.gob.sv/test/generardte/generar-pdf/descargar/base64/codigo-generacion/1/{$codGeneracion}";

    //     try {
    //         $response = Http::withHeaders([
    //             'Authorization' => $authToken,
    //         ])->post($url);

    //         if ($response->status() == 200) {
    //             $pdf = $response->body();
    //             if ($pdf) {
    //                 // Guardar el PDF en el almacenamiento
    //                 $pdfPath = 'contingencia/' . $codGeneracion . '.pdf';
    //                 Storage::put($pdfPath, base64_decode($pdf));

    //                 // Puedes guardar la ruta del PDF en la base de datos si es necesario

    //                 $headers = [
    //                     'Content-Type' => 'application/pdf',
    //                     'Content-Disposition' => 'attachment; filename=' . $codGeneracion . '.pdf',
    //                 ];

    //                 return Response::make(base64_decode($pdf), 200, $headers);
    //             } else {
    //                 return "ERROR";
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         echo ("Error interno del servidor: {$e->getMessage()}");
    //     }

    //     return false;
    // }

    function obtenerPdf($codGeneracion) {
        return $this->verPdfEnLinea($codGeneracion);
    }

    function verPdfEnLinea($codGeneracion) {
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

    function ponerpdfSTRG($codGeneracion) {
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

    public function obtenerJsonGuardado($codGeneracion) {
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

    public function obtenerJsonGuardadoC($sello) {
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

    public function obtenerDocumento() {
        $esquema = session()->get('descargarjson');
        $doc = json_decode($esquema);
        $filename = $doc->identificacion->codigoGeneracion . '.json';

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return Response::make($esquema, 200, $headers);
    }
}
