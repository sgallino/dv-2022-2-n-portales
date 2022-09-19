<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\Models\Pelicula;
use Illuminate\Http\Request;

class AdminPeliculasController extends Controller
{
    public function index()
    {
        // Obtenemos todas las películas de la tabla a través del modelo Pelicula.
//        $peliculas = Pelicula::all();
        /*
         |--------------------------------------------------------------------------
         | Cargando datos con relaciones
         |--------------------------------------------------------------------------
         | El método "all()" solo sirve si queremos traer _todo_ lo que la tabla
         | tiene, o sea todos sus registros, sin ningún tipo de agregado, como puede
         | ser las relaciones.
         |
         | Para poder agregar otras características, entonces nosotros primero vamos
         | definiendo las cosas que queremos sumar en consideración para la ejecución
         | de la consulta, y finalmente, ejecutamos el método "get()" para correr el
         | query.
         |
         | Por ejemplo, si queremos agregar relaciones al query, podemos hacerlo con
         | el método "with()".
         | Este método recibe un string o array de strings, que contengan los nombres
         | de las relaciones. Esto sería el nombre del método.
         */
        $peliculas = Pelicula::with(['pais'])->get();

        // dd() (dump and die) es un helper de Laravel que imprime todo lo que tiene la variable que le
        // pasemos.
//        dd($peliculas);

        // Ahora necesitamos pasarle esa variable a la vista.
        // Esto lo hacemos con el segundo parámetro de la función "view()", que recibe un array asociativo,
        // donde las claves van a ser los nombres de las variables que la vista va a tener.
        return view('admin/peliculas/index', [
            'peliculas' => $peliculas,
//            'peliculas' => Pelicula::all(),
        ]);
    }

    // El parámetro "$id" sale del parámetro de la ruta "{id}".
    public function ver(int $id)
    {
        // Obtenemos la película correspondiente a este id.
        // Para esto, Laravel nos da el método find().
        // Ese método retorna una instancia de la clase de Eloquent con los datos del registro cuya PK
        // sea el valor provisto como argumento. Si no existe, retorna null.
//        $pelicula = Pelicula::find($id);
        // Si queremos que cuando un registro no exista, en vez de retornar null se lance una Exception,
        // podemos usar el método "findOrFail".
        // Este lanza una ModelNotFoundException, que Laravel, por defecto, captura y muestra un 404.
        $pelicula = Pelicula::findOrFail($id);

        return view('admin.peliculas.ver', [
            'pelicula' => $pelicula,
        ]);
    }

    public function nuevaForm()
    {
//        $paises = Pais::all();
        // Ordenamos los paises por su nombre. TODO: Agregar el índice adecuado en la migration.
        $paises = Pais::orderBy('nombre')->get();

        // Noten que en la función "view" podemos reemplazar las "/" de la ruta con ".".
        return view('admin.peliculas.nueva-form', [
            'paises' => $paises,
        ]);
    }

    public function nuevaGrabar(Request $request)
    {
        // Vamos finalmente a grabar.
        // El primer paso, obviamente, es obtener los datos del form.
        // Típicamente, esto lo hacíamos usando las súperglobales de php como $_POST.
        // Eso generalmente se desaconseja. Se recomienda evitar usar directamente esas variables, y en
        // su lugar, usar un intermediario que lidie con esa variable, sin que nadie más lo que haga.
        // ¿Por qué?
        // Por lo pronto, por 2 razones:
        // 1. Las súperglobales, como su nombre indica, son globales. Como toda variable global, suelen ser
        //  casi siempre un problema. Esto es problemático porque es una fuente de bugs enorme, sin mencionar
        //  que el código que usa variables globales es muy difícil de testear.
        // 2. $_POST solo levanta los datos que vengan con formato de form (campo=valor&campo2=valor2...),
        //  en el cuerpo de la petición y que estén el header correspondiente a un form. Esto ignora otras
        //  posibles y comunes formas de pasar datos, como formato JSON.
        // Los intermediarios, como la clase Request que Laravel nos provee, se encargan de obtener la data
        // según el formato de la petición.
        // La clase Request, entonces, contiene múltiples métodos para obtener información de la petición del
        // usuario.
        // Para tener acceso a la instancia con los datos de Request, debemos "inyectarla" como parámetro en
        // el método del Controller.

        // Pedimos todos los datos del formulario.
        // input() retorna todos los datos del formulario.
//        $data = $request->input();
        // Si solo queremos algunos, podemos pedirlos con el método only().
//        $data = $request->only(['titulo', 'precio', 'fecha_estreno']);

        // Si queremos todos, salvo alguno que otro, podemos excluir datos usando el método except().
        $data = $request->except(['_token']);

        // Validación
        // Laravel busca simplificarnos lo más posible el bajón de hacer las validaciones.
        // La clase Request tiene un método llamado "validate()", el cual recibe un array de las "reglas"
        // de validación.
        // Si las reglas pasan, retorna los valores que pasaron las reglas, y el programa continúa su curso.
        // Si uno o más campo fallan, entonces graba los valores actuales del form en una variable de sesión
        // "flash", graba los mensajes de error en otra, y redirecciona al usuario a la pantalla de la que
        // vino. Siempre y cuando sea una petición por HTTP común.
        // Los datos enviados por la sesión son luego levantados automágicamente por Laravel (ver vista).
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        /*
         |--------------------------------------------------------------------------
         | Upload de imagen
         |--------------------------------------------------------------------------
         | https://laravel.com/docs/9.x/requests#files
         */
        if($request->hasFile('portada')) {
            $portada = $request->file('portada');
            // Generamos un nombre para la imagen.
            // Por ejemplo, la fecha actual, seguida de "_", seguida del título de la película transformado
            // a un "slug" para la URL.
            // Para hacer el slug, usamos el método Str::slug().
            // Finalmente, le agregamos la extensión.
            $nombrePortada = date('YmdHis') . "_" . \Str::slug($data['titulo']) . "." . $portada->extension();

            // Movemos la portada a su ubicación final.
            // Para indicar el directorio, podemos ayudarnos con la función public_path() que genera la URL
            // absoluta a la carpeta public.
            // Forma 1: Moviendo el archivo a una ubicación indicada por nosotros.
//            $portada->move(public_path('imgs'), $nombrePortada);

            // Forma 2: Usando la API de Storage/Filesystem de Laravel.
            $portada->storeAs('imgs', $nombrePortada, 'public');

            $data['portada'] = $nombrePortada;
        }


        // Usamos el método "static" Pelicula::create para grabar la data que le pasamos como parámetro.
        // Retorna la instancia de película creada y grabada en la base.
        $pelicula = Pelicula::create($data);

        // Redireccionamos al listado.
        return redirect()
            ->route('admin.peliculas.listado')
            // Muchas veces vamos a querer mostrar mensajes de "feedback" al usuario luego de una acción
            // y su redireccionamiento.
            // Para esto, Laravel tiene el método "with()" de Redirect, que permite agregar variables
            // de sesión tipo "flash".
            ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue creada exitosamente.')
            ->with('status.type', 'success');
    }

    public function editarForm(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        return view('admin.peliculas.editar-form', [
            'pelicula' => $pelicula,
        ]);
    }

    public function editarEjecutar(Request $request, int $id)
    {
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        $pelicula = Pelicula::findOrFail($id);

        $data = $request->except(['_token']);

        if($request->hasFile('portada')) {
            $portada = $request->file('portada');
            $nombrePortada = date('YmdHis') . "_" . \Str::slug($data['titulo']) . "." . $portada->extension();

            // Forma 1: Moviendo el archivo a una ubicación indicada por nosotros.
//            $portada->move(public_path('imgs'), $nombrePortada);

            // Forma 2: Usando la API de Storage/Filesystem de Laravel.
            $portada->storeAs('imgs', $nombrePortada, 'public');

            $data['portada'] = $nombrePortada;
            // Guardamos la portada vieja para poder eliminar luego del update...
            $portadaVieja = $pelicula->portada;
        }

        $pelicula->update($data);

        // Borramos la portada vieja.
        if($portadaVieja ?? false) {
//            unlink(public_path('imgs/' . $portadaVieja));
            \Storage::disk('public')->delete('imgs/' . $portadaVieja);
        }

        return redirect()
            ->route('admin.peliculas.listado')
            ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue editada exitosamente.')
            ->with('status.type', 'success');
    }

    public function eliminarConfirmar(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        return view('admin.peliculas.eliminar', [
            'pelicula' => $pelicula,
        ]);
    }

    public function eliminarEjecutar(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);
        $portadaVieja = $pelicula->portada;

        $pelicula->delete();

        // Borramos la portada vieja.
        if($portadaVieja ?? false) {
//            unlink(public_path('imgs/' . $portadaVieja));
            \Storage::disk('public')->delete('imgs/' . $portadaVieja);
        }

        return redirect()
            ->route('admin.peliculas.listado')
            ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue eliminada exitosamente.')
            ->with('status.type', 'success');
    }
}
