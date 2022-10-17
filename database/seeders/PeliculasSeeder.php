<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeliculasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Para interactuar con los datos de la base, tenemos la fachada de Laravel "DB".
        // Esa clase permite acceder a la implementación de "Query Builder" de Laravel.
        // Un Query Builder es una clase que permite armar consultas SQL a través de métodos de objetos.
        // Además, en el caso de Laravel, es también agnóstico del sistema de base de datos que usemos,
        // Laravel automágicamente va a armar los queries que sean adecuados al sistema de base de datos
        // que usemos (dentro de los que soporta).
        DB::table('peliculas')->insert([
            [
                'pelicula_id' => 1,
                'pais_id' => 1,
                'clasificacion_id' => 1,
                'titulo' => 'El Señor de los Anillos: La Comunidad del Anillo',
                'precio' => 1999,
                'fecha_estreno' => '1999-01-05',
                'descripcion' => 'Throw it into the Fire, Mr. Frodo!',
                'portada' => null,
                'portada_descripcion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 2,
                'pais_id' => 2,
                'clasificacion_id' => 2,
                'titulo' => 'El Discurso del Rey',
                'precio' => 1799,
                'fecha_estreno' => '2016-10-25',
                'descripcion' => 'I have a voice!',
                'portada' => null,
                'portada_descripcion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 3,
                'pais_id' => 1,
                'clasificacion_id' => 4,
                'titulo' => 'La Matrix',
                'precio' => 2099,
                'fecha_estreno' => '1998-07-13',
                'descripcion' => 'I know kung fu.',
                'portada' => null,
                'portada_descripcion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
