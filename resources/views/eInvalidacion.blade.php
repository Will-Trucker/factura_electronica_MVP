@extends('layouts.app')

@section('content')

<div class="container-md p-5 fondo">
        <h1>Eventos de Invalidacion</h1>
       
        <div class="lista-registros">
            <table>
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>fecha</th>
                    </tr>
                </thead>
                <tbody>
                    
                    {{-- @forelse ($eventos as $evento) --}}
                        <tr>
                             <th>{{--{{$evento}}--}}</th> 
                            <th>fecha</th>
                        </tr>
                    {{-- @empty --}}
                        <th>Sin datos</th>
                    {{-- @endforelse --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection