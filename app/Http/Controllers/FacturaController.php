<?php

namespace App\Http\Controllers;

use App\Models\NumeroControl;
use App\Models\Documentos;
use App\Models\DocumentosRechazados;
use Illuminate\Http\Request;
use App\Models\Emisor;
use App\Models\Receptor;
use Illuminate\Support\Facades\Http;
use Luecano\NumeroALetras\NumeroALetras;
use function PHPUnit\Framework\returnSelf;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Exception;
class FacturaController extends Controller
{
    public function registro()
    {
        // ...
        $emisores = $this->obtenerEmisores(); // Obtiene todos los emisores de la base de datos
        $receptores = $this->obtenerReceptores();
        return view('factura.index', compact('emisores', 'receptores'));
    }

    function obtenerEmisores()
    {
        $emisores = Emisor::all()->toArray();
        return $emisores;
    }

    function obtenerReceptores()
    {
        $receptores = Receptor::all()->toArray();
        return $receptores;
    }

    // Generar Codigo UUID V4
    function generaruuid()
    {
        if (verificarConexionInternet()) {
            $apiUrl = 'https://www.uuidgenerator.net/api/version4';
            $response = Http::get($apiUrl);

            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                // Obtener el cuerpo de la respuesta como texto y convertirlo a mayúsculas
                return strtoupper($response->body());
            } else {
                // Manejar el error de la solicitud
                return null; // O un mensaje de error
            }
        } else {
            // Manejar la falta de conexión a Internet
            return null; // O un mensaje de error
        }
    }

    public function docContingencia(Request $request, $tipo, $motivo, $codGen)
    {
        if (!$request->hasFile('documento')) {
            return response()->json(['error' => 'No se ha recibido ningún archivo'], 400);
        }

        $archivo = $request->file('documento');
        if (!$archivo->isValid()) {
            return response()->json(['error' => 'El archivo no es válido'], 400);
        }

        // Leer el contenido del archivo JSON
        $contenidoJson = file_get_contents($archivo->path());
        $nuevoDoc = json_decode($contenidoJson);

        if ($nuevoDoc === null || json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Error al decodificar el JSON.');
            return response()->json(['error' => 'Error al procesar el archivo JSON'], 400);
        }

        // Verificar si el objeto contiene la propiedad 'identificacion'
        if (!isset($nuevoDoc->identificacion)) {
            Log::error('El archivo JSON no contiene la propiedad "identificacion".');
            return response()->json(['error' => 'Propiedad "identificacion" no encontrada'], 400);
        }

        $identificacion = $nuevoDoc->identificacion;
        $tipoDte = $identificacion->tipoDte;

        try {
            // Generar el número de control basado en el tipo de DTE
            $ncontrol = $this->generarNumeroControl($tipoDte);
        } catch (\Exception $e) {
            Log::error('Error al generar el número de control: ' . $e->getMessage());
            return response()->json(['error' => 'Tipo de DTE no válido'], 400);
        }

        // Continuar procesando el documento según sea necesario
        return response()->json(['message' => 'Documento procesado correctamente', 'numeroControl' => $ncontrol]);
    }

    public function docInvalidacion(Request $request, $tipo, $motivo, $codGen)
    {
        if (!$request->hasFile('documento')) {
            return response()->json(['error' => 'No se ha recibido ningún archivo'], 400);
        }

        $archivo = $request->file('documento');
        if (!$archivo->isValid()) {
            return response()->json(['error' => 'El archivo no es válido'], 400);
        }

        // Leer el contenido del archivo JSON
        $contenidoJson = file_get_contents($archivo->path());
        $nuevoDoc = json_decode($contenidoJson);

        $contenidoJson = file_get_contents($archivo->path());
        $nuevoDoc = json_decode($contenidoJson);

        if ($nuevoDoc === null || json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Error al decodificar el JSON.');
            return response()->json(['error' => 'Error al procesar el archivo JSON'], 400);
        }

        // Verificar si el objeto contiene la propiedad 'identificacion'
        if (!isset($nuevoDoc->identificacion)) {
            Log::error('El archivo JSON no contiene la propiedad "identificacion".');
            return response()->json(['error' => 'Propiedad "identificacion" no encontrada'], 400);
        }

        $identificacion = $nuevoDoc->identificacion;
        $tipoDte = $identificacion->tipoDte;

        try {
            // Generar el número de control basado en el tipo de DTE
            $ncontrol = $this->generarNumeroControl($tipoDte);
        } catch (Exception $e) {
            Log::error('Error al generar el número de control: ' . $e->getMessage());
            return response()->json(['error' => 'Tipo de DTE no válido'], 400);
        }

        // Continuar procesando el documento según sea necesario
        return response()->json(['message' => 'Documento procesado correctamente', 'numeroControl' => $ncontrol]);
    }

    public function obtenerNumero($tipoDte)
    {
        // Obtener el registro correspondiente al tipo de documento
        $registro = NumeroControl::where('tipo_dte', $tipoDte)->first();

        if (!$registro) {
            // Si no existe el registro, inicializarlo en 1
            $registro = new NumeroControl();
            $registro->tipo_dte = $tipoDte;
            $registro->ultimo_numero = 1;
            $registro->save();
        } else {
            // Incrementar el número de control
            $registro->ultimo_numero += 1;
            $registro->save();
        }

        // Retornar el número de control actualizado
        return $registro->ultimo_numero;
    }

    function generarNumeroControl($tipoDocumento) {
        // Primera sección: "DTE"
        $prefijo = "DTE";

        // Segunda sección: Tipo de documento (pasado como parámetro)
        // Asegúrate de que el tipo de documento sea válido
        $tiposValidos = ["01", "03", "11", "15"];  // Tipos de documentos válidos
        if (!in_array($tipoDocumento, $tiposValidos)) {
            throw new Exception('Tipo de documento no válido.');
        }

        // Tercera sección: Código de sucursal y punto de venta
        $codigoSucursal = "OFEM";  // Código de la casa matriz o sucursal
        $codigoPuntoVenta = "0001"; // Código del punto de venta
        $codigoTerceraSeccion = $codigoPuntoVenta . $codigoSucursal; // Secciones combinadas en el orden correcto

        // Cuarta sección: Número secuencial (dinámico, reiniciado cada vez que se llame)
        $numeroSecuencial = rand(1, 999999999999999);  // Generar un número secuencial aleatorio de 15 dígitos
        $numeroSecuencialFormateado = str_pad($numeroSecuencial, 15, '0', STR_PAD_LEFT);  // Asegura que el número tenga 15 dígitos

        // Generación del número de control
        $numeroControl = $prefijo . '-' . $tipoDocumento . '-' . $codigoTerceraSeccion . '-' . $numeroSecuencialFormateado;

        // Verificación de longitud del número de control
        if (strlen($numeroControl) != 31) {
            throw new Exception('El número de control generado no tiene la longitud correcta.');
        }

        return $numeroControl;
    }

    public function guardarFactura(Request $request)
    {
        if ($request->tipoDeDocumento == "CCFE") {
            return $this->creditoFiscal($request);
        }

        if ($request->tipoDeDocumento == "FE") {
            return $this->facturaElectronica($request);
        }

        if ($request->tipoDeDocumento == "NRE") {
            //NOTE DE REMISION ELECTRONICA

        }
        if ($request->tipoDeDocumento == "NRE") {
            //NOTE DE CREDITO ELECTRONICA

        }
        if ($request->tipoDeDocumento == "NDE") {
            //NOTE DE DEBITO ELECTRONICA

        }
        if ($request->tipoDeDocumento == "CRE") {
            //COMPROBANTE DE RETENCIÓN ELECTRONICO

        }
        if ($request->tipoDeDocumento == "CLE") {
            //COMPROBANTE DE LIQUIDACION ELECTRONICO

        }
        if ($request->tipoDeDocumento == "CDLE") {
            //DOCUMENTO CONTABLE DE LIQUIDACION ELECTRONICO

        }
        if ($request->tipoDeDocumento == "FEXE") {
            // FACTURA DE EXPORTACIÓN
            return $this->facturadeExportacion($request);
        }
        // if ($request->tipoDeDocuento == "FSEE"){
        //     // FACTURA DE SUJETO EXCLUIDO ELECTRONICA
        //     return $this->facturadeSujetoExcluido($request);
        // }
        if ($request->tipoDeDocumento == "CDE") {
            // COMPROBANTE DE DONACIÓN ELECTRONICO
            return $this->comprobanteDonacionElectronica($request);
        }
    }

    public function firmarDocumento($documento, $tipoDocumento)
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
        $cuerpojson = $cuerpojson->dteJson;
        $cuerpojson = json_encode($cuerpojson);

        return $this->mandarDocFirmado(json_decode($response), $tipoDocumento, $cuerpojson);
    }

    public function mandarDocFirmado($respuesta, $tipoDocumento, $esquema)
    {
        $tipoDte = "01";
        $version = "1";

        if ($tipoDocumento == "FE" || $tipoDocumento == "01") {
            $tipoDte = "01";
            $version = "1";
        }
        if ($tipoDocumento == "CCFE" || $tipoDocumento == "03") {
            $tipoDte = "03";
            $version = "3";
        }
        if ($tipoDocumento == "FEXE" || $tipoDocumento == "11") {
            $tipoDte = "11";
            $version = "1";
        }
        if ($tipoDocumento == "FESE" || $tipoDocumento == "14") {
            $tipoDte = "14";
            $version = "1";
        }
        if ($tipoDocumento == "CDE" || $tipoDocumento == "15") {
            $tipoDte = "15";
            $version = "1";
        }
        $documento = [
            "ambiente" => "00",
            "idEnvio" => "1",
            "version" => $version,
            "tipoDte" => $tipoDte,
            "documento" => $respuesta->body,
        ];

        $apiUrl = "https://apitest.dtes.mh.gob.sv/fesv/recepciondte";

        $ultimoToken = obtenerUltimoToken();

        $headers = [
            'Authorization' => $ultimoToken,
            'Content-Type' => 'application/json',
        ];

        if (verificarConexionInternet()) {
            // Realizar la solicitud POST
            $response = Http::withHeaders($headers)->post($apiUrl, $documento);
        } else {
            // Manejar la falta de conexión a Internet
            $response = null; // O podrías manejarlo de otra manera, por ejemplo, lanzar una excepción
        }

        return $this->guardarDocumento($response, $esquema);
    }

    public function guardarDocumento($response, $esquema)
    {
        if ($response == '' || $response == null) {
            \Log::error('La respuesta es vacía o nula.');
            $esquema = json_decode($esquema);
            $codGeneracion = $esquema->identificacion->numeroControl;
            $esquema = json_encode($esquema);
            $pdfPath = 'contingencia/' . $codGeneracion . '.json';
            Storage::put($pdfPath, $esquema);
            return redirect()->route('documentos')->with('message', 'Hubo un error al intentar procesarlo, se hará una contingencia');
        }

        if ($response != null && $response['estado'] == "PROCESADO") {
            \Log::info('Guardando documento procesado.');
            $esquema = json_decode($esquema);
            $tipoDTE = $esquema->identificacion->tipoDte;
            $numeroControl = $esquema->identificacion->numeroControl;
            $esquema = json_encode($esquema);

            $datos = [
                'fhProcesamiento' => $response['fhProcesamiento'],
                'codigoGeneracion' => $response['codigoGeneracion'],
                'selloRecibido' => $response['selloRecibido'],
                'numeroControl' => $numeroControl,
                'esquema' => $esquema,
                'tipoDte' => $tipoDTE
            ];

            DB::table('documentos_procesados')->insert($datos);

            return redirect()->route('documento')->with('success', 'El documento se procesó correctamente');
        } elseif ($response != null && $response['estado'] == "RECHAZADO") {
            \Log::info('Guardando documento rechazado.');
            $datos = [
                'fhProcesamiento' => $response['fhProcesamiento'],
                'codigoGeneracion' => $response['codigoGeneracion'],
                'selloRecibido' => $response['selloRecibido'],
                'observaciones' => implode(',', $response['observaciones']),
                'descripcionMsg' => $response['descripcionMsg']
            ];

            DB::table('documentos_rechazados')->insert($datos);

            return redirect()->route('documento')
                ->with('mensaje', $response['descripcionMsg'])
                ->with('observ', implode(',', $response['observaciones']));
        }
    }

    public function facturaElectronica(Request $request)
    {
        $formatter = new NumeroALetras();

        $detallesfactura = json_decode($request->detallesfactura);
        $cuerpodocumento = [];
        $i = 0;
        $totalnosujeto = 0;
        $totalexcento = 0;
        $totalgravado = 0;
        $totalDespuesto = 0;
        $totaliva = 0;
        foreach ($detallesfactura as $detalle) {
            $i++;
            $totalnosujeto += $detalle->ventasnosujetas;
            $totalexcento += $detalle->ventasexcentas;
            $totalgravado += $detalle->ventasafectas;
            $dato = [
                "numItem" => $i,
                "tipoItem" => 2,
                "numeroDocumento" => null,
                "cantidad" => floatval($detalle->cantidad),
                "codigo" => null,
                "codTributo" => null,
                "uniMedida" => 99,
                "descripcion" => $detalle->descripcion,
                "precioUni" => floatval($detalle->preciounitario),
                "montoDescu" => 0,
                "ventaNoSuj" => floatval($detalle->ventasnosujetas),
                "ventaExenta" => floatval($detalle->ventasexcentas),
                "ventaGravada" => floatval($detalle->ventasafectas),
                "tributos" => null,
                "psv" => 0,
                "noGravado" => 0,
                "ivaItem" => round($detalle->ventasafectas / 1.13 * 0.13, 2)
            ];
            $totaliva += round($detalle->ventasafectas / 1.13 * 0.13, 2);
            array_push($cuerpodocumento, $dato);
        }
        $resumen = [
            "totalNoSuj" => $totalnosujeto,
            "totalExenta" => $totalexcento,
            "totalGravada" => $totalgravado,
            "subTotalVentas" => $totalgravado,
            "descuNoSuj" => 0,
            "descuExenta" => 0,
            "descuGravada" => 0,
            "porcentajeDescuento" => 0,
            "totalDescu" => 0,
            "tributos" => null,
            "subTotal" => $totalgravado,
            "ivaRete1" => 0,
            "reteRenta" => 0,
            "montoTotalOperacion" => $totalgravado,
            "totalNoGravado" => 0,
            "totalPagar" => $totalgravado,
            "totalLetras" => $formatter->toMoney($totalgravado, 2, "Dolares Américanos", "Centavos"),
            "totalIva" => round($totaliva, 2),
            "saldoFavor" => 0,
            "condicionOperacion" => 1,
            "pagos" => null,
            "numPagoElectronico" => null
        ];
        $nitvendedorx = env('ENCRIPTED_NIT');//'06142803901121';
        $passPri = env('ENCRIPTED_PSW_PRI');//'Rr2Ll3rm0@$ñ@';
        $tipoDocumento = "01";
        $numeroControl = $this->generarNumeroControl($tipoDocumento);
        $documento = [
            'nit' => $nitvendedorx,
            'activo' => true,
            'passwordPri' => $passPri,
            'dteJson' => [
                "identificacion" => [
                    "version" => 1,
                    "ambiente" => "00",
                    "tipoDte" => "01",//ir cambiando el numero de Control desde 5000
                    "numeroControl" => $numeroControl,
                    //"DTE-01-0001ONEC-000000000000997",//"DTE-01-0001ONEC-000000000000994",//"DTE-01-0001ONEC-000000000000993",//$this->obtenerNumero('FE')//.$this->obtenerNumeroDeControl('FE'),
                    "codigoGeneracion" => $this->generaruuid(),
                    "tipoModelo" => 1,
                    "tipoOperacion" => 1,
                    "tipoContingencia" => null,
                    "motivoContin" => null,
                    "fecEmi" => date('Y-m-d'),
                    "horEmi" => date('h:i:s'),
                    "tipoMoneda" => "USD",
                ],
                "documentoRelacionado" => null,
                "emisor" => [
                    //"nit"=> "$request->emisornit",
                    "nit" => strval($request->emisornit),//"06142803901121",
                    "nrc" => $request->emisornrc,//"2398810",
                    "nombre" => $request->emisornombre,
                    "codActividad" => $request->actividademisor,
                    "descActividad" => "Publicidad",
                    "nombreComercial" => $request->nombreComercial,
                    "tipoEstablecimiento" => "01",
                    "direccion" =>
                        [
                            "departamento" => $request->emisordepartamento, //"06",
                            "municipio" => $request->emisormunicipio,//"14",
                            "complemento" => $request->complemento//"San Salvador"
                        ],
                    "telefono" => $request->emisortelefono,
                    "codEstableMH" => null,
                    "codEstable" => null,
                    "codPuntoVentaMH" => null,
                    "codPuntoVenta" => null,
                    "correo" => $request->emisorcorreo//"rafaeledudominguez@gmail.com"
                ],
                "receptor" => [
                    "tipoDocumento" => "36",
                    "numDocumento" => $request->receptorndocumento,//"06141101171056",
                    "nrc" => null,
                    "nombre" => $request->receptornombre,
                    "codActividad" => null,
                    "descActividad" => null,
                    "direccion" =>
                        [
                            "departamento" => $request->receptordepartamento,//"06",
                            "municipio" => $request->receptormunicipio,//"14",
                            "complemento" => $request->receptorcomplemento,//"SAN SALVADOR"
                        ],
                    "telefono" => $request->receptortelefono,//"2525-2525",
                    "correo" => $request->receptorcorreo//"acme_sv@gmail.com"
                ],
                "otrosDocumentos" => [
                    [
                        "codDocAsociado" => 3,
                        "descDocumento" => null,
                        "detalleDocumento" => null,
                        "medico" =>
                            [
                                "nombre" => "JUAN MANUEL REYES",
                                "nit" => null,
                                "docIdentificacion" => "066948964",
                                "tipoServicio" => 1
                            ]
                    ]
                ],
                "ventaTercero" => [
                    "nombre" => "JUAN MANUEL REYES",
                    "nit" => "043474311"
                ],
                "cuerpoDocumento" => $cuerpodocumento,
                "resumen" => $resumen,
                "extension" => [
                    "nombEntrega" => null,
                    "docuEntrega" => null,
                    "nombRecibe" => null,
                    "docuRecibe" => null,
                    "observaciones" => null,
                    "placaVehiculo" => null
                ],

                "apendice" =>
                    [
                        [
                            "campo" => "Campo",
                            "etiqueta" => "Descripcion",
                            "valor" => "null"

                        ]
                    ]

            ],

        ];

        $docJSON = json_encode($documento);
        echo $numeroControl;
        //echo $docJSON;
        //echo "----------------------------------------------------------------------------------------------";
        return $this->firmarDocumento($docJSON, $request->tipoDeDocumento);
    }

    public function creditoFiscal(Request $request)
    {
        $formatter = new NumeroALetras();
        $detallesfactura = json_decode($request->detallesfactura);
        $cuerpodocumento = [];
        $i = 0;
        $totalnosujeto = 0;
        $totalexcento = 0;
        $totalgravado = 0;
        $totalDespuesto = 0;
        $totaliva = 0;
        foreach ($detallesfactura as $detalle) {
            $i++;
            $totalnosujeto += $detalle->ventasnosujetas;
            $totalexcento += $detalle->ventasexcentas;
            $totalgravado += $detalle->ventasafectas;
            $dato = [
                "numItem" => $i,
                "tipoItem" => 2,
                "numeroDocumento" => null,
                "codigo" => null,
                "codTributo" => null,
                "descripcion" => $detalle->descripcion,
                "cantidad" => floatval($detalle->cantidad),
                "uniMedida" => 59,
                "precioUni" => floatval($detalle->preciounitario),
                "montoDescu" => 0,
                "ventaNoSuj" => floatval($detalle->ventasnosujetas),
                "ventaExenta" => floatval($detalle->ventasexcentas),
                "ventaGravada" => floatval($detalle->ventasafectas),
                "tributos" => [
                    "20"
                ],
                "psv" => 0,
                "noGravado" => 0,
            ];
            $totaliva += round($detalle->ventasafectas / 1.13 * 0.13, 2);
            array_push($cuerpodocumento, $dato);
        }
        //echo "TOTAL DEL IVA $totaliva ----";
        $totalConIVA = round($totalgravado * 1.13, 2);
        $resumen = [
            "totalNoSuj" => $totalnosujeto,
            "totalExenta" => $totalexcento,
            "totalGravada" => $totalgravado,
            "subTotalVentas" => $totalgravado,
            "descuNoSuj" => 0,
            "descuExenta" => 0,
            "descuGravada" => 0,
            "porcentajeDescuento" => 0,
            "totalDescu" => 0,
            "tributos" => [
                [
                    "codigo" => "20",
                    "descripcion" => "Impuesto al Valor Agregado 13%",
                    "valor" => round($totalgravado * 0.13, 2) // Multiplicar el subtotal ventas por 0.13 (13% iva)
                ]
            ],
            "subTotal" => $totalgravado,
            "ivaPerci1" => 0,
            "ivaRete1" => 0,
            "reteRenta" => 0,
            "montoTotalOperacion" => $totalConIVA,
            "totalNoGravado" => 0,
            "totalPagar" => $totalConIVA,
            "totalLetras" => $formatter->toMoney($totalConIVA, 2, "Dolares", "Centavos Americanos"),
            "saldoFavor" => 0,
            "condicionOperacion" => 1,
            "pagos" => null,
            "numPagoElectronico" => null
        ];
        $nitvendedorx = env('ENCRIPTED_NIT');//'06142803901121';
        $passPri = env('ENCRIPTED_PSW_PRI');//'Rr2Ll3rm0@$ñ@';
        $tipoDocumento = "03";
        $numeroControl = $this->generarNumeroControl($tipoDocumento);
        $documento = [
            "nit" => $nitvendedorx,
            "activo" => true,
            "passwordPri" => $passPri,
            "dteJson" => [
                "identificacion" => [
                    "version" => 3,
                    "ambiente" => "00",
                    "tipoDte" => "03",
                    "numeroControl" =>$numeroControl,
                    "codigoGeneracion" => $this->generaruuid(),
                    "tipoModelo" => 1,
                    "tipoOperacion" => 1,
                    "tipoContingencia" => null,
                    "motivoContin" => null,
                    "fecEmi" => date('Y-m-d'),
                    "horEmi" => date('h:i:s'),
                    "tipoMoneda" => "USD"
                ],
                "documentoRelacionado" => null,
                "emisor" => [
                    "nit" => strval($request->emisornit),//"06141101171056",
                    "nrc" => $request->emisornrc, //"2687740",
                    "nombre" => $request->emisornombre, //"Fundacion Emprende Hoy",
                    "codActividad" => $request->actividademisor,//"73100",
                    "descActividad" => "Publicidad",
                    "nombreComercial" => $request->nombreComercial,
                    "tipoEstablecimiento" => "01",
                    "direccion" => [
                        "departamento" => $request->emisordepartamento, //"06",
                        "municipio" => $request->emisormunicipio, //"14",
                        "complemento" => $request->complemento//"San Salvador"
                    ],
                    "telefono" => $request->emisortelefono,//"2281-8000",
                    "correo" => $request->emisorcorreo,//"mentesbrillantesagencia@gmail.com",
                    "codEstableMH" => "0000",
                    "codEstable" => "0000",
                    "codPuntoVentaMH" => "0000",
                    "codPuntoVenta" => "0000"
                ],
                "receptor" => [
                    "nit" => $request->receptorndocumento,//"06142803901121",
                    "nrc" => $request->receptornrc,//"2398810",
                    "nombre" => $request->receptornombre,//"Fundacion Emprende Hoy",
                    "codActividad" => "70200", //"73100",
                    "descActividad" => "Actividades de Consultoria",//"",
                    "nombreComercial" => null,
                    "direccion" => [
                        "departamento" => $request->receptordepartamento,//"06",
                        "municipio" => $request->receptormunicipio, //"14",
                        "complemento" => $request->receptorcomplemento//"San Salvador"
                    ],
                    "telefono" => $request->receptortelefono, //"2281-8000",
                    "correo" => $request->receptorcorreo,
                ],
                "otrosDocumentos" => null,
                "ventaTercero" => null,
                "cuerpoDocumento" => $cuerpodocumento,
                "resumen" => $resumen,
                "extension" => null,
                "apendice" => null
            ]
        ];
        $docJSON = json_encode($documento);
        //echo $docJSON;
        return $this->firmarDocumento($docJSON, $request->tipoDeDocumento);

    }

    public function facturadeExportacion(Request $request)
    {
        $formatter = new NumeroALetras();
        $detallesfactura = json_decode($request->detallesfactura);
        $cuerpodocumento = [];
        $i = 0;
        $totalnosujeto = 0;
        $totalexcento = 0;
        $totalgravado = 0;
        $totalDespuesto = 0;
        $totaliva = 0;
        foreach ($detallesfactura as $detalle) {
            $i++;
            $totalnosujeto += $detalle->ventasnosujetas;
            $totalexcento += $detalle->ventasexcentas;
            $totalgravado += $detalle->ventasafectas;
            $dato = [
                "numItem" => $i,
                "cantidad" => floatval($detalle->cantidad),
                "codigo" => null,
                "uniMedida" => 99,
                "descripcion" => $detalle->descripcion,
                "precioUni" => floatval($detalle->preciounitario),
                "montoDescu" => 0,
                "ventaGravada" => floatval($detalle->ventasafectas),
                "tributos" => null,
                "noGravado" => 0,
            ];
            $totaliva += round($detalle->ventasafectas / 1.13 * 0.13, 2);
            array_push($cuerpodocumento, $dato);
        }
        $resumen = [

            "totalGravada" => $totalgravado,
            "porcentajeDescuento" => 0,
            "totalDescu" => 0,
            "montoTotalOperacion" => $totalgravado,
            "totalNoGravado" => 0,
            "totalPagar" => $totalgravado,
            "totalLetras" => $formatter->toMoney($totalgravado, 2, "dolares", "centavos"),
            "condicionOperacion" => 2,
            "numPagoElectronico" => null,
            "descuento" => 0.0,
            "seguro" => 0.00,
            "flete" => 0.00,
            "descIncoterms" => null,
            "observaciones" => null,
            "codIncoterms" => null,

            "pagos" => null,
        ];
        $nitvendedorx = env('ENCRIPTED_NIT');//'06142803901121';
        $passPri = env('ENCRIPTED_PSW_PRI');//'Rr2Ll3rm0@$ñ@';
        $tipoDocumento = "11";
        $numeroControl = $this->generarNumeroControl($tipoDocumento);
        $documento = [

            "nit" => $nitvendedorx,
            "activo" => true,
            "passwordPri" => $passPri,

            "dteJson" => [
                "identificacion" => [
                    "version" => 1,
                    "ambiente" => "00",
                    "tipoDte" => "11",
                    "numeroControl" => $numeroControl,
                    "codigoGeneracion" => $this->generaruuid(),
                    "tipoModelo" => 1,
                    "tipoOperacion" => 1,
                    "tipoContingencia" => null,
                    "fecEmi" => date('Y-m-d'),
                    "horEmi" => date('h:i:s'),
                    "tipoMoneda" => "USD",
                    "motivoContigencia" => null
                ],
                "emisor" => [
                    "nit" => ($request->emisornit),//"06142803901121",
                    "nrc" => $request->emisornrc,//"2398810",
                    "nombre" => $request->emisornombre,//"JUAN MANUEL REYES",
                    "codActividad" => $request->actividademisor,//"73100",
                    "descActividad" => "Publicidad",
                    "nombreComercial" => $request->nombreComercial,//null,
                    "tipoEstablecimiento" => "01",
                    "direccion" => [
                        "departamento" => $request->emisordepartamento,//"06",
                        "municipio" => $request->emisormunicipio,//"14",
                        "complemento" => $request->complemento,//"San Salvador"
                    ],
                    "telefono" => $request->emisortelefono,//"2281-8000",
                    "correo" => $request->emisorcorreo,//"mentesbrillantesagencia@gmail.com",
                    "codEstableMH" => "0000",
                    "codEstable" => "0000",
                    "codPuntoVentaMH" => "0000",
                    "codPuntoVenta" => "0000",
                    "regimen" => null,
                    "recintoFiscal" => null,
                    "tipoItemExpor" => 2
                ],
                "receptor" => [
                    "tipoDocumento" => "36",
                    "numDocumento" => $request->receptorndocumento,//"06142803901121",
                    "nombre" => $request->receptornombre,//"EPA EL SALVADOR",
                    "descActividad" => "Actividades de Consultoria",
                    "telefono" => $request->receptortelefono,//"75342842",
                    "correo" => $request->receptorcorreo,//"epasv@gmail.com",
                    "nombreComercial" => "ACME",
                    "codPais" => "9300",
                    "nombrePais" => "EL SALVADOR",
                    "tipoPersona" => 1,
                    "complemento" => $request->receptorcomplemento,//"San Salvador Centro"
                ],
                "ventaTercero" => null,
                "resumen" => $resumen,
                "otrosDocumentos" => null,
                "cuerpoDocumento" => $cuerpodocumento,
                "apendice" => null
            ]
        ];
        $docJSON = json_encode($documento);
        return $this->firmarDocumento($docJSON, $request->tipoDeDocumento);
    }

    public function comprobanteDonacionElectronica(Request $request)
    {
        $formatter = new NumeroALetras();
        $detallesfactura = json_decode($request->detallesfactura);
        $cuerpodocumento = [];
        $i = 0;
        $totalDonacion = 0;
        foreach ($detallesfactura as $detalle) {
            $i++;
            $totalDonacion += $detalle->ventasafectas;
            $dato = [
                "numItem" => $i,
                "tipoDonacion" => 1,
                "cantidad" => floatval($detalle->cantidad),
                "codigo" => null,
                "uniMedida" => 99,
                "descripcion" => $detalle->descripcion,
                "depreciacion" => 0,
                "valorUni" => floatval($detalle->preciounitario),
                "valor" => floatval($detalle->ventasafectas)
            ];

            array_push($cuerpodocumento, $dato);
        }
        $resumen = [
            "valorTotal" => $totalDonacion,
            "totalLetras" => $formatter->toMoney($totalDonacion, 2, "Dolares Americanos", "Centavos"),
            "pagos" => [
                [
                    "codigo" => "02",
                    "montoPago" => $totalDonacion,
                    "referencia" => "Pago en especias"
                ]
            ]
        ];

        $nitvendedorx = env('ENCRIPTED_NIT');
        $passPri = env('ENCRIPTED_PSW_PRI');
        $tipoDocumento = "15";
        $numeroControl = $this->generarNumeroControl($tipoDocumento);
        $documento = [
            'nit' => $nitvendedorx,
            'activo' => true,
            'passwordPri' => $passPri,
            'dteJson' => [
                "identificacion" => [
                    "version" => 1,
                    "ambiente" => "00",
                    "tipoDte" => "15",
                    "numeroControl" => $numeroControl,
                    "codigoGeneracion" => $this->generaruuid(),
                    "tipoModelo" => 1,
                    "tipoOperacion" => 1,
                    "fecEmi" => date('Y-m-d'),
                    "horEmi" => date('h:i:s'),
                    "tipoMoneda" => "USD"
                ],
                "donante" => [
                    "tipoDocumento" => "36",
                    "numDocumento" => strval($request->receptorndocumento),
                    "nrc" => $request->receptornrc,
                    "nombre" => $request->receptornombre,
                    "codActividad"=>"70200",
                    "descActividad" => null,
                    "direccion" => null,
                    "telefono"=>"77958125",
                    "correo"=>"mineromemo429@gmail.com",
                    "codDomiciliado" => 2,
                    "codPais" => "9300"
                ],
                "donatario" => [
                    "tipoDocumento" => "36",
                    "numDocumento" => $request->emisornit,
                    "nrc" => $request->emisornrc,
                    "nombre" => $request->emisornombre,
                    "codActividad" => "73100",
                    "descActividad" => "publicidad",
                    "direccion" => [
                        "departamento" => $request->emisordepartamento,
                        "municipio" => $request->emisormunicipio,
                        "complemento" => $request->complemento
                    ],
                    "telefono" => $request->emisortelefono,
                    "correo" => $request->emisorcorreo,
                    "nombreComercial" => null,
                    "tipoEstablecimiento" => "01",
                    "codEstableMH" => null,
                    "codEstable" => null,
                    "codPuntoVentaMH" => null,
                    "codPuntoVenta" => null
                ],
                "otrosDocumentos" => [
                    [
                        "codDocAsociado" => 1,
                        "descDocumento" => "Otros",
                        "detalleDocumento" => "Donación de tres computadoras"
                    ]
                ],
                "cuerpoDocumento" => $cuerpodocumento,
                "resumen" => $resumen,
                "apendice" => null
            ]
        ];

        $docJSON = json_encode($documento);

        return $this->firmarDocumento($docJSON, $request->tipoDeDocumento);
    }

}
