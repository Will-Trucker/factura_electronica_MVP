@extends('layouts.app')

@section('link-css-js-assets')
    @vite(['resources/css/app.css','resources/js/app.js','resources/img/avatar5.png','resources/img/factura.png','resources/img/digital-key.png','resources/img/financial-advisor.png','resources/img/invoice.png','resources/img/idea.png','resources/img/invalid-vote.png','resources/img/send.png'])
@endsection

@section('content')
<div class="contenedor">

    <div class="cards">
        <div class="personaje">
            <div class="imagen_personaje"></div>
            <div class="detalle">
                <h2>Historial de Tokens</h2>
                <a href="{{route('token')}}" class="title">
                <div class="boton"><h6 class="t6">Entrar</h6></div></a>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_2">
            <div class="imagen_personaje_2"></div>
            <div class="detalle_2">
                <h2>Historial de Emisor</h2>
                <a href="{{route('emisor')}}" class="title"><div class="boton"><h6 class="t6">Entrar</h6></div></a>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_3">
            <div class="imagen_personaje_3"></div>
            <div class="detalle_3">
                <h2>Historial de Receptor</h2>
                <a href="{{route('receptor')}}" class="title"><div class="boton"><h6 class="t6">Entrar</h6></div></a>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_4">
            <div class="imagen_personaje_4"></div>
            <div class="detalle_4">
                <h2>Historial de DTE</h2>
                <a href="{{route('documento')}}" class="title"><div class="boton"><h6 class="t6">Entrar</h6></div></a>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_5">
            <div class="imagen_personaje_5"></div>
            <div class="detalle_5">
                <h2>Eventos de Contingencia</h2>
                <a href="#" class="title"><div class="boton"><h6 class="t6">Entrar</h6></div></a>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_6">
            <div class="imagen_personaje_6"></div>
            <div class="detalle_6">
                <h2>Eventos de invalidacion</h2>
                <a href="#" class="title"><div class="boton"><h6 class="t6">Entrar</h6></div></a>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="personaje_7">
            <div class="imagen_personaje_7"></div>
            <div class="detalle_7">
                <h2>Envios de DTE</h2>
                <a href="{{route('factura')}}" class="title"><div class="boton"><h6 class="t6">Entrar</h6></div></a>
            </div>
        </div>
    </div>

</div>
@endsection
