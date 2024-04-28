@extends('layouts.app')

@section('content')

<div class="container-md p-5 cont">
        <div class="cont-p">
        <h1 class="title-1">Receptor</h1>
        <div class="cont-2">
        <button type="button" class="btn btn-info" onclick="cambiarSeccion(3)" id="receptor-button" style="font-weight: bold; font-size: 1rem;">Registrar</button>
        </div>
        <form action="guardarreceptor" method="post">
            @csrf
            <div class="mt-3" id="divisiones">
                <div class="d-none" id="receptorSection">
                    <h2 class="title-2">Ingresar Receptor</h2>
                    <div class="row">
                        <div class="col">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="receptor-nombre" class="col-sm-3 col-form-label cont-label">Nombre</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nombre" id="nombre" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">    
                                <div class="form-group row">
                                    <label for="receptor-tipodocumento" class="col-sm-3 col-form-label cont-label">Tipo de documento</label>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-lg" name="tipodocumento">
                                            <option value="1">Factura Electrónica</option>
                                            <option value="2">Comprobante de Crédito Fiscal. Electrónico</option>
                                            <option value="3">Nota de Remisión Electrónico</option>
                                            <option value="4">Nota de Crédito Electrónico</option>
                                            <option value="5">Nota de Débito Electrónico</option>
                                            <option value="6">Comprobante de Retención Electrónico</option>
                                            <option value="7">Comprobante de Liquidación Electrónico</option>
                                            <option value="8">Documento Contable de Liquidación Electrónico</option>
                                            <option value="9">Factura de Exportación Electrónica</option>
                                            <option value="10">Factura de Sujeto Excluido Electrónica</option>
                                            <option value="11">Comprobante de Donación Electrónico</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="receptor-ndocumento" class="col-sm-3 col-form-label cont-label">N° documento</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="ndocumento" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="receptor-nrc" class="col-sm-3 col-form-label cont-label">NRC</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nrc" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="receptor-departamento" class="col-sm-3 col-form-label cont-label">Departamento</label>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-lg" name="departamento">
                                            <option value="1">Departamento</option>
                                            <option value="2">datos</option>
                                            <option value="3">datos</option>
                                            <option value="4">datos</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="receptor-municipio" class="col-sm-3 col-form-label cont-label">Municipio</label>
                                    <div class="col-sm-9">
                                        <select class="form-control form-control-lg" name="municipio">
                                            <option value="1">Municipio</option>
                                            <option value="2">datos</option>
                                            <option value="3">datos</option>
                                            <option value="4">datos</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="receptor-complemento" class="col-sm-3 col-form-label cont-label">Complemento</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="complemento" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="px-5 py-4 text-center">
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger btn-lg">ENVIAR</button>
                                </div>
                            </div>        
                        </div>
                    </div>
               </div>        
{{-- 
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
                                <input type="text" name="nombre" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text"  id="inputGroup-sizing-default">Tipo de Documento</span>
                                <input type="text" name="tipodocumento" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                        <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">N° documento</span>
                                <input type="text" name="ndocumento" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">NRC</span>
                                <input type="text" name="nrc" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select class="form-control" name="departamento">
                                <option value="1">Departamento</option>
                                <option value="2">datos</option>
                                <option value="3">datos</option>
                                <option value="4">datos</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control" name="municipio">
                                <option value="1">Municipio</option>
                                <option value="2">datos</option>
                                <option value="3">datos</option>
                                <option value="4">datos</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Complemento</span>
                                <input type="text" name="complemento" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="ms-3 btn btn-primary">Guardar</button> --}}
                    <!-- fin receptor section -->
                </div>
            </div>
        </form>
        <div class="table-container">
            <div class="table-wrappers-em">
                <table class="flam-table">
                    <thead>
                    <tr>
                            <th>Nombre</th>
                            <th>Tipo documento</th>
                            <th>NRC</th>
                            <th>Operaciones</th>
                    </tr>
                    </thead>
                    <tbody>

                        {{-- @forelse ($receptores as $receptor) --}}
                            <tr>
                                <th> {{-- {{$receptor['nombre']}} --}}</th>
                                <th> {{-- {{$receptor['tipodocumento']}} --}}</th>
                                <th> {{-- {{$receptor['nrc']}} --}}</th>
                                <th>
                                <input type="button" value="Modificar" data-bs-toggle="modal" data-bs-target="#modal_modificar{{-- {{ $receptor['nrc'] }} --}}" class="btn btn-success">
                                <input type="button" value="Eliminar" data-bs-toggle="modal" data-bs-target="#modal_eliminar{{-- {{ $receptor['nrc'] }}  --}}" class="btn btn-danger">
                                </th>
                            </tr>

                            @include('receptor_modificar')
                            @include('receptor_eliminar')
                        {{-- @empty --}}
                            <th>Sin datos</th>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>
    
@endsection
