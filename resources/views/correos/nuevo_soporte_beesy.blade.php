<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mensajes Bee</title>

    <style>
        .contenedor{
            min-height: 100vh;
            /* background-color: red; */
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .contenedor .tamano{
            /* display: flex;
            flex-direction: column; */
            /* justify-content: center; */
            /* align-items: center; */
            /* min-width: 500px; */
            padding: 2rem;
            margin: 0 auto;
            border: 2px solid goldenrod;
            border-radius: .5rem;
            /* text-align: center; */
            /* background-color: green; */
        }
        .contenedor .tamano .img{
            width: 200px;
            margin: 0 auto
            /* border: 1px solid red; */
        }
        .contenedor .tamano .contenido{
            font-size: 1.3rem;
        }
        .contenedor .tamano .contenido h4{
            text-align: center;
            font-weight: bold;
            letter-spacing: 1px;
            margin-top: unset
        }
        .contenedor .tamano .contenido p{
            font-size: 1.2rem;
        }
        .contenedor .tamano .contenido p span{
            font-weight: bold;
        }
        .contenedor .tamano .contenedorlink{
            max-width: 100%;
            margin: 0 auto;
        }
        .contenedor .tamano .contenedorlink .link{
            text-decoration: none;
            display: block;
            background-color: #F39200;
            /* color: black */
            font-weight: bold;
            margin: 0 auto;
            padding: .7rem 1rem;
            border-radius: .5rem;
            width: 110px;
        }
    </style>
</head>
<body>

    <div class="contenedor">

        <div class="tamano">

            <div class="img">
                <img style="max-width: 100%" src="https://beesys.net/wp-content/uploads/2022/09/logo.png" alt="logo beesy"/>
            </div>

            <div class="contenido">
                <h4 class="">Soporte Solicitado</h4>

                <p class=""><span>Descripción del Soporte:</span></p>
                <p class=""><span>Ticket:</span> {{$dato['ticket']}}</p>
                <p class=""><span>Empresa:</span> {{$dato['empresa']}}</p>
                <p class=""><span>Contacto:</span> {{$dato['contacto']}}</p>
                <p class=""><span>Colaborador:</span> {{$dato['colaborador']}}</p>
                <p class=""><span>Creación del ticket:</span> {{$dato['creacion_ticket']}}</p>
                <p class=""><span>Problema:</span> {{$dato['problema']}}</p>

                @if ($dato['prioridad'] == 'Leve')
                    <p class=""><span>Prioridad:</span> <span style="color: green; font-weight: bolder">{{$dato['prioridad']}}</span></p>
                @elseif ($dato['prioridad'] == 'Moderado')
                    <p class=""><span>Prioridad:</span> <span style="color: rgb(19, 58, 156); font-weight: bolder">{{$dato['prioridad']}}</span></p>
                @else
                    <p class=""><span>Prioridad:</span> <span style="color: red; font-weight: bolder">{{$dato['prioridad']}}</span></p>
                @endif

                <p class=""><span>Estado:</span> {{$dato['estado']}}</p>
                {{-- <p class=""><span>Solución:</span> {{$dato['solucion']}}</p> --}}
                <p class=""><span>Observaciones:</span> {{$dato['observaciones']}}</p>

                @if ($dato['prioridad'] == 'Leve')
                    <p style="font-size: .7rem">Nota:: Les recuerdo que siempre debemos brindar soporte a nuestros clientes,<br>
                                                incluso en casos de baja complejidad. Si reciben una solicitud de soporte<br>
                                                de nivel leve, les pido que atiendan el problema de manera oportuna y con la<br>
                                                calidad de servicio que nos caracteriza. Agradezco su compromiso con nuestros clientes.</p>
                @elseif ($dato['prioridad'] == 'Moderado')
                    <p style="font-size: .7rem">Nota:: Les pido que se enfoquen en resolver este problema lo antes posible,<br>
                                                y que lo hagan con atención al detalle y asegurándose de que el cliente esté<br>
                                                satisfecho con la solución. Recuerden que nuestro compromiso con los clientes es <br>
                                                fundamental para mantener su confianza en nosotros</p>
                @else
                    <p style="color: red;font-size: .7rem">Nota:: Tenemos un caso de soporte de nivel alto que ha sido <br>
                                                             reportado por un cliente. Les pido que den prioridad a este caso <br>
                                                             y trabajen en equipo para resolverlo con la mayor eficiencia posible.</p>
                @endif
            </div>

            <div class="contenedorlink">
                <a href="{{ url('http://127.0.0.1:8000/soportes') }}" class="link" style="color: black">Realizar soporte</a>
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>
</html>
