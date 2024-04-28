@extends('layouts.app')

@section('content')

<div class="container-md p-5 fondo">
        <h1 class="ms-3">Facturación</h1>
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
            <input type="hidden" name="totalLetras" id="totalLetras" value='cero'>

            <div class="d-flex">
                <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(0)" id="tipodoc-button">Tipo de documento</button>
                <button type="button" class="btn ms-3 btn-secondary boton d-none" onclick="cambiarSeccion(1)" id="token-button">Token</button>
                <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(2)" id="emisor-button">Emisor</button>
                <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(3)" id="receptor-button">Receptor</button>
                <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(4)" id="description-button">Descripción</button>
                <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(5)" id="enviar-button">Enviar</button>
            </div>
            <div class="mt-3" id="divisiones">
                <div class="" id="tipodocsection">
                    <h2>Tipo documento</h2>
                    
                    
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="tipoDocumento">Options</label>
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
                </div>
                <div class="d-none" id="tokenSection">
                    <h2>Token</h2>
                    
                            
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">NIT</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                       
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Contraseña</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
    
                        
                            <div class=" m-3">
                                <label for="apikey" class="form-label">API Key</label>
                                <textarea name="apikey" id="apikey" cols="10" rows="5" class="form-control"></textarea>

                            </div>
    
                       
                            
                        
                    <button type="button" class="btn btn-secondary" onclick="cambiarSeccion(2)">Siguiente</button>
                    <!-- fin token section -->
                </div>
                <div class="d-none" id="emisorSection">
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
                    <button type="button" class="btn btn-secondary" onclick="cambiarSeccion(3)">Siguiente</button>
                    <!-- fin emisor section -->
                </div>
                <div class="d-none" id="receptorSection">
                    <div class="row">
                        <div class="col">
                            <h2>Receptor</h2>
                        </div>
                        <div class="col">
                            <select name="receptor" class="form-control" id="receptor" onblur="traerReceptor()">
                                @foreach ($receptores as $receptor)
                                    <option value="{{$receptor['nombre']}}">{{$receptor['nombre']}}</option>
                                @endforeach
                                
                            </select>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
                                <input name="receptornombre" id="receptornombre" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tipo de Documento</span>
                                <input name="tipodocumento" id="tipodocumento" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                        <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">N° documento</span>
                                <input name="ndocumento" id="ndocumento" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">NRC</span>
                                <input name="receptornrc" id="receptornrc" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Departamento</span>
                                <input name="receptordepartamento" id="receptordepartamento" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
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
                                <input name="receptormunicipio" id="receptormunicipio" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                            <select class="form-control d-none" name="municipio">
                                <option value="1">Municipio</option>
                                <option value="2">datos</option>
                                <option value="3">datos</option>
                                <option value="4">datos</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Complemento</span>
                                <input name="receptorcomplemento" id="receptorcomplemento" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>

                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="cambiarSeccion(4)">Siguiente</button>
                    <!-- fin receptor section -->
                </div>
                <div class="d-none" id="enviarSection">
                    <h2>Enviar</h2>

                    <button type="submit" class="ms-3 btn btn-primary">Guardar</button>
                    
                </div>
            </div>
            <input type="hidden" name="detallesfactura" value="" id="detallesfactura">

        </form>    
            <div class="">
                <div class="d-none" id="descripcionSection">
                    <h2>Descripcion</h2>

                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                            <th scope="col">Cant</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Precio Unitario</th>
                            <th scope="col">Ventas No Sujetas</th>
                            <th scope="col">Ventas Excentas</th>
                            <th scope="col">Ventas Afectas</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDetalles">
                            @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <th scope="row"><input class="cant" type="number" onblur="calcularVentas()" value=0></th>
                                <td><input type="text" value="" onblur="calculoDetalles()"></td>
                                <td><input type="number" name="precio" class="precios" onblur="calcularVentas()" value=0></td>
                                <td>0.0</td>
                                <td>0.0</td>
                                <td>0.0</td>
                            </tr>    
                            @endfor
                            
                        </tbody>
                    </table>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered ">
                            <thead class="thead">
                                <tr>
                                    <th  rowspan="2" colspan="1" class="align-top totalL" id="letras">Son: </th>
                                    <th class="precios align-middle" rowspan="2">Sumas</th>
                                    
                                    <th class="precios">Venta Excenta</th>
                                    <th class="precios">Venta no sujeta</th>
                                    <th class="precios">Venta gravada</th>
                                    
                                    
                                </tr>
                                <tr>
                                    
                                    <th id="vExcenta">$0</th>
                                    <th id="vNosujeta">$0</th>
                                    <th id="vGravada">$0</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2">13% IVA</th>
                                    <th id="iva">0</th>
                                </tr>
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2">SUB TOTAL</th>
                                    <th id="subtotal">0</th>
                                </tr>
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2">VENTA EXCENTA</th>
                                    <th id="Vexcenta">0</th>
                                </tr>
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2">VENTA NO SUJETAS</th>
                                    <th id="Vnosujeta">0</th>
                                </tr>
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2">SUB TOTAL</th>
                                    <th id="subtotal2">0</th>
                                </tr>
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2">VENTA TOTAL</th>
                                    <th id="total">0</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- fin description section -->
                </div>
                

            </div> 
            
        
    </div>
@endsection