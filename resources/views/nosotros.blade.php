<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DV Películas</title>

    <link rel="stylesheet" href="<?= url('css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?= url('css/estilos.css');?>">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <?php
                // La función url() permite generar una URL absoluta a partir de la carpeta [public] de
                // Laravel, con el string que le pasamos por parámetro.
                ?>
                <a class="navbar-brand" href="<?= url('/');?>">DV Películas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Abrir/cerrar menú de navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('/');?>">Home</a>
                            <!-- <a class="nav-link active" aria-current="page" href="#">Home</a> -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('nosotros');?>">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('admin/peliculas');?>">Administrar Película</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <section class="container py-4">
                <h1>Nosotros</h1>
            </section>
        </main>

        <footer class="footer">
            <p>Da Vinci &copy; 2022</p>
        </footer>
    </div>
</body>
</html>
