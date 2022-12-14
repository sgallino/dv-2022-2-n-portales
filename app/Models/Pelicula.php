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
    // modelo en min??sculas y en plural (de ingl??s).
    // Si queremos especificar el nombre de la tabla, solo tenemos que setear el valor en la propiedad
    // $table.
    protected $table = 'peliculas';

    // Por defecto, Laravel supone que la PK se llama "id".
    // Si no es el caso, se lo indicamos con la propiedad $primaryKey.
    protected $primaryKey = 'pelicula_id';

    // $fillable es un array que debe contener todos los nombres de los campos que queremos permita en
    // los m??todos de create y update para la "asignaci??n masiva" (mass assignment).
    protected $fillable = ['pais_id', 'clasificacion_id', 'titulo', 'precio', 'fecha_estreno', 'descripcion', 'portada', 'portada_descripcion'];

    public const VALIDATE_RULES = [
//            'titulo' => ['required', 'min:2'],
        'titulo' => 'required|min:2',
        'precio' => 'required|numeric|min:0',
        'pais_id' => 'required|numeric|exists:paises',
        'fecha_estreno' => 'required',
    ];

    public const VALIDATE_MESSAGES = [
        'titulo.required' => 'El t??tulo no puede quedar vac??o.',
        'titulo.min' => 'El t??tulo debe tener al menos :min caracteres.',
        'precio.required' => 'El precio no puede quedar vac??o.',
        'precio.numeric' => 'El precio debe ser un n??mero.',
        'precio.min' => 'El precio debe ser positivo.',
        'fecha_estreno.required' => 'La fecha de estreno no puede quedar vac??a.',
    ];

    /*
     |--------------------------------------------------------------------------
     | Accessors & Mutators
     |--------------------------------------------------------------------------
     | Los accessors y mutators nos permite modificar valores de atributos al
     | momento de leerlo o asignarlos, respectivamente.
     | Ambos se definen con un m??todo protected que debe llamarse igual que el
     | campo pero en sintaxis camelCase.
     | Debe indicar en el retorno de la funci??n que va a retornar una instancia
     | de la clase Attribute de Eloquent.
     */
    protected function precio(): Attribute
    {
        // Retornamos el m??todo "make()" de Attribute.
        // Este m??todo recibe hasta 2 argumentos:
        // 1. Closure. Funci??n que recibe el valor actual del atributo y debe
        //  retornar el valor modificado que se desea.
        // 2. Closure. Funci??n que recibe el valor que se pide asignar al modelo
        //  y debe retornar el valor modificado que se desea asignar.
//        return Attribute::make(
//            function($value) {
//                return $value / 100;
//            },
//            function($value) {
//                return $value * 100;
//            }
//        );

        // Este c??digo de arriba funciona, pero no es como Laravel nos recomienda usarlo, probablemente
        // porque sienta que tiene 2 problemas, o al menos, 2 cosas que se pueden mejorar:
        // 1. La claridad en el c??digo. Por ejemplo, cu??l es el m??todo que asigna y cu??l el que lee.
        // 2. La legibilidad del c??digo. Las funciones an??nimas son un poco "verbosas" cuando lo ??nico
        //  que se quiere es modificar un valor y retornarlo. Nada m??s.
        // Para mejorar cada uno de esos casos, Laravel usa nuevas (relativamente) funcionalidades de php:
        // a. Named Arguments (php 8+)
        // b. Arrow Functions (php 7.4+)
        /*
         * # Named Arguments
         * Por defecto, los argumentos en una llamada a una funci??n se asignan a los par??metros de la
         * funci??n en el orden en que est??n definidos.
         * Los named arguments, en cambio, nos permiten asociar cada argumento al par??metro que queremos
         * asignarlo usando el nombre del par??metro (el nombre de la variable sin el "$").
         * Su sintaxis es muy simple, solamente escribimos el nombre del par??metro, seguido de un ":", antes
         * del valor del argumento que queremos pasarle.
         * Importante: En cada llamada de una funci??n, puede usarse named arguments _o_ los argumentos
         * "comunes" (posicionales).
         *
         * # Arrow Functions
         * Las arrow function en php tienen una sintaxis similar a las de JS, pero tienen algunos
         * comportamientos particulares a php.
         * Sintaxis:
         *  fn (par??metros) => expresi??nDeRetorno
         * Cosas a tener en cuenta:
         * 1. Las arrow function no pueden tener cuerpo. No podemos hacer m??ltiples operaciones dentro. Solo
         *  pueden retornar una expresi??n.
         * 2. No definen, por lo tanto, un scope propio de variables. Y eso permite que tengan acceso a
         *  todas las variables del scope de la funci??n que las contiene sin necesidad de indicarlo
         *  expl??citamente con el use ().
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
     | Para definir una relaci??n, tenemos que crear un m??todo para ella.
     | Cada relaci??n va a tener su propio m??todo.
     | El nombre del m??todo, Laravel lo va a usar como nombre de la propiedad en
     | los objetos para acceder al modelo relacionado.
     | (ver [views/admin/peliculas/index.php]).
     | El tipo de relaci??n va a estar definido por el retorno de la funci??n.
     */
    public function pais()
    {
        // belongsTo() define una relaci??n de 1:n para la tabla referenciante (la que lleva la FK).
        // Recibe 3 par??metros que nos interesan:
        // 1. String. El FQN del modelo de Eloquent asociado.
        // 2. Opcional. String. El nombre de la FK.
        // 3. Opcional. String. El nombre de la PK referenciada.
        return $this->belongsTo(Pais::class, 'pais_id', 'pais_id');
    }

    public function generos()
    {
        // belongsToMany() define una relaci??n de n:m.
        // Recibe los siguientes par??metros:
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
