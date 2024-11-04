<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>| MVP Facturador</title>
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/numeroLetras.js'])
    <link rel="shortcut icon" href="{{ Vite::asset('resources/img/factura.png') }}" type="image/x-icon">
    <script src="https://kit.fontawesome.com/9f312215fd.js" crossorigin="anonymous"></script>
    <script src="/main.js"></script>
    <script src="{{Vite::asset('resources/js/numeroLetras.js')}}"></script>

</head>
<body>
    @include('layouts.navigation')
    @yield('content')
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('customJS')
</body>
</html>
