@extends('layouts.app')

@section('content')
    <div class="container-md p-5 cont">
        <div class="cont-p">
            <h1 class="title-1">Facturacion</h1>
            @if (session('descError'))
                <div class="alert alert-danger">
                    {{ session('descError') }}
                </div>
            @endif
            @if (session('observaciones'))
                <div class="alert alert-danger">
                    {{ session('observaciones') }}
                </div>
            @endif
            <form action="guardarFactura" method="post">
                @csrf

                <input type="hidden" name="totalLetras" id="totalLetras" value='cero'>

                <div class="d-flex">
                    <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(0)"
                        id="tipodoc-button">Tipo de documento</button>
                    <button type="button" class="btn ms-3 btn-secondary boton d-none" onclick="cambiarSeccion(1)"
                        id="token-button">Token</button>
                    <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(2)"
                        id="emisor-button">Emisor</button>
                    <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(3)"
                        id="receptor-button">Receptor</button>
                    <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(4)"
                        id="description-button">Descripción</button>
                    <button type="button" class="btn ms-3 btn-secondary boton" onclick="cambiarSeccion(5)"
                        id="enviar-button">Enviar</button>
                </div>
                <div class="mt-3" id="divisiones">
                    <div class="d-none" id="tipodocsection">
                        <h2 class="title-2">Tipo documento</h2>
                        <div class="row">
                            <div class="col">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="receptor-tipodocumento" class="col-sm-3 col-form-label cont-label">Tipo
                                            de Documento</label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-control-lg" name="tipoDeDocumento"
                                                id="tipoDocumento" onchange="cambiarTipoDoc()">
                                                <option value="FE" class="bg-activo" selected>Factura Electrónica
                                                </option>
                                                <option value="CCFE" class="bg-activo">Comprobante de Crédito Fiscal.
                                                    Electrónico.</option>
                                                <option value="NRE">Nota de Remisión Electrónico.</option>
                                                <option value="NCE">Nota de Crédito Electrónico.vv</option>
                                                <option value="NDE">Nota de Débito Electrónico.</option>
                                                <option value="CRE">Comprobante de Retención Electrónico.</option>
                                                <option value="CLE">Comprobante de Liquidación Electrónico.</option>
                                                <option value="DCLE">Documento Contable de Liquidación Electrónico.
                                                </option>
                                                <option value="FEXE" class="bg-activo">Factura de Exportación Electrónica
                                                </option>
                                                <option value="FSEE" class="bg-activo">Factura de Sujeto Excluido
                                                    Electrónica.</option>
                                                <option value="CDE">Comprobante de Donación Electrónico.</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                        <div class="d-none" id="tokenSection">
                            <h2 class="title-2">Token</h2>
                            <div class="row">
                                <div class="col">
                                    <div class="card-body">
                                        <div class="form-group row">
                                                <label for="nit" class="col-sm-3 col-form-label cont-label">NIT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default">
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="clave" class="col-sm-3 col-form-label">Contraseña</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="apikey"  class="col-sm-3 col-form-label">API Key</label>
                                            <div class="col-sm-9">
                                            <textarea name="apikey" id="apikey" cols="10" rows="5" class="form-control form-control-lg"></textarea>
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="px-5 py-4 text-center">
                                            <button type="button" class="btn btn-secondary" onclick="cambiarSeccion(2)">Siguiente</button>    
                                        </div>            
                                    </div>
                                </div>
                            </div>  
                        </div>      
{{-- 
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">NIT</span>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-default">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Contraseña</span>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-default">
                            </div>


                            <div class=" m-3">
                                <label for="apikey" class="form-label">API Key</label>
                                <textarea name="apikey" id="apikey" cols="10" rows="5" class="form-control"></textarea>

                            </div>




                            <button type="button" class="btn btn-secondary" onclick="cambiarSeccion(2)">Siguiente</button>
                            <!-- fin token section -->
                        </div> --}}
                        <div class="d-none" id="emisorSection">
                            <h2 class="title-2">Emisor</h2>
                            <select name="emisor" class="form-control" id="emisor" onBlur="traerEmisor()">
                                @foreach($emisores as $emisor)
                                <option value="{{ $emisor->id }}">{{ $emisor->Nombre }}</option>
                                @endforeach
                            </select>
                            <div class="row">
                                <div class="col">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="emisor-nombre"
                                            class="col-sm-3 col-form-label cont-label">Nombre</label>
                                            <div class="col-sm-9">
                                                <input name="emisornombre" type="text" class="form-control form-control-lg"
                                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="emisorNombre">
                                            </div>
                                        </div> 
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="nombrecomercial" class="col-sm-3 col-form-label cont-label">Nombre comercial</label>
                                            <div class="col-sm-9">
                                                <input name="nombrecomercial" type="text" class="form-control form-control-lg"
                                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                                                id="nombreComercial">
                                            </div>        
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="actividad" class="col-sm-3 col-form-label cont-label">Actividad</label>
                                            <div class="col-sm-9">
                                                <input name="actividademisor" id="actividademisor" type="text"
                                                class="form-control form-control-lg" aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default"> 
                                            </div>    
                                        </div>      
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label cont-label" for="NCR">Número de Registro de Contribuyente</label> 
                                            <div class="col-sm-9">
                                                <input name="emisornrc" id="emisornrc" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label cont-label" for="NIT">NIT</label>
                                            <div class="col-sm-9">
                                                <input name="emisornit" id="emisornit" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="departamento" class="col-sm-3 col-form-label cont-label">Departamentos</label>
                                            <div class="col-sm-9">
                                                <input name="emisordepartamento" id="emisordepartamento" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>    
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="municipio" class="col-sm-3 col-form-label cont-label">Municipio</label>
                                            <div class="col-sm-9">
                                                <input name="emisormunicipio" id="emisormunicipio" type="text"
                                                class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>     
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="complemento" class="col-sm-3 col-form-label cont-label">Complemento</label>
                                            <div class="col-sm-9">
                                                <input name="complemento" id="complemento" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">   
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="telefono" class="col-sm-3 col-form-label cont-label">Teléfono</label>
                                            <div class="col-sm-9">
                                                <input name="emisortelefono" id="emisortelefono" type="text"
                                                class="form-control form-control-lg" aria-label="Sizing example input" pattern="\+503 [267][0-9]{3}-[0-9]{4}" aria-describedby="inputGroup-sizing-default"> 
                                            </div>
                                        </div> 
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="correo" class="col-sm-3 col-form-label cont-label">Correo</label>
                                            <div class="col-sm-9">
                                                <input name="emisorcorreo" id="emisorcorreo" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">                     
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="px-5 py-4 text-center">
                                            <button type="button" class="btn btn-secondary" onclick="cambiarSeccion(3)">Siguiente</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                            {{-- <div class="row">
                                <div class="col">
                                    <h2>Emisor</h2>
                                </div>
                                <div class="col">
                                    <select name="emisor" class="form-control" id="emisor" onBlur="traerEmisor()">
                                        @foreach ($emisores as $emisor)
                                            <option value="{{ $emisor['Nombre'] }}">{{ $emisor['Nombre'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
                                        <input name="emisornombre" type="text" class="form-control"
                                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                                            id="emisorNombre">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Nombre
                                            Comercial</span>
                                        <input name="nombrecomercial" type="text" class="form-control"
                                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                                            id="nombreComercial">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Actividad</span>
                                        <input name="actividademisor" id="actividademisor" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>

                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">NRC</span>
                                        <input name="emisornrc" id="emisornrc" type="text" class="form-control"
                                            aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">NIT</span>
                                        <input name="emisornit" id="emisornit" type="text" class="form-control"
                                            aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Departamento</span>
                                        <input name="emisordepartamento" id="emisordepartamento" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Municipio</span>
                                        <input name="emisormunicipio" id="emisormunicipio" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Complemento</span>
                                        <input name="complemento" id="complemento" type="text" class="form-control"
                                            aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Telefono</span>
                                        <input name="emisortelefono" id="emisortelefono" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Correo</span>
                                        <input name="emisorcorreo" id="emisorcorreo" type="text" class="form-control"
                                            aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary"
                                onclick="cambiarSeccion(3)">Siguiente</button>
                        </div> --}}
                        <div class="d-none" id="receptorSection">
                            <h2 class="title-2">Receptor</h2>
                            <select name="receptor" class="form-control" id="receptor" onblur="traerReceptor()">
                                @foreach ($receptores as $receptor)
                                    <option value="{{ $receptor->id }}">{{ $receptor->Nombre }}</option>
                                @endforeach
                            </select>
                            <div class="row">
                                <div class="col">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="receptornombre" class="col-sm-3 col-form-label cont-label">Nombre</label>
                                            <div class="col-sm-9">
                                                <input name="receptornombre" id="receptornombre" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">  
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="tipodocumento" class="col-sm-3 col-form-label cont-label">Tipo de documento</label>
                                            <div class="col-sm-9">
                                                <input name="tipodocumento" id="tipodocumento" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="receptorndocumento" class="col-sm-3 col-form-label cont-label">N° Documento</label>
                                            <div class="col-sm-9">
                                                <input name="ndocumento" id="receptorndocumento" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="receptornrc" class="col-sm-3 col-form-label cont-label">NRC</label>
                                            <div class="col-sm-9">
                                                <input name="receptornrc" id="receptornrc" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="receptordepartamento"class="col-sm-3 col-form-label cont-label">Departamento</label>
                                            <div class="col-sm-9">
                                                <input name="receptordepartamento" id="receptordepartamento" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">                 
                                            </div>
                                        </div> 
                                        <hr class="mx-n3">
                                        <div class="form-group row">
                                            <label for="receptormunicipio" class="col-sm-3 col-form-label cont-label">Municipio</label>   
                                            <div class="col-sm-9">
                                                <input name="receptormunicipio" id="receptormunicipio" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                        </div>
                                        <hr class="mx-n3"> 
                                        <div class="form-group row">
                                            <label for="receptorcomplemento" class="col-sm-3 col-form-label cont-label">Complemento</label>
                                            <div class="col-sm-9">
                                                <input name="receptorcomplemento" id="receptorcomplemento" type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">                
                                            </div>
                                        </div>
                                        <hr class="mx-n3">
                                        <div class="px-5 py-4 text-center">
                                            <button type="button" class="btn btn-secondary" onclick="cambiarSeccion(4)">Siguiente</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                            {{-- <div class="row">
                                <div class="col">
                                    
                                </div>
                                <div class="col">
                                    <select name="receptor" class="form-control" id="receptor"
                                        onblur="traerReceptor()">
                                        @foreach ($receptores as $receptor)
                                            <option value="{{ $receptor['Nombre'] }}">{{ $receptor['Nombre'] }}</option>
                                        @endforeach

                                    </select>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
                                        <input name="receptornombre" id="receptornombre" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Tipo de
                                            Documento</span>
                                        <input name="tipodocumento" id="tipodocumento" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">N° documento</span>
                                        <input name="ndocumento" id="receptorndocumento" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">NRC</span>
                                        <input name="receptornrc" id="receptornrc" type="text" class="form-control"
                                            aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Departamento</span>
                                        <input name="receptordepartamento" id="receptordepartamento" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>

                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Municipio</span>
                                        <input name="receptormunicipio" id="receptormunicipio" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Complemento</span>
                                        <input name="receptorcomplemento" id="receptorcomplemento" type="text"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>

                                </div>
                            </div>
                            <div class="row" id="receptorExportacion">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Nombre del
                                            País</span>
                                        <input name="paisExp" id="paisExp" type="text" class="form-control"
                                            aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary"
                                onclick="cambiarSeccion(4)">Siguiente</button>
                            <!-- fin receptor section -->
                        </div> --}}
                        <div class="d-none" id="enviarSection">
                            <h2>Enviar</h2>

                            <button type="submit" class="ms-3 btn btn-primary">Guardar</button>

                        </div>
                    </div>
                    <input type="hidden" name="detallesfactura" value="" id="detallesfactura">

            </form>
            <div class="">
                <div class="d-none" id="descripcionSection">

                    <div class="" id="detallesnormal">

                        <div class="d-flex">
                            <h2>Descripcion</h2>
                            <div class="ms-3">
                                <button onclick="agregarDetalle()" class="btn btn-primary">Agregar detalle</button>
                            </div>
                        </div>

                        <table class="table table-bordered">
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
                                        <th scope="row"><input class="cant" type="number"
                                                onblur="calcularVentas()" value=0></th>
                                        <td><input type="text" value="" onblur="calculoDetalles()"></td>
                                        <td><input type="number" name="precio" class="precios"
                                                onblur="calcularVentas()" value=0></td>
                                        <td>0.0</td>
                                        <td>0.0</td>
                                        <td>0.0</td>
                                    </tr>
                                @endfor

                            </tbody>
                        </table>

                        <div class="table-responsive ">
                            <table class="table table-sm table-bordered ">
                                <thead class="thead">
                                    <tr>
                                        <th rowspan="2" colspan="1" class="align-top totalL" id="letras">Son:
                                        </th>
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
                    </div>

                    <div class="table-responsive d-none" id="liquidacion">
                        <h1>liquidacion</h1>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha de Generación</th>
                                    <th scope="col">tipo DTE</th>
                                    <th scope="col">Numero de documento</th>
                                    <th scope="col">Ventas No Sujetas</th>
                                    <th scope="col">Ventas Excentas</th>
                                    <th scope="col">Ventas Afectas</th>
                                </tr>
                            </thead>
                            <tbody id="tablaDetallesLiquidacion">
                                @for ($i = 0; $i < 5; $i++)
                                    <tr>
                                        <th scope="row"><input class="cant" type="number"
                                                onblur="calcularVentas()" value=0></th>
                                        <td><input type="text" value="" onblur="calculoDetalles()"></td>
                                        <td><input type="number" name="precio" class="precios"
                                                onblur="calcularVentas()" value=0></td>
                                        <td>0.0</td>
                                        <td>0.0</td>
                                        <td><input type="number" name="precio" class="precios"
                                                onblur="calcularVentas()" value=0></td>

                                    </tr>
                                @endfor

                            </tbody>
                        </table>
                    </div>
                    <!-- fin description section -->
                </div>


            </div>


        </div>
    @endsection
