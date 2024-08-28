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
use App\Helpers\helpers;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function registro()
    {
        // ...
        $emisores = $this->obtenerEmisores(); // Obtiene todos los emisores de la base de datos
        $receptores = $this->obtenerReceptores();
        return view('facturacion', compact('emisores', 'receptores'));
    }

    function obtenerEmisores(){
        $emisores = Emisor::all()->toArray();
        return $emisores;
    }

    function obtenerReceptores(){
        $receptores = Receptor::all()->toArray();
        return $receptores;
    }

    function obtenerNumeroDeControl($tipoDte){
        $respuesta = NumeroControl::where('tipodte',$tipoDte)->first();
        if(!$respuesta){
            return rand(1,100);
        }

        $nuevoNumero = intval($respuesta->numero + 1);
        $respuesta->numero = $nuevoNumero;
        $respuesta->save();

        $codigo = str_pad((string) $nuevoNumero, 15, "0", STR_PAD_LEFT);
        return $codigo;
    }

    // Generar Codigo UUID V4
    function generaruuid(){
        if(verificarConexionInternet()){
            $apiUrl = 'https://www.uuidgenerator.net/api/version4';
            $response = Http::get($apiUrl);

            return strtoupper($response);
        }
    }

    // function obtenerNumeroDeControl($tipoDTE){
    //       // Buscar el registro en la base de datos
    //       $respuesta = NumeroControl::where('tipodte', $tipoDTE)->first();

    //       if ($respuesta) {
    //           // Incrementar el número
    //           $nuevo = intval($respuesta->numero) + 1;

    //           // Formatear el número
    //           $numero_cadena = (string) $nuevo;
    //           $codigo = str_pad($numero_cadena, 15, "0", STR_PAD_LEFT);

    //           return $codigo;
    //       } else {
    //           // Manejar el caso en el que no se encuentra el registro
    //           return null;
    //       }

    //   }

    public function docContingencia(Request $request, $tipo, $motivo, $codGen){
        if($request->hasFile('documento')){
            $archivo = $request->file('documento');

            if($archivo->isValid()){
                $contenidoJson = file_get_contents($archivo->path());
                $nuevoDoc = json_decode($contenidoJson);

                if($nuevoDoc !== null && json_last_error() === JSON_ERROR_NONE){
                    $cuerpoDte = json_decode($nuevoDoc->esquema);
                    $tipoDte = $cuerpoDte->identificacion->tipoDte;

                    if($tipoDte == '01'){
                        $tipoD = 'FE';
                        $ncontrol = "DTE-01-0001ONEC-".$this->obtenerNumeroDeControl('FE');
                    } else if ($tipoDte == '03') {
                        $tipoD = 'CCFE';
                        $ncontrol = "DTE-03-00010NEC-".$this->obtenerNumeroDeControl('CCFE');
                    } else if ($tipoDte == '11') {
                        $tipoD = 'FEXE';
                        $ncontrol = "DTE-11-00390001-".$this->obtenerNumeroDeControl('FEXE');
                    } else if($tipoDte == '14'){
                        $tipoD = 'FSEE';
                        $ncontrol = "DTE-14-00010001-".$this->obtenerNumeroDeControl('FSEE');
                    }

                    $cuerpoDte->identificacion->numeroControl = $ncontrol;

                    $cuerpoDte->identificacion->codigoGeneracion = $codGen;

                    $cuerpoDte->identificacion->motivoContin = null;

                    $cuerpoDte->identificacion->tipoContingencia = null;

                    // CREDENCIALES DE HACIENDA
                    $nitvendedorx = '06142803901121';
                    $passPri = 'iDJWKWGC@459bzM';
                    $Documento = [
                        'nit' => $nitvendedorx,
                        'activo' => true,
                        'passwordPri' => $passPri,
                        'dteJson' => $cuerpoDte
                    ];

                    $Documento = json_encode($Documento);
                    $this->firmarDocumento($Documento, $tipoD);
                } else {
                    return ['error' => 'El archivo no es un JSON válido'];
                }
            } else {
                return ['error' => 'El archivo no es válido'];
            }
        } else {
            return response()->json(['error' => 'No se proporcionó ningún archivo'], 400);
        }
    }

    public function guardarFactura(Request $request){
        // if($request->tipoDeDocumento == "CCFE"){
        //     return $this->creditoFiscal($request);
        // }

        if($request->tipoDeDocumento == "FE"){
            return $this->facturaElectronica($request);
        }

        if($request->tipoDeDocumento == "NRE"){
            //NOTE DE REMISION ELECTRONICA

        }
        if($request->tipoDeDocumento == "NRE"){
            //NOTE DE CREDITO ELECTRONICA

        }
        if($request->tipoDeDocumento == "NDE"){
            //NOTE DE DEBITO ELECTRONICA

        }
        if($request->tipoDeDocumento == "CRE"){
            //COMPROBANTE DE RETENCIÓN ELECTRONICO

        }
        if($request->tipoDeDocumento == "CLE"){
            //COMPROBANTE DE LIQUIDACION ELECTRONICO

        }
        if($request->tipoDeDocumento == "CDLE"){
            //DOCUMENTO CONTABLE DE LIQUIDACION ELECTRONICO

        }
        // if($request->tipoDeDocumento == "FEXE"){
        //     //FACTURA DE EXPORTACION ELECTRONICA
        //     return $this->facturadeExportacion($request);
        // }
        // if($request->tipoDeDocumento == "FSEE"){
        //     //FACTURA DE SUJETO EXCLUIDO ELECTRONICA
        //     return $this->facturadeSujetoExcluido($request);

        // }
        // if($request->tipoDeDocumento == "CDE"){
        //     //COMPROBANTE DE DONACIÓN ELECTRONICO
        //     return $this->comprobanteDonacionElectronica($request);
        // }
    }

    public function firmarDocumento($documento, $tipoDocumento){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost::8113/firmardocumento/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$documento,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);

        if(curl_errno($curl)){
            echo 'Error al realizar la solicitud: ' . curl_error($curl);
            print_r($info);
        }
        curl_close($curl);

        $cuerpojson = json_decode($documento);
        $cuerpojson = $cuerpojson->dteJson;
        $cuerpojson = json_encode($cuerpojson);

        return $this->mandarDocFirmado(json_decode($response), $tipoDocumento, $cuerpojson);
    }

    public function mandarDocFirmado($respuesta, $tipoDocumento, $esquema){
        $tipoDte = "01";
        $version = "1";

        if($tipoDocumento == "FE" || $tipoDocumento == "01"){
            $tipoDte = "01";
            $version = "1";
        }
        if($tipoDocumento == "CCFE" || $tipoDocumento == "03"){
            $tipoDte = "03";
            $version = "3";
        }
        if($tipoDocumento == "FEXE" || $tipoDocumento == "11"){
            $tipoDte = "11";
            $version = "1";
        }
        if($tipoDocumento == "FESE" || $tipoDocumento == "14"){
            $tipoDte = "14";
            $version = "1";
        }
        if($tipoDocumento == "CDE" || $tipoDocumento == "15"){
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

        $headers = [
            'Authorization' => Session::get('ultToken'),
            'Content-Type' => 'application/json',
        ];

        if(verificarConexionInternet()){
            $response = Http::withHeaders($headers)->post($apiUrl,$documento);
        } else {
            $response = null;
        }

        if($response != null){
            $this->actualizarNumeroControl($tipoDocumento);
        }

        return $this->guardarDocumento($response, $esquema);
    }

    public function actualizarNumeroControl($tipoDte){
        $respuesta = DB::table('reset_ndecontrol')
                        ->where('tipodte',$tipoDte)
                        ->first();

        if($respuesta){
            $nuevo = intval($respuesta['numero'])+1;
            DB::table('reset_ndecontrol')
            ->where('tipodte',$tipoDte)
            ->update(['numero' => $nuevo]);
        } else {
            DB::table('reset_ndecontrol')
            ->insert(['tipodte' => $tipoDte, 'numero' => 1]);

            $nuevo = 1;
        }

        return $nuevo;
    }

    public function guardarDocumento($response, $esquema){
        if($response == '' || $response == null){
            $esquema = json_decode($esquema);
            $codGeneracion = $esquema->identificacion->numeroControl;
            $esquema = json_encode($esquema);
            $pdfPath = 'contingencia/' . $codGeneracion . '.json';
            Storage::put($pdfPath, $esquema);
            echo 'Hubo un error al intentar procesarlo, se hara un evento de contingencia';

            return redirect()->route('documentos')->with('message','Hubo un error al intentar procesarlo, se hará una contingencia');
        }

        if($response != null && $response['estado'] == "PROCESADO"){
            $esquema = json_decode($esquema);
            $tipoDTE = $esquema->identificacion->tipoDte;
            $esquema = json_encode($esquema);

            $datos = [
                'fhProcesamiento' => $response['fhProcesamiento'],
                'codigoGeneracion' => $response['codigoGeneracion'],
                'selloRecibido' => $response['selloRecibido'],
                'esquema' => $esquema,
                'tipoDte' => $tipoDTE
            ];

            DB::table('documentos_procesados')->insert($datos);

            return redirect()->route('documentos')->with('success','El documento se procesó correctamente');
        } elseif ($response != null && $response['estado'] == "RECHAZADO"){
            $datos = [
                'fhProcesamiento' => $response['fhProcesamiento'],
                'codigoGeneracion' => $response['codigoGeneracion'],
                'selloRecibido' => $response['selloRecibido'],
                'observaciones' => implode(',', $response['observaciones']),
                'descripcionMsg' => $response['descripcionMsg']
            ];

            DB::table('documentos_rechazados')->insert($datos);

            return redirect()->route('documentos')
            ->with('mensaje', $response['descripcionMsg'])
            ->with('observ', implode(',', $response['observaciones']));
        }
    }

    public function facturaElectronica(Request $request){
        $formatter = new NumeroALetras();

        $detallesfactura = json_decode($request->detallesfactura);
        $cuerpodocumento = [];
        $i=0;
        $totalnosujeto = 0; $totalexcento = 0; $totalgravado = 0; $totalDespuesto = 0;
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
                "cantidad" =>floatval($detalle->cantidad),
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
                "ivaItem" => round($detalle->ventasafectas/1.13*0.13, 2)
            ];
            $totaliva += round($detalle->ventasafectas/1.13*0.13,2);
            array_push($cuerpodocumento, $dato);
        }
        $resumen = [
            "totalNoSuj"=> $totalnosujeto,
            "totalExenta"=> $totalexcento,
            "totalGravada"=> $totalgravado,
            "subTotalVentas"=> $totalgravado,
            "descuNoSuj"=> 0,
            "descuExenta"=> 0,
            "descuGravada"=> 0,
            "porcentajeDescuento"=> 0,
            "totalDescu"=> 0,
            "tributos"=> null,
            "subTotal"=> $totalgravado,
            "ivaRete1"=> 0,
            "reteRenta"=> 0,
            "montoTotalOperacion"=> $totalgravado,
            "totalNoGravado"=> 0,
            "totalPagar"=> $totalgravado,
            "totalLetras"=> $formatter->toMoney($totalgravado, 2, "dolares", "centavos")          ,
            "totalIva"=> round($totaliva, 2),
            "saldoFavor"=> 0,
            "condicionOperacion"=> 1,
            "pagos"=> null,
            "numPagoElectronico"=> null
        ];
          $nitvendedorx='06141101171056';
          $passPri = 'Am@z2Ll3rm0$ñ@';
          $documento = [
              'nit'=> $nitvendedorx,
              'activo'=>true,
              'passwordPri'=>$passPri,
              'dteJson'=>[
                  "identificacion"=>[
                          "version"=> 1,
                          "ambiente"=> "00",
                          "tipoDte"=> "01",//ir cambiando el numero de Control desde 400
                          "numeroControl"=> "DTE-01-0001ONEC-".$this->obtenerNumeroDeControl('FE'),
                          "codigoGeneracion"=> $this->generaruuid(),
                          "tipoModelo"=> 1,
                          "tipoOperacion"=> 1,
                          "tipoContingencia"=> null,
                          "motivoContin"=> null,
                          "fecEmi"=> date('Y-m-d'),
                          "horEmi"=> date('h:i:s'),
                          "tipoMoneda"=> "USD",
                      ],
                      "documentoRelacionado"=>null,
                      "emisor"=> [
                          //"nit"=> "$request->emisornit",
                          "nit"=> strval($request->emisornit),
                          "nrc"=> $request->emisornrc,
                          "nombre"=> $request->emisornombre,
                          "codActividad"=> "70200",
                          "descActividad"=> $request->actividademisor,
                          "nombreComercial"=> $request->nombreComercial,
                          "tipoEstablecimiento"=> "01",
                          "direccion"=>
                          [
                              "departamento"=> "06",
                              "municipio"=> "14",
                              "complemento"=> "San Salvador"
                          ],
                          "telefono"=> $request->emisortelefono,
                          "codEstableMH"=> null,
                          "codEstable"=> null,
                          "codPuntoVentaMH"=> null,
                          "codPuntoVenta"=> null,
                          "correo"=> "rafaeledudominguez@gmail.com"
                      ],
                      "receptor"=> [
                          "tipoDocumento"=> "36",
                          "numDocumento"=> "066948964",
                          "nrc"=> null,
                          "nombre"=> $request->emisornombre,
                          "codActividad"=> null,
                          "descActividad"=> null,
                          "direccion"=>
                          [
                              "departamento"=> "06",
                              "municipio"=> "14",
                              "complemento"=> "SAN SALVADOR"
                          ],
                          "telefono"=> "78291734",
                          "correo"=> "rafaeledudominguez@gmail.com "
                      ],
                      "otrosDocumentos"=>[[
                          "codDocAsociado"=> 3,
                          "descDocumento"=> null,
                          "detalleDocumento"=> null,
                          "medico"=>
                          [
                              "nombre"=> "JUAN MANUEL REYES",
                              "nit"=> null,
                              "docIdentificacion"=> "066948964",
                              "tipoServicio"=> 1
                          ]
                      ]],
                      "ventaTercero"=>[
                          "nombre"=> "JUAN MANUEL REYES",
                          "nit"=> "043474311"
                      ],
                      "cuerpoDocumento"=> $cuerpodocumento,
                      "resumen"=> $resumen,
                      "extension"=> [
                          "nombEntrega"=> null,
                          "docuEntrega"=> null,
                          "nombRecibe"=> null,
                          "docuRecibe"=> null,
                          "observaciones"=> null,
                          "placaVehiculo"=> null
                      ],

                      "apendice"=>
                      [[
                          "campo"=> "Campo",
                          "etiqueta"=> "Descripcion",
                          "valor"=> "null"

                      ]]

              ],

          ];

          $docJSON = json_encode($documento);
          //echo $docJSON;
          //echo "----------------------------------------------------------------------------------------------";
          return $this->firmarDocumento($docJSON, $request->tipoDeDocumento);
    }



    // public function firmarDocumento($documento, $tipoDocumento) {

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'http://localhost:8113/firmardocumento/',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_SSL_VERIFYPEER => false,
    //     CURLOPT_SSL_VERIFYHOST => false,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_POSTFIELDS =>$documento,
    //     CURLOPT_HTTPHEADER => array(
    //         'Content-Type: application/json'
    //     ),
    //     ));

    //     $response = curl_exec($curl);
    //     $info = curl_getinfo($curl);

    //     //echo $response;
    //     if(curl_errno($curl)) {
    //         echo 'Error al realizar la solicitud: ' . curl_error($curl);
    //         print_r($info);
    //     }
    //     curl_close($curl);

    //     //echo $response;
    //     //echo $documento;
    //     //echo $this->obtenerNumeroDeControl('FSEE');
    //     return $this->mandarDocFirmado(json_decode($response), $tipoDocumento);
    // }

    // public function mandarDocFirmado($respuesta, $tipoDocumento){

    //     $tipoDte="01";
    //     $version="1";
    //     if($tipoDocumento == "FE"){
    //         $tipoDte = "01";
    //         $version="1";
    //     }
    //     if($tipoDocumento == "CCFE"){
    //         $tipoDte = "03";
    //         $version="3";
    //     }
    //     if($tipoDocumento == "FEXE"){
    //         $tipoDte = "11";
    //         $version="1";
    //     }
    //     if($tipoDocumento == "FSEE"){
    //         $tipoDte = "14";
    //         $version="1";
    //     }
    //     if($tipoDocumento == "CDE"){
    //         $tipoDte = "15";
    //         $version="1";
    //     }
    //     $documento = [
    //         "ambiente"=>"00",
    //         "idEnvio"=>"1",
    //         "version"=>$version,
    //         "tipoDte"=>$tipoDte,
    //         "documento"=>$respuesta->body,
    //     ];
    //     //echo json_encode($documento)."  cuerpofirmado------respuesta  ";
    //     $apiUrl = "https://apitest.dtes.mh.gob.sv/fesv/recepciondte";

    //     $headers = [
    //         'Authorization' => ultimoToken(),
    //         'Content-Type' => 'application/json',
    //     ];

    //     $response = Http::withHeaders($headers)->post($apiUrl, $documento);
    //     dd($response);

    // }


    // public function updateNumControl($tipoDTE){
    //      // Buscar el registro en la base de datos
    //      $respuesta = NumeroControl::where('tipodte', $tipoDTE)->first();

    //      if ($respuesta) {
    //          // Incrementar el número
    //          $nuevo = intval($respuesta->numero) + 1;

    //          // Actualizar el registro en la base de datos
    //          $respuesta->numero = $nuevo;
    //          $respuesta->save();

    //          return $nuevo;
    //      } else {
    //          // Manejar el caso en el que no se encuentra el registro
    //          return null;
    //      }

        // $respuesta = buscar('numerocontrol', 'tipoDTE', $tipoDTE);

        // if ($respuesta) {
        //     // Calcula el nuevo número de control
        //     $nuevoNumero = intval($respuesta['numero']) + 1;

        //     // Actualiza el registro en la base de datos
        //     NumeroControl::where('tipoDTE', $tipoDTE)->update(['numero' => $nuevoNumero]);
        // } else {
        //     // Manejo de error si no se encuentra el registro
        //     // Puedes lanzar una excepción o manejarlo de otra manera
        //     throw new \Exception('Tipo de DTE no encontrado.');
        // }

    //}

    // public function saveDoc($response){
    //     if ($response['estado'] != null && $response['estado'] == "PROCESADO") {
    //         $datos = [
    //             "fecha" => $response['fhProcesamiento'],
    //             "codigoGeneracion" => $response['codigoGeneracion'],
    //             "selloRecibido" => $response['selloRecibido'],
    //             "observaciones" => implode(',', $response['observaciones']),
    //         ];

    //         Documentos::create($datos);

    //         return redirect()->route('documentos')
    //             ->with('success', 'El documento se proceso correctamente');
    //     } else if ($response['estado'] != null && $response['estado'] == "RECHAZADO") {
    //         $datos = [
    //             "fecha" => $response['fhProcesamiento'],
    //             "codigoGeneracion" => $response['codigoGeneracion'],
    //             "selloRecibido" => $response['selloRecibido'],
    //             "observaciones" => implode(',', $response['observaciones']),
    //         ];

    //         DocumentosRechazados::create($datos);

    //         echo " - ocurrio un error al momento de procesar - ";
    //         echo $response['descripcionMsg'];
    //         print_r($response['observaciones']);
    //         return redirect()->route('documentos')
    //             ->with('mensaje', $response['descripcionMsg'])
    //             ->with('observ', implode(',', $response['observaciones']));
    //     }
    // }

    // // Funciones para DTE
    // public function facturaElectronica(Request $request){
    //     $formatter = new NumeroALetras;

    //     $detallesFact = json_decode($request->detallesFactura);
    //     $cuerpoDocumento = [];

    //     $i = 0;

    //     $totalNoSujeto = 0;
    //     $totalExento = 0;
    //     $totalGravado = 0;
    //     $totalIva = 0;

    //     foreach($detallesFact as $detalle){
    //         $i++;
    //         $totalNoSujeto += $detalle->ventasnosujetas;
    //         $totalExento +=  $detalle->ventasexcentas;
    //         $totalGravado += $detalle->ventasafectas;
    //         $dato = [
    //             "numItem" => $i,
    //             "tipoItem" => 2,
    //             "numeroDocumento" => null,
    //             "cantidad" => floatval($detalle->cantidad),
    //             "codigo" => null,
    //             "codTributo" => null,
    //             "uniMedida" => 59,
    //             "descripcion" => $detalle->descripcion,
    //             "precioUni" => $detalle->preciounitario,
    //             "montoDescu" => 0,
    //             "ventaNoSuj" => floatval($detalle->ventasnosujetas),
    //             "ventaExenta" => floatval($detalle->ventasexcentas),
    //             "ventaGravada" => floatval($detalle->ventasafectas),
    //             "tributos" => null,
    //             "psv" => 0,
    //             "noGravado" => 0,
    //             "ivaItem" => round($detalle->ventasafectas/1.13*0.13,2)
    //         ];
    //         $totaliva += round($detalle->ventasafectas/1.13*0.13,2);
    //         array_push($cuerpoDocumento,$dato);
    //     }

    //     $resumen = [
    //         "totalNoSuj" => $totalNoSujeto,
    //         "totalExenta" => $totalExento,
    //         "totalGravada" => $totalGravado,
    //         "subTotalVentas" => $totalGravado,
    //         "descuNoSuj" => 0,
    //         "descuExenta" => 0,
    //         "descuGravada" => 0,
    //         "porcentajeDescuento" => 0,
    //         "totalDescu" => 0,
    //         "tributos" => null,
    //         "subtotal" => $totalGravado,
    //         "ivaReten1" => 0,
    //         "reteRenta" => 0,
    //         "montoTotalOperacion" => $totalGravado,
    //         "totalNoGravado" => 0,
    //         "totalPagar" => $totalGravado,
    //         "totalLetras" => $formatter->toMoney($totalGravado,2,"dolares","centavos")  ,
    //         "totalIva" => $totalIva,
    //         "saldoAFavor" => 0,
    //         "condicionOperacion" => 1,
    //         "pagos" => null,
    //         "numPagoElectronico" => null
    //     ];
    //     $nitAdmin = '06142803901121';
    //     $pswPRI = 'Rr2Ll3rm0@$ñ@';
    //     $documento = [
    //         'nit' => $nitAdmin,
    //         'activo' => true,
    //         'passwordPri' => $pswPRI,
    //         'dteJson' => [
    //             "identificacion" => [
    //                 "version" => 1,
    //                 "ambiente" => "00",
    //                 "tipoDTE" => "01",
    //                 "numeroControl" => "DTE-01-0001O000-".$this->obtenerNumeroDeControl('FE'),
    //                 "codigoGeneracion" => $this->generarUUID(),
    //                 "tipoModelo" => 1,
    //                 "tipoOperacion" => 1,
    //                 "tipoContingencia" => null,
    //                 "motivoContin" => null,
    //                 "fechEmi" => date('Y-m-d'),
    //                 "horEmi" => date('h:i:s'),
    //                 "tipoMoneda" => "USD"
    //             ],
    //             "documentoRelacionado" => null,
    //             "emisor" => [
    //                 "nit" => strval($request->emisornit),
    //                 "nrc" => $request->emisornrc,
    //                 "nombre" => $request->emisornombre,
    //                 "codActividad" => $request->actividademisor,
    //                 "descActividad" => "Publicidad",
    //                 "nombreComercial" => $request->nombrecomercial,
    //                 "tipoEstablecimiento" => "01",
    //                 "direccion" => [
    //                     "departamento" => $request->emisordepartamento,
    //                     "municipio" => $request->emisormunicipio,
    //                     "complemento" => $request->complemento,
    //                 ],
    //                 "telefono" => $request->emisortelefono,
    //                 "codEstableMH"=> "0000",
    //                 "codEstable"=>"0000",
    //                 "codPuntoVentaMH"=>"0000",
    //                 "codPuntoVenta"=> "0000",
    //                 "correo" => $request->emisorcorreo
    //             ],
    //             "receptor" => [
    //                 "tipoDocumento" =>  "36",
    //                 "numDocumento" => $request->ndocumento,
    //                 "nrc" => $request->receptornrc,
    //                 "codActividad" => null,
    //                 "descActividad" => null,
    //                 "direccion" => [
    //                     "departamento" => $request->receptordepartamento,
    //                     "municipio" => $request->receptormunicipio,
    //                     "complemento" => $request->receptorcomplemento
    //                 ],
    //                 "telefono" => $request->receptortelefono,
    //                 "correo" => $request->receptorcorreo
    //             ],
    //             "otrosDocumentos" => null,
    //             "ventaTercero" => null,
    //             "cuerpoDocumento" => $cuerpoDocumento,
    //             "resumen" => $resumen,
    //             "extension"=> [
    //                     "nombEntrega"=> null,
    //                     "docuEntrega"=> null,
    //                     "nombRecibe"=> null,
    //                     "docuRecibe"=> null,
    //                     "observaciones"=> null,
    //                     "placaVehiculo"=> null
    //             ],
    //             "apendice" => null
    //         ],
    //     ];

    //     $docJson = json_encode($documento);
    //     return $this->firmarDocumento($docJson,$request->tipoDeDocumento);

    // }

}
