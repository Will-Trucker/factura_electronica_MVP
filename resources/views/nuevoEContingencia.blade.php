@extends('layouts.app')

@section('content')

<div class="container-md p-5 fondo">
        <h1 class="ms-3">Evento de Contingencia</h1>
        @if(session('descError'))
        <div class="alert alert-danger">
        {{ session('descError') }}
        </div>
        @endif
        @if(session('observaciones'))
        <div class="alert alert-danger">
        {{ session('observaciones') }}
        </div>
        @endif
        <form action="guardarFactura" method="post">
            @csrf
            
            <div class="mt-3" id="divisiones">
                <div class="" id="emisorSection">
                    <div class="row">
                        <div class="col">
                            
                            <h2>Emisor</h2>
                        </div>
                        <div class="col">
                            <select name="emisor" class="form-control" id="emisor" onBlur="traerEmisor()">
                                @foreach ($emisores as $emisor)
                                    <option value="{{$emisor['nombre']}}">{{$emisor['nombre']}}</option>
                                @endforeach
                                
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
                                <input name="emisornombre" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="emisorNombre">
                            </div>
                            
                            
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nombre Comercial</span>
                                <input name="nombrecomercial" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="nombreComercial">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Actividad</span>
                                <input name="actividademisor"  id="actividademisor" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                            <select class="form-control d-none" name="actividad" id="actividad">
                                <option value="1">Actividad</option>
                                <option value="2">datos</option>
                                <option value="3">datos</option>
                                <option value="4">datos</option>
                            </select>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">NRC</span>
                                <input name="emisornrc" id="emisornrc" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">NIT</span>
                                <input name="emisornit" id="emisornit" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Departamento</span>
                                <input name="emisordepartamento" id="emisordepartamento" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                            <select class="form-control d-none" name="municipio">
                                <option value="1">Departamento</option>
                                <option value="2">datos</option>
                                <option value="3">datos</option>
                                <option value="4">datos</option>
                            </select>
                        </div>
                        <div class="col">
                        <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Municipio</span>
                                <input name="emisormunicipio" id="emisormunicipio" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                            <select class="form-control d-none" name="municipio">
                                <option value="1">Municipio</option>
                                <option value="2">datos</option>
                                <option value="3">datos</option>
                                <option value="4">datos</option>
                            </select>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Complemento</span>
                                <input name="complemento" id="complemento" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">telefono</span>
                                <input name="emisortelefono" id="emisortelefono" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Correo</span>
                                <input name="emisorcorreo" id="emisorcorreo" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>

                        </div>
                    </div>
                </div>
                
                <div class="" id="enviarSection">
                    <h2>Enviar</h2>

                    <button type="submit" class="ms-3 btn btn-primary">Guardar</button>
                    
                </div>
            </div>

            <input type="hidden" name="detallesfactura" value="" id="detallesfactura">

            <div class="" id="tipodocsection">
                <h2>Tipo documento</h2>
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="tipoDocumento">DTE</label>
                            <select class="form-select" name="tipoDeDocumento" id="tipoDocumento" onchange="cambiarTipoDoc()">
                                
                                <option value="FE" selected>Factura Electrónica</option>
                                <option value="CCFE">Comprobante de Crédito Fiscal. Electrónico.</option>
                                <option value="NRE">Nota de Remisión Electrónico.</option>
                                <option value="NCE">Nota de Crédito Electrónico.vv</option>
                                <option value="NDE">Nota de Débito Electrónico.</option>
                                <option value="CRE">Comprobante de Retención Electrónico.</option>
                                <option value="CLE">Comprobante de Liquidación Electrónico.</option>
                                <option value="DCLE">Documento Contable de Liquidación Electrónico.</option>
                                <option value="FEXE">Factura de Exportación Electrónica</option>
                                <option value="FSEE">Factura de Sujeto Excluido Electrónica.</option>
                                <option value="CDE">Comprobante de Donación Electrónico.</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="col-8">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Código de Generacion</span>
                            <input name="codigoGen" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="codigoGen">
                        </div>
                    </div>

                </div>
                
            </div>
        </form>    
            
            
        
    </div>
@endsection