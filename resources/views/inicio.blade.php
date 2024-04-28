@extends('layouts.app')

@section('content')
<div class="contenedor">

    <div class="cards">
        <div class="personaje">
            <div class="imagen_personaje"></div>
            <div class="detalle">
                <h2>Historial de Tokens</h2>
                <div class="boton"><a href="{{route('tokens')}}"><h6>Entrar</h6></a></div>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_2">
            <div class="imagen_personaje_2"></div>
            <div class="detalle_2">
                <h2>Historial de Emisor</h2>
                <div class="boton"><a href="{{route('emisores')}}"><h6>Entrar</h6></a></div>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_3">
            <div class="imagen_personaje_3"></div>
            <div class="detalle_3">
                <h2>Historial de Receptor</h2>
                <div class="boton"><a href="{{route('receptores')}}"><h6>Entrar</h6></a></div>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_4">
            <div class="imagen_personaje_4"></div>
            <div class="detalle_4">
                <h2>Historial de DTE</h2>
                <div class="boton"><a href="{{route('documentos')}}"><h6>Entrar</h6></a></div>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_5">
            <div class="imagen_personaje_5"></div>
            <div class="detalle_5">
                <h2>Eventos de Contingencia</h2>
                <div class="boton"><a href="{{route('eContingencia')}}"><h6>Entrar</h6></a></div>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_6">
            <div class="imagen_personaje_6"></div>
            <div class="detalle_6">
                <h2>Eventos de invalidacion</h2>

                <div class="boton"><a href="{{route('eInvalidacion')}}"><h6>Entrar</h6></a></div>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_7">
            <div class="imagen_personaje_7"></div>
            <div class="detalle_7">
                <h2>Envios de DTE</h2>
                <div class="boton"><a href="{{route('facturacion')}}"><h6>Entrar</h6></div>
            </div>
        </div>
    </div>

</div>
@endsection
