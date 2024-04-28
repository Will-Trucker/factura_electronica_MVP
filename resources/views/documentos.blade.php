@extends('layouts.app')

@section('content')

<div class="container-md p-5 cont">
    <div class="cont-p">
        <h1 class="title-4">Documentos</h1>
        @if(session('success'))
        <div class="alert alert-success">
        {{ session('success') }}
        </div>
        @endif
        @if(session('mensaje'))
        <div class="alert alert-danger">
        {{ session('mensaje') }}
        </div>
        @endif
        @if(session('observ'))
        <div class="alert alert-danger">
        {{ session('observ') }}
        </div>
        @endif
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

                        <th>{{$documento['fecha']}}</th>
                        <th>{{$documento['codigoGeneracion']}}</th>
                        <th>{{$documento['selloRecibido']}}</th>
                        <th><a class="btn btn-secondary" href="{{ route('obtenerpdf', ['codGeneracion' =>$documento['codigoGeneracion']]) }}">Obtener PDF</a>
                        </th>
                    </tr>
                @empty
                    <th>Sin datos</th>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
