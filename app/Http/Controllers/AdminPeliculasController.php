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
        return view('admin/peliculas/index', [
            'peliculas' => $peliculas,
//            'peliculas' => Pelicula::all(),
        ]);
    }

    public function nuevaForm()
    {
        // Noten que en la función "view" podemos reemplazar las "/" de la ruta con ".".
        return view('admin.peliculas.nueva-form');
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

//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";

        // TODO: Subir la portada...

        // Validación
        // Laravel busca simplificarnos lo más posible el bajón de hacer las validaciones.
        // La clase Request tiene un método llamado "validate()", el cual recibe un array de las "reglas"
        // de validación.
        // Si las reglas pasan, retorna los valores que pasaron las reglas, y el programa continúa su curso.
        // Si uno o más campo fallan, entonces graba los valores actuales del form en una variable de sesión
        // "flash", graba los mensajes de error en otra, y redirecciona al usuario a la pantalla de la que
        // vino. Siempre y cuando sea una petición por HTTP común.
        // Los datos enviados por la sesión son luego levantados automágicamente por Laravel (ver vista).
        $request->validate([
//            'titulo' => ['required', 'min:2'],
            'titulo' => 'required|min:2',
            'precio' => 'required|numeric|min:0',
            'fecha_estreno' => 'required',
        ], [
            'titulo.required' => 'El título no puede quedar vacío.',
            'titulo.min' => 'El título debe tener al menos :min caracteres.',
            'precio.required' => 'El precio no puede quedar vacío.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio debe ser positivo.',
            'fecha_estreno.required' => 'La fecha de estreno no puede quedar vacía.',
        ]);

        // Usamos el método "static" Pelicula::create para grabar la data que le pasamos como parámetro.
        // Retorna la instancia de película creada y grabada en la base.
        Pelicula::create($data);

        // Redireccionamos al listado.
        return redirect()->route('admin.peliculas.listado');
    }
}
