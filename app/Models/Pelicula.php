<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property string $titulo
 * @property int $precio
 * @property string $fecha_estreno
 * @property string $descripcion
 * @property string|null $portada
 * @property string|null $portada_descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereFechaEstreno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePeliculaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePortada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePortadaDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    // $fillable es un array que debe contener todos los nombres de los campos que queremos permita en
    // los métodos de create y update para la "asignación masiva" (mass assignment).
    protected $fillable = ['titulo', 'precio', 'fecha_estreno', 'descripcion', 'portada', 'portada_descripcion'];
}
