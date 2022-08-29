<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
//    use HasFactory;

    // Por defecto, Laravel supone que el nombre de la tabla asociada a este modelo, es el nombre del
    // modelo en minúsculas y en plural (de inglés).
    // Si queremos especificar el nombre de la tabla, solo tenemos que setear el valor en la propiedad
    // $table.
    protected $table = 'peliculas';

    // Por defecto, Laravel supone que la PK se llama "id".
    // Si no es el caso, se lo indicamos con la propiedad $primaryKey.
    protected $primaryKey = 'pelicula_id';
}
