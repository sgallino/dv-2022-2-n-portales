<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function home()
    {
        // Retornamos el contenido de la vista "welcome", con ayuda de la función helper "view()".
        // La función "view()" busca un archivo de extensión ".php" o ".blade.php" con el nombre y ruta que
        // le pasamos en la carpeta [resources/views].
        return view('welcome');
    }
}
