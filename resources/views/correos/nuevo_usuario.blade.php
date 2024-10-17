<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo usuario</title>

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
                <h4 class="">Bienvenido</h4>
                
                <p class="">
                    Actualmente usted dispone de una cuenta en el sistema BeesyAdmin,
                    sus credenciales son:
                </p> <br>

                <p class=""><span>Email:</span> {{$dato['email']}}</p>
                <p class=""><span>Password:</span> 12345678 (Usted puede cambiar su contraseña en el sistema)</p>
            </div>
            
            <div class="contenedorlink">
                <a href="{{ url('http://127.0.0.1:8000/login') }}" class="link" style="color: black">Visitar el sitio</a>
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>
</html>