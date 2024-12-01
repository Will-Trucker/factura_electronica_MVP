
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>| MVP Facturador</title>
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/numeroLetras.js','resources/img/factura.png'])
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/img/factura.png') }}">
    <script src="https://kit.fontawesome.com/9f312215fd.js" crossorigin="anonymous"></script>
    <script src="/main.js"></script>
    <script src="{{Vite::asset('resources/js/numeroLetras.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @yield('content')
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('customJS')
</body>
</html>
