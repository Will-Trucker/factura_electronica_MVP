@extends('layouts.app')

@section('content')

<div class="container-md p-5 cont">
    <div class="cont-p">
        @if(session()->has('descargarjson'))
        <meta http-equiv="refresh" content="5;url='/obtenerdoc' }}">
        @endif
        <h1 class="title-4">Documentos</h1>
        @if(session('success'))
        <div class="alert alert-success">
        {{ session('success') }}
        </div>
        @endif
        @if(session('mensaje'))
        <div class="alert alert-danger">
        {{ session('mensaje') }}
        <a class="nav-link text-black" href="{{route('reenviar')}}">reenviar</a>
        </div>
        @endif
        @if(session('observ'))
        <div class="alert alert-danger">
        {{ session('observ') }}
        </div>
        @endif
        <div class="d-flex">
            <form action="{{route('filtrarDocs')}}" method="get">
                <div class="d-flex">

                    <div class="input-group m-3">
                        <label class="input-group-text" for="tipoDocumento">Tipo DTE</label>
                        <select class="form-select" name="tipoDeDocumento" id="tipoDocumento" onchange="cambiarTipoDoc()">

                            <option value="1" class="bg-activo" selected>Factura Electrónica</option>
                            <option value="3" class="bg-activo">Comprobante de Crédito Fiscal. Electrónico.</option>
                            <option value="4">Nota de Remisión Electrónico.</option>
                            <option value="5">Nota de Crédito Electrónico.vv</option>
                            <option value="6">Nota de Débito Electrónico.</option>
                            <option value="7">Comprobante de Retención Electrónico.</option>
                            <option value="8">Comprobante de Liquidación Electrónico.</option>
                            <option value="9">Documento Contable de Liquidación Electrónico.</option>
                            <option value="11" class="bg-activo">Factura de Exportación Electrónica</option>
                            <option value="14" class="bg-activo">Factura de Sujeto Excluido Electrónica.</option>
                            <option value="15">Comprobante de Donación Electrónico.</option>
                        </select>
                    </div>

                    <button type="submit" class="ms-4 btn btn-primary m-3">Filtrar</button>
                </div>


            </form>
        </div>
        <div class="table-container">
        <div class="table-wrappers-em">
            <table class="flam-table">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Código de Generación</th>
                    <th>Sello de Recibido</th>
                    <th>Operaciones</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($documentos as $documento)
                    <tr>

                        <th>{{$documento->fhProcesamiento}}</th>
                        <th>{{$documento->codigoGeneracion}}</th>
                        <th>{{$documento->selloRecibido}}</th>
                        <th>
                            <div class="row">
                                <a class="btn btn-secondary mb-2" href="{{ route('obtenerpdf', ['codGeneracion' => $documento->codigoGeneracion]) }}" target="_self">Ver PDF</a>
                                {{-- <a class="btn btn-secondary mb-2" href="{{ route('obtenerpdf', ['codGeneracion' => $documento->codigoGeneracion]) }}">Obtener PDF</a> --}}
                                <a class="btn btn-secondary mb-2" href="{{ route('verJson', ['codGeneracion' => $documento->codigoGeneracion]) }}" target="_self">Ver JSON</a>
                                <a class="btn btn-secondary" href="{{ route('mandarComprobantes', ['codGeneracion' => $documento->codigoGeneracion]) }}">Mandar correo</a>


                            </div>
                        </th>
                    </tr>
                    @empty
                    <th colspan="4">Sin datos</th>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
