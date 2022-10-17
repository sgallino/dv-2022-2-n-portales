<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConfirmarEdadController extends Controller
{
    public function confirmarForm(int $id)
    {
        return view('confirmar-edad', [
            'pelicula' => Pelicula::findOrFail($id),
        ]);
    }

    public function confirmarEjecutar(int $id)
    {
        Session::put('mayorDeEdad', true);

        return redirect()
            ->route('admin.peliculas.ver', ['id' => $id]);
    }
}
