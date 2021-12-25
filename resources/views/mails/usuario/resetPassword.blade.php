<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <title>Mensaje Recibido</title>
</head>

<body>
<H3>Hola {{$msg['apellido']}}, {{$msg['nombre']}}</H3>
<h4>Tus nuevas credenciales son:</h4>
<ul>
    <li>
        <strong>DNI:</strong>
        {{ $msg['dni'] }}
    </li>
    <li>
        <strong>Password:</strong>
        {{ $msg['clave'] }}
    </li>
</ul>
</body>

</html>
