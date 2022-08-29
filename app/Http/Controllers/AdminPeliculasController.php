<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class AdminPeliculasController extends Controller
{
    public function index()
    {
        // Obtenemos todas las películas de la tabla a través del modelo Pelicula.
        $peliculas = Pelicula::all();

        // dd() (dump and die) es un helper de Laravel que imprime todo lo que tiene la variable que le
        // pasemos.
//        dd($peliculas);

        // Ahora necesitamos pasarle esa variable a la vista.
        // Esto lo hacemos con el segundo parámetro de la función "view()", que recibe un array asociativo,
        // donde las claves van a ser los nombres de las variables que la vista va a tener.
        return view('admin-peliculas', [
            'peliculas' => $peliculas,
//            'peliculas' => Pelicula::all(),
        ]);
    }
}
