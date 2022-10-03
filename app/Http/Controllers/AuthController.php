<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth/login');
    }

    public function loginEjecutar(Request $request)
    {
        // TODO: validar...

        // Definimos las credenciales para la autenticación.
        // Debe tener al menos 2 valores: 1 para el campo "password" (debe llamarse así), y otro que sirva
        // para identificar al usuario.
        $credenciales = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // Tratamos de autenticar al usuario.
        if(Auth::attempt($credenciales)) {
            // Regeneramos, como recomienda php, el id de sesión del usuario.
            $request->session()->regenerate();

            return redirect()
                ->route('admin.peliculas.listado')
                ->with('status.message', 'Sesión iniciada correctamente. ¡Bienvenido/a de vuelta!')
                ->with('status.type', 'success');
        }

        return redirect()
            ->route('auth.login.form')
            ->with('status.message', 'Las credenciales ingresadas no coinciden con nuestros registros.')
            ->with('status.type', 'danger')
            // withInput() agrega que se recuerden los valores del form en la petición, para que podamos
            // luego accederlos desde la función (olc()).
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Bajo recomendación de Laravel, invalidamos la sesión y regeneramos el token de CSRF.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login.form')
            ->with('status.message', 'La sesión se cerró correctamente. ¡Te esperamos de vuelta!')
            ->with('status.type', 'success');
    }
}
