<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property int $pais_id
 * @property int $clasificacion_id
 * @property string $titulo
 * @property int $precio
 * @property string $fecha_estreno
 * @property string $descripcion
 * @property string|null $portada
 * @property string|null $portada_descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pais $pais
 * @property-read \App\Models\Clasificacion $clasificacion
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genero[] $generos
 * @property-read int|null $generos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePaisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereClasificacionId($value)
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
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Pelicula onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Pelicula withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Pelicula withoutTrashed()
 */
class Pelicula extends Model
{
//    use HasFactory;
    use SoftDeletes;

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
    protected $fillable = ['pais_id', 'clasificacion_id', 'titulo', 'precio', 'fecha_estreno', 'descripcion', 'portada', 'portada_descripcion'];

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
     | Accessors & Mutators
     |--------------------------------------------------------------------------
     | Los accessors y mutators nos permite modificar valores de atributos al
     | momento de leerlo o asignarlos, respectivamente.
     | Ambos se definen con un método protected que debe llamarse igual que el
     | campo pero en sintaxis camelCase.
     | Debe indicar en el retorno de la función que va a retornar una instancia
     | de la clase Attribute de Eloquent.
     */
    protected function precio(): Attribute
    {
        // Retornamos el método "make()" de Attribute.
        // Este método recibe hasta 2 argumentos:
        // 1. Closure. Función que recibe el valor actual del atributo y debe
        //  retornar el valor modificado que se desea.
        // 2. Closure. Función que recibe el valor que se pide asignar al modelo
        //  y debe retornar el valor modificado que se desea asignar.
//        return Attribute::make(
//            function($value) {
//                return $value / 100;
//            },
//            function($value) {
//                return $value * 100;
//            }
//        );

        // Este código de arriba funciona, pero no es como Laravel nos recomienda usarlo, probablemente
        // porque sienta que tiene 2 problemas, o al menos, 2 cosas que se pueden mejorar:
        // 1. La claridad en el código. Por ejemplo, cuál es el método que asigna y cuál el que lee.
        // 2. La legibilidad del código. Las funciones anónimas son un poco "verbosas" cuando lo único
        //  que se quiere es modificar un valor y retornarlo. Nada más.
        // Para mejorar cada uno de esos casos, Laravel usa nuevas (relativamente) funcionalidades de php:
        // a. Named Arguments (php 8+)
        // b. Arrow Functions (php 7.4+)
        /*
         * # Named Arguments
         * Por defecto, los argumentos en una llamada a una función se asignan a los parámetros de la
         * función en el orden en que están definidos.
         * Los named arguments, en cambio, nos permiten asociar cada argumento al parámetro que queremos
         * asignarlo usando el nombre del parámetro (el nombre de la variable sin el "$").
         * Su sintaxis es muy simple, solamente escribimos el nombre del parámetro, seguido de un ":", antes
         * del valor del argumento que queremos pasarle.
         * Importante: En cada llamada de una función, puede usarse named arguments _o_ los argumentos
         * "comunes" (posicionales).
         *
         * # Arrow Functions
         * Las arrow function en php tienen una sintaxis similar a las de JS, pero tienen algunos
         * comportamientos particulares a php.
         * Sintaxis:
         *  fn (parámetros) => expresiónDeRetorno
         * Cosas a tener en cuenta:
         * 1. Las arrow function no pueden tener cuerpo. No podemos hacer múltiples operaciones dentro. Solo
         *  pueden retornar una expresión.
         * 2. No definen, por lo tanto, un scope propio de variables. Y eso permite que tengan acceso a
         *  todas las variables del scope de la función que las contiene sin necesidad de indicarlo
         *  explícitamente con el use ().
         */
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

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

    public function generos()
    {
        // belongsToMany() define una relación de n:m.
        // Recibe los siguientes parámetros:
        // 1. String. El FQN del modelo de Eloquent asociado.
        // 2. Opcional. String. El nombre de la tabla pivot.
        // 3. Opcional. String. El nombre de la FK en la tabla pivot que referencia a la PK de esta tabla
        //  ("foreignPivotKey").
        // 4. Opcional. String. El nombre de la FK en la tabla pivot que referencia a la PK de la otra
        //  tabla ("relatedPivotKey").
        // 5. Opcional. String. El nombre de la PK de esta tabla ("parentKey").
        // 6. Opcional. String. El nombre de la PK de la otra tabla ("relatedKey").
        return $this->belongsToMany(
            Genero::class,
            'peliculas_tienen_generos',
            'pelicula_id',
            'genero_id',
            'pelicula_id',
            'genero_id',
        );
    }

    public function clasificacion()
    {
        return $this->belongsTo(
            Clasificacion::class,
            'clasificacion_id',
            'clasificacion_id',
        );
    }
}
