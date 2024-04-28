<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('storeForm') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="Nombre"><br>
        <input type="email" name="email" placeholder="Correo electrónico"><br>
        <textarea name="message" placeholder="Mensaje"></textarea><br>
        <button type="submit">Enviar</button>
    </form>    
</body>
</html>