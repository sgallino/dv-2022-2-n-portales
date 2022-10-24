<?php
/** @var \App\Models\Pelicula $pelicula */
/** @var \App\Models\Usuario $usuario */
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Película Reservada</title>
</head>
<body>
    <h1>Confirmación de Reserva de Película</h1>

    <p>¡Hola {{ $usuario->email }}!</p>
    <p>Te escribimos para avisarte que tu reserva de la película <b>{{ $pelicula->titulo }}</b> se realizó correctamente.</p>

    <p>Blah blah blah, iquirish-maquirish.</p>

    <p>
        Atentamente,<br>
        tus amigos de DV Películas.
    </p>
</body>
</html>
