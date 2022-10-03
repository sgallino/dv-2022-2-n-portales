{{--
Este archivo funciona como nuestro template de base.

La idea de un template de layout es servir de base a otros templates. Similar nuestro [index.php] en el
cuatri pasado en Programación II.
Pero a diferencia de ese archivo, que se encargaba de incluir los otros templates, acá es al revés.
Van a ser los propios templates los que digan qué layout de base quieren usar.
Esto nos da una mucha mayor flexibilidad.

Para lograr eso, lo que debemos hacer en el template de layout es definir qué espacio vamos a "cederles"
a los templates que "hereden" de éste.
Esto se logra con la directiva @yield('nombre')
--}}
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') :: DV Películas</title>

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/estilos.css') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <?php
                // La función url() permite generar una URL absoluta a partir de la carpeta [public] de
                // Laravel, con el string que le pasamos por parámetro.
                ?>
                <a class="navbar-brand" href="{{ route('home') }}">DV Películas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Abrir/cerrar menú de navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                            <!-- <a class="nav-link active" aria-current="page" href="#">Home</a> -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('nosotros') }}">Nosotros</a>
                        </li>
                        {{--
                        El método Auth::check() retorna true si el usuario está autenticado, false de lo
                        contrario.
                        Asimismo, tenemos un método Auth::guest() que funciona al revés: retorna true
                        si no está autenticado, y false si lo está.
                        --}}
{{--                        @if(Auth::check())--}}
                        {{--
                        Alternativametne, podemos usar la directiva de Blade @auth
                        --}}
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.peliculas.listado') }}">Ir al Panel</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('auth.logout') }}" method="post">
                                @csrf
                                <button type="submit" class="btn nav-link">Cerrar Sesión</button>
                            </form>
                        </li>
                        @elseguest
{{--                        @else--}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login.form') }}">Iniciar Sesión</a>
                        </li>
                        @endauth
{{--                        @endif--}}
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <section class="container py-4">
                {{-- Agregamos, si se nos pide, el mensaje de estado.
                Session es la clase de Laravel para interactuar con los valores de sesión. --}}
                @if(Session::has('status.message'))
                    <div class="alert alert-{{ Session::get('status.type') ?? 'info' }}">{!! Session::get('status.message') !!}</div>
                @endif
                @yield('main')
            </section>
        </main>

        <footer class="footer">
            <p>Da Vinci &copy; 2022</p>
        </footer>
    </div>
</body>
</html>
