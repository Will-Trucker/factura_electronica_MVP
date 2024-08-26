<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>| Fáctura Electronica</title>
    @vite([ 'resources/js/app.js','resources/css/index.css','resources/css/tokens.css','resources/css/emisor.css','resources/css/receptor.css','resources/js/numeroLetras.js'])
    <script src="/main.js"></script>
    <script src="{{Vite::asset('resources/js/numeroLetras.js')}}"></script>
    <script src="https://kit.fontawesome.com/9f312215fd.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="/imagenes/factura.png" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

  </head>
<body>

<nav class="navbar navbar-expand-lg menu mb-5">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="{{url('/')}}"><img src="/imagenes/factura.png" alt="logo" width="45px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav" id="listamenu">
        <li class="nav-item ms-3">
          <a class="nav-link text-white" href="{{route('tokens')}}">Historial Tokens</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link text-white" href="{{route('emisores')}}">Historial Emisor</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link text-white" href="{{route('receptores')}}">Historial Receptor</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link text-white" href="{{route('documentos')}}">Historial DTE</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link text-white" href="{{route('eContingencia')}}">Eventos de contingencia</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link text-white" href="{{route('eInvalidacion')}}">Eventos de invalidación</a>
        </li>


      </ul>
    </div>

    <div class="btn-group">

      <a class="nav-link text-white " href="{{route('facturacion')}}">Envios de DTE</a>

      <div class="ms-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Usuario

      </div>

  <ul class="dropdown-menu dropdown-menu-end">
    <li><button class="dropdown-item" type="button">Configuración</button></li>
    <li><button class="dropdown-item" type="button">Soporte Tecnico</button></li>
    <li><button class="dropdown-item" type="button">Decimales</button></li>
    <li><a href="{{route('tokens')}}" class="dropdown-item" type="button">Seccion de Token</a></li>
  </ul>
</div>

  </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@yield('content')
<script src="https://kit.fontawesome.com/9f312215fd.js" crossorigin="anonymous"></script>
@yield('customJS')
</body>
</html>
