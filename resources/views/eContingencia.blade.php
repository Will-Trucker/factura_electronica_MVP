@extends('layouts.app')

@section('content')

<div class="container-md p-5 fondo">
        <h1>Eventos de Contingencia</h1>
       
        <a href="{{route('nuevoEContingencia')}}" class="btn btn-primary">Nuevo Evento de Contingencia</a>
        <div class="lista-registros">
            <table>
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>fecha</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse ($eventos as $evento)
                        <tr>
                            <th>{{$evento}}</th>
                            <th>fecha</th>
                        </tr>
                    @empty
                        <th>Sin datos</th>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection