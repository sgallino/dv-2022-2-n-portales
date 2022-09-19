<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property int $pais_id
 * @property string $titulo
 * @property int $precio
 * @property string $fecha_estreno
 * @property string $descripcion
 * @property string|null $portada
 * @property string|null $portada_descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pais $pais
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
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePaisId($value)
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
    protected $fillable = ['pais_id', 'titulo', 'precio', 'fecha_estreno', 'descripcion', 'portada', 'portada_descripcion'];

    public const VALIDATE_RULES = [
//            'titulo' => ['required', 'min:2'],
        'titulo' => 'required|min:2',
        'precio' => 'required|numeric|min:0',
        'pais_id' => 'required|numeric|exists:paises',
        'fecha_estreno' => 'required',
    ];

    public const VALIDATE_MESSAGES = [
        'titulo.required' => 'El título no puede quedar vacío.',
        'titulo.min' => 'El título debe tener al menos :min caracteres.',
        'precio.required' => 'El precio no puede quedar vacío.',
        'precio.numeric' => 'El precio debe ser un número.',
        'precio.min' => 'El precio debe ser positivo.',
        'fecha_estreno.required' => 'La fecha de estreno no puede quedar vacía.',
    ];

    /*
     |--------------------------------------------------------------------------
     | Relaciones
     |--------------------------------------------------------------------------
     | Para definir una relación, tenemos que crear un método para ella.
     | Cada relación va a tener su propio método.
     | El nombre del método, Laravel lo va a usar como nombre de la propiedad en
     | los objetos para acceder al modelo relacionado.
     | (ver [views/admin/peliculas/index.php]).
     | El tipo de relación va a estar definido por el retorno de la función.
     */
    public function pais()
    {
        // belongsTo() define una relación de 1:n para la tabla referenciante (la que lleva la FK).
        // Recibe 3 parámetros que nos interesan:
        // 1. String. El FQN del modelo de Eloquent asociado.
        // 2. Opcional. String. El nombre de la FK.
        // 3. Opcional. String. El nombre de la PK referenciada.
        return $this->belongsTo(Pais::class, 'pais_id', 'pais_id');
    }
}
