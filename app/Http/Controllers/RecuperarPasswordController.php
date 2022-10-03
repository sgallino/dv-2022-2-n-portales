<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Mockery\Generator\StringManipulation\Pass\Pass;

class RecuperarPasswordController extends Controller
{
    public function emailRecuperarForm()
    {
        return view('auth.password-email');
    }

    public function emailRecuperarEnviar(Request $request)
    {
        // TODO: Validar...
        // TODO: Implementar mailtrap para probar el restablecer password :)

        // Enviamos el email de recuperación.
        $email = $request->input('email');
        $status = Password::sendResetLink(['email' => $email]);

        $route = redirect()->route('password.request');

        return $status === Password::RESET_LINK_SENT
            ? $route
                ->with('status.message', 'Se envió un email con instrucciones a <b>' . $email . '</b>. No te olvides de revisar, por si acaso, "spam" o "correo no deseado".')
                ->with('status.type', 'success')
            : $route
                ->with('status.message', 'Ocurrió un error inesperado, el email no pudo ser enviado.')
                ->with('status.type', 'danger');
    }

    public function restablecerPasswordForm(string $token)
    {
        return view('auth.password-restablecer', [
            'token' => $token
        ]);
    }

    public function restablecerPasswordEjecutar(Request $request)
    {
        // TODO: Validar...

        $credenciales = $request->only(['token', 'password', 'password_confirmation', 'email']);
        $status = Password::reset($credenciales, function($user, $password) {
            /** @var Usuario $user */
            // Guardamos el password del usuario.
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            // Lo actualizamos.
            $user->save();

            // Emitimos el evento de la actualización del password.
            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()
                ->route('auth.login.form')
                ->with('status.message', 'Tu password se restableció correctamente. Ya podés iniciar sesión.')
                ->with('status.type', 'success')
            : redirect()
                ->route('password.reset')
                ->withInput()
                ->with('status.message', 'Ocurrió un error al tratar de restablecer el password.')
                ->with('status.type', 'danger');
    }
}
