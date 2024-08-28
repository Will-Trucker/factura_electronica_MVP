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

class FacturaController extends Controller
{
    public function registro()
    {
        // ...
        $emisores = Emisor::all(); // Obtiene todos los emisores de la base de datos
        $receptores = Receptor::all();
        return view('facturacion', compact('emisores', 'receptores'));
    }

    // Generar Codigo UUID V4

    function generarUUID(){
        $uuidURL = 'https://www.uuidgenerator.net/api/version4';
        $response = Http::get($uuidURL);
        return strtoupper($response);
    }

    function obtenerNumeroDeControl($tipoDTE){
          // Buscar el registro en la base de datos
          $respuesta = NumeroControl::where('tipodte', $tipoDTE)->first();

          if ($respuesta) {
              // Incrementar el número
              $nuevo = intval($respuesta->numero) + 1;

              // Formatear el número
              $numero_cadena = (string) $nuevo;
              $codigo = str_pad($numero_cadena, 15, "0", STR_PAD_LEFT);

              return $codigo;
          } else {
              // Manejar el caso en el que no se encuentra el registro
              return null;
          }

      }

    public function saveTicket(Request $request){
        // Numero de Control: 90000
        if($request->tipoDeDTE == "FE"){
            return $this->facturaElectronica($request);
        }

        // if($request->tipoDeDTE == "CCFE"){
        //     return $this->creditoFiscal($request);
        // }
    }

    public function firmarDocumento($documento, $tipoDocumento) {

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
        CURLOPT_POSTFIELDS =>$documento,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);

        //echo $response;
        if(curl_errno($curl)) {
            echo 'Error al realizar la solicitud: ' . curl_error($curl);
            print_r($info);
        }
        curl_close($curl);

        //echo $response;
        //echo $documento;
        //echo $this->obtenerNumeroDeControl('FSEE');
        return $this->mandarDocFirmado(json_decode($response), $tipoDocumento);
    }

    public function mandarDocFirmado($respuesta, $tipoDocumento){

        $tipoDte="01";
        $version="1";
        if($tipoDocumento == "FE"){
            $tipoDte = "01";
            $version="1";
        }
        if($tipoDocumento == "CCFE"){
            $tipoDte = "03";
            $version="3";
        }
        if($tipoDocumento == "FEXE"){
            $tipoDte = "11";
            $version="1";
        }
        if($tipoDocumento == "FSEE"){
            $tipoDte = "14";
            $version="1";
        }
        if($tipoDocumento == "CDE"){
            $tipoDte = "15";
            $version="1";
        }
        $documento = [
            "ambiente"=>"00",
            "idEnvio"=>"1",
            "version"=>$version,
            "tipoDte"=>$tipoDte,
            "documento"=>$respuesta->body,
        ];
        //echo json_encode($documento)."  cuerpofirmado------respuesta  ";
        $apiUrl = "https://apitest.dtes.mh.gob.sv/fesv/recepciondte";

        $headers = [
            'Authorization' => ultimoToken(),
            'Content-Type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)->post($apiUrl, $documento);
        dd($response);

    }


    public function updateNumControl($tipoDTE){
         // Buscar el registro en la base de datos
         $respuesta = NumeroControl::where('tipodte', $tipoDTE)->first();

         if ($respuesta) {
             // Incrementar el número
             $nuevo = intval($respuesta->numero) + 1;

             // Actualizar el registro en la base de datos
             $respuesta->numero = $nuevo;
             $respuesta->save();

             return $nuevo;
         } else {
             // Manejar el caso en el que no se encuentra el registro
             return null;
         }

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

    }

    public function saveDoc($response){
        if ($response['estado'] != null && $response['estado'] == "PROCESADO") {
            $datos = [
                "fecha" => $response['fhProcesamiento'],
                "codigoGeneracion" => $response['codigoGeneracion'],
                "selloRecibido" => $response['selloRecibido'],
                "observaciones" => implode(',', $response['observaciones']),
            ];

            Documentos::create($datos);

            return redirect()->route('documentos')
                ->with('success', 'El documento se proceso correctamente');
        } else if ($response['estado'] != null && $response['estado'] == "RECHAZADO") {
            $datos = [
                "fecha" => $response['fhProcesamiento'],
                "codigoGeneracion" => $response['codigoGeneracion'],
                "selloRecibido" => $response['selloRecibido'],
                "observaciones" => implode(',', $response['observaciones']),
            ];

            DocumentosRechazados::create($datos);

            echo " - ocurrio un error al momento de procesar - ";
            echo $response['descripcionMsg'];
            print_r($response['observaciones']);
            return redirect()->route('documentos')
                ->with('mensaje', $response['descripcionMsg'])
                ->with('observ', implode(',', $response['observaciones']));
        }
    }

    // Funciones para DTE
    public function facturaElectronica(Request $request){
        $formatter = new NumeroALetras;

        $detallesFact = json_decode($request->detallesFactura);
        $cuerpoDocumento = [];

        $i = 0;

        $totalNoSujeto = 0;
        $totalExento = 0;
        $totalGravado = 0;
        $totalIva = 0;

        foreach($detallesFact as $detalle){
            $i++;
            $totalNoSujeto += $detalle->ventasnosujetas;
            $totalExento +=  $detalle->ventasexcentas;
            $totalGravado += $detalle->ventasafectas;
            $dato = [
                "numItem" => $i,
                "tipoItem" => 2,
                "numeroDocumento" => null,
                "cantidad" => floatval($detalle->cantidad),
                "codigo" => null,
                "codTributo" => null,
                "uniMedida" => 59,
                "descripcion" => $detalle->descripcion,
                "precioUni" => $detalle->preciounitario,
                "montoDescu" => 0,
                "ventaNoSuj" => floatval($detalle->ventasnosujetas),
                "ventaExenta" => floatval($detalle->ventasexcentas),
                "ventaGravada" => floatval($detalle->ventasafectas),
                "tributos" => null,
                "psv" => 0,
                "noGravado" => 0,
                "ivaItem" => round($detalle->ventasafectas/1.13*0.13,2)
            ];
            $totaliva += round($detalle->ventasafectas/1.13*0.13,2);
            array_push($cuerpoDocumento,$dato);
        }

        $resumen = [
            "totalNoSuj" => $totalNoSujeto,
            "totalExenta" => $totalExento,
            "totalGravada" => $totalGravado,
            "subTotalVentas" => $totalGravado,
            "descuNoSuj" => 0,
            "descuExenta" => 0,
            "descuGravada" => 0,
            "porcentajeDescuento" => 0,
            "totalDescu" => 0,
            "tributos" => null,
            "subtotal" => $totalGravado,
            "ivaReten1" => 0,
            "reteRenta" => 0,
            "montoTotalOperacion" => $totalGravado,
            "totalNoGravado" => 0,
            "totalPagar" => $totalGravado,
            "totalLetras" => $formatter->toMoney($totalGravado,2,"dolares","centavos")  ,
            "totalIva" => $totalIva,
            "saldoAFavor" => 0,
            "condicionOperacion" => 1,
            "pagos" => null,
            "numPagoElectronico" => null
        ];
        $nitAdmin = '06142803901121';
        $pswPRI = 'Rr2Ll3rm0@$ñ@';
        $documento = [
            'nit' => $nitAdmin,
            'activo' => true,
            'passwordPri' => $pswPRI,
            'dteJson' => [
                "identificacion" => [
                    "version" => 1,
                    "ambiente" => "00",
                    "tipoDTE" => "01",
                    "numeroControl" => "DTE-01-0001O000-".$this->obtenerNumeroDeControl('FE'),
                    "codigoGeneracion" => $this->generarUUID(),
                    "tipoModelo" => 1,
                    "tipoOperacion" => 1,
                    "tipoContingencia" => null,
                    "motivoContin" => null,
                    "fechEmi" => date('Y-m-d'),
                    "horEmi" => date('h:i:s'),
                    "tipoMoneda" => "USD"
                ],
                "documentoRelacionado" => null,
                "emisor" => [
                    "nit" => strval($request->emisornit),
                    "nrc" => $request->emisornrc,
                    "nombre" => $request->emisornombre,
                    "codActividad" => $request->actividademisor,
                    "descActividad" => "Publicidad",
                    "nombreComercial" => $request->nombrecomercial,
                    "tipoEstablecimiento" => "01",
                    "direccion" => [
                        "departamento" => $request->emisordepartamento,
                        "municipio" => $request->emisormunicipio,
                        "complemento" => $request->complemento,
                    ],
                    "telefono" => $request->emisortelefono,
                    "codEstableMH"=> "0000",
                    "codEstable"=>"0000",
                    "codPuntoVentaMH"=>"0000",
                    "codPuntoVenta"=> "0000",
                    "correo" => $request->emisorcorreo
                ],
                "receptor" => [
                    "tipoDocumento" =>  "36",
                    "numDocumento" => $request->ndocumento,
                    "nrc" => $request->receptornrc,
                    "codActividad" => null,
                    "descActividad" => null,
                    "direccion" => [
                        "departamento" => $request->receptordepartamento,
                        "municipio" => $request->receptormunicipio,
                        "complemento" => $request->receptorcomplemento
                    ],
                    "telefono" => $request->receptortelefono,
                    "correo" => $request->receptorcorreo
                ],
                "otrosDocumentos" => null,
                "ventaTercero" => null,
                "cuerpoDocumento" => $cuerpoDocumento,
                "resumen" => $resumen,
                "extension"=> [
                        "nombEntrega"=> null,
                        "docuEntrega"=> null,
                        "nombRecibe"=> null,
                        "docuRecibe"=> null,
                        "observaciones"=> null,
                        "placaVehiculo"=> null
                ],
                "apendice" => null
            ],
        ];

        $docJson = json_encode($documento);
        return $this->firmarDocumento($docJson,$request->tipoDeDocumento);


    }







}
