<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Mail\EnvioDTE;
use Illuminate\Support\Facades\Mail;
use TCPDF;


class DocumentosController extends Controller
{
    public function index()
    {
        $documentos = DB::table('documentos_procesados')->orderBy('id', 'desc')->get();
        return view('documentos.index', compact('documentos'));
    }

    public function generarDTE()
    {
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nombre de la Empresa');
        $pdf->SetTitle('DTE - Documento Tributario Electrónico');
        $pdf->SetMargins(8, 10, 8);
        $pdf->SetAutoPageBreak(TRUE, 15);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // Añadir página
        $pdf->AddPage();

        // Dibujar el borde negro
        $pdf->SetLineStyle(style: ['width' => 0.1, 'color' => [0, 0, 0]]);
        $pdf->Rect(5, 5, $pdf->getPageWidth() - 10, $pdf->getPageHeight() - 10);

        // Configurar fuente
        $pdf->SetFont('helvetica', '', 10);

        // Titulo
        //COMPROBANTE DE CRÉDITO FISCAL

        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, 'DOCUMENTO DE CONSULTA PORTAL OPERATIVO', 0, 1, 'C');
        $pdf->Cell(0, 6, 'DOCUMENTO TRIBUTARIO ELECTRÓNICO', 0, 1, 'C'); // Aquí '0' en el tercer parámetro elimina la línea de borde.
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(0, 6, 'COMPROBANTE DE CRÉDITO FISCAL', 0, 1, 'C'); // Aquí '0' en el tercer parámetro elimina la línea de borde.
        $pdf->Ln(5);

        // Información del Número de Control y Sello de Recepción
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Número de Control: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, 'DTE-03-0001O000-000000000000913');

        $ancho_pagina = 107; // Depende del tamaño de página 

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'Modelo de Facturación: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, 'Previo', 0, 1, 'R');

        $pdf->Ln(h: 1);

        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Sello de Recepción: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, '2024C75FCC29B3B548FDBBB12E4B5FD41B6AJEW2');

        $ancho_pagina = 87;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'Tipo de Transmisión: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, 'Normal', 0, 1, 'R');

        $pdf->Ln(h: 1);

        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Código de Generación: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, '46E78585-0694-4C35-B949-0C0B048A9F3D');

        $ancho_pagina = 79;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'Fecha y Hora de Generación: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, '2024-06-12 19:50:00', 0, 1, 'R');

        $pdf->Ln(h: 5);

        $ancho_pagina = 50;
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell($ancho_pagina, 6, 'EMISOR', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $ancho_pagina = 100;
        $pdf->Cell($ancho_pagina, 6, 'RECEPTOR', 0, 0, 'R');

        $pdf->Ln(h: 5);

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Nombre o razon social: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, 'Juan Manuel Reyes');

        $ancho_pagina = 80;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'Nombre o razon social: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, 'ACME', 0, 1, 'R');

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'NIT: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, '0614-280390-112-1');

        $ancho_pagina = 102;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'NIT: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, '0614-280390-112-1', 0, 1, 'R');

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'NRC: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, '239881-0');

        $ancho_pagina = 112;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'NRC: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, '239881-0', 0, 1, 'R');

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Actividad economica: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, 'Publicidad');

        $ancho_pagina = 92;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'Actividad economica: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, 'Publicidad', 0, 1, 'R');

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Dirección: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, 'San Salvador, San Salvador');

        $ancho_pagina = 86;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'Dirección: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, 'San Salvador, San Salvador, Mejicanos', 0, 1, 'R');

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Número de telefono: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, '22222-2222');

        $ancho_pagina = 92;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'Número de telefono: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, '22222-2222', 0, 1, 'R');

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Correo electronico: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, 'ejemplo@correo.com');

        $ancho_pagina = 83;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'Correo electronico: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, 'ejemplocorreo@correo.com', 0, 1, 'R');

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Tipo de establecimiento: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, 'Sucursal/Agencia');

        $pdf->Ln(6);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(0, 6, 'OTROS DOCUMENTOS ASOCIADOS', 0, 1, 'C'); // Aquí '0' en el tercer parámetro elimina la línea de borde.
        $pdf->Ln(1);

        // Configurar fuente para el título de la tabla
        $pdf->SetFont('helvetica', 'B', 7);

        // Títulos de la tabla
        $pdf->Cell(100, 5, 'Identificación del documento', 1, 0, 'C');
        $pdf->Cell(80, 5, 'Descripción', 1, 1, 'C');

        // Configurar fuente para el contenido de la tabla
        $pdf->SetFont('helvetica', '', 7);

        $pdf->Cell(100, 5, '-', 1, 0, 'C');
        $pdf->Cell(80, 5, '-', 1, 5, 'C');

        $pdf->Ln(h: 1);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(0, 6, 'VENTA A CUENTA DE TERCEROS', 0, 1, 'C'); // Aquí '0' en el tercer parámetro elimina la línea de borde.
        $pdf->Ln(h: 1);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(10, 6, 'NIT: - ', 0, 0, 'L');
        $pdf->Cell(150, 6, 'Nombre, denominacion o razon social: -', 0, 0, 'C');

        $pdf->Ln(h: 7);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(0, 6, 'DOCUMENTOS RELACIONADOS', 0, 1, 'C'); // Aquí '0' en el tercer parámetro elimina la línea de borde.
        $pdf->Ln(h: 5);

        // Títulos de la tabla
        $pdf->Cell(60, 5, 'Tipo de Documento', 1, 0, 'C');
        $pdf->Cell(60, 5, 'N° de Documento', 1, 0, 'C');
        $pdf->Cell(60, 5, 'Fecha de Documento', 1, 1, 'C');


        // Configurar fuente para el contenido de la tabla
        $pdf->SetFont('helvetica', '', 7);

        $pdf->Cell(60, 5, '-', 1, 0, 'C');
        $pdf->Cell(60, 5, '-', 1, 0, 'C');
        $pdf->Cell(60, 5, '-', 1, 5, 'C');

        $pdf->Ln(h: 5);

        $html = view('pdf/pdf')->render();

        $pdf->writeHTML($html, true, false, true, false, '');

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Valor en letras: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, 'MIL TREINTA Y SEIS DOLARES CON DIEZ CENTAVOS AMERICANOS');

        $pdf->Ln(h: 5);

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Condición de la operación: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, 'CONTADO');

        $pdf->Ln(h: 5);

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Observaciones: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, ' - ');

        $pdf->Ln(h: 10);

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Responsable por parte del Emisor: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, ' - ');

        $ancho_pagina = 102;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'N° de Documento: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, ' - ', 0, 1, 'L');

        $pdf->Ln(h: 1);

        // Bloque de texto en el lado izquierdo
        $pdf->SetFont('helvetica', 'B', 7); // 'B' para negrita
        $pdf->Write(6, 'Responsable por parte del Receptor: ');
        $pdf->SetFont('helvetica', '', 7); // Sin 'B' para normal
        $pdf->Write(6, ' - ');

        $ancho_pagina = 102;

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell($ancho_pagina, 6, 'N° de Documento: ', 0, 0, 'R');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 6, ' - ', 0, 1, 'L');

        // Salida del PDF
        $pdf->Output('DTE.pdf', 'I'); // 'I' para visualizar en el navegador, 'D' para descargar

        // Finalizar
        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output();
        }, 'DTE.pdf');
    }

    public function generarPDF($codGeneracion)
    {
        $documentos = DB::table('documentos_procesados')->orderBy('id', 'desc')->get();
        foreach ($documentos as $documento) {
            if ($documento->codigoGeneracion == $codGeneracion) {
                $data = $documento;
                $array = get_object_vars($data);
                $pdf = PDF::loadView(view: 'pdf\pdf', data: $array);
            }
        }
        return $pdf->stream('documento.pdf');
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
        $registro = DB::table('evento_contingencia')->where('selloRecibido', $sello)->first();

        if ($registro) {
            $filename = $sello . '.json';

            $headers = [
                'Content-Type' => 'application/json',
                // 'Content-Disposition' => 'attachment; filename="' . $filename . '"'
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

    public function enviarCorreoConDocumentos($codGeneracion)
    {
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
                    } else if (in_array($tipoDte, ['01', '03', '11'])) {
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
