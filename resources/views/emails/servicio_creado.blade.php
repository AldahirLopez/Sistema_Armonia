<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Servicio Anexo 30</title>
</head>

<body>
    <h1>¡Hola!</h1>
    <p>Se ha creado un nuevo servicio con la nomenclatura: <strong>{{ $servicio->nomenclatura }}</strong></p>
    <p>Este servicio fue creado por: <strong>{{ $servicio->usuario->name }}</strong></p>
    <p>Este servicio está pendiente de aprobación.</p>
    <a href="{{ url('/servicios-pendientes') }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; display: inline-block;">
        Ver Servicio Pendiente
    </a>
    <p>Por favor, revisa el servicio para proceder con la aprobación.</p>
    <p>Saludos,</p>
    <p>Armonía y Contraste Ambiental</p>
    
    <!-- Ajusta la ruta de la imagen aquí -->
    <img src="{{ asset('build/images/logoarmonia.png') }}" alt="Logo de Armonía y Contraste Ambiental" width="150">
</body>

</html>
