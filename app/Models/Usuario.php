<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Heredamos de la clase User que trae el framework en su módulo de Auth.
class Usuario extends User
{
//    use HasFactory;
    // Agregamos algunos traits que Laravel puede utilizar.
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';

    protected $fillable = ['email', 'password'];

    // Le decimos a Laravel qué campos queremos que se ignoren a la hora de "serializar" el modelo.
    // "Serialización" es una técnica que consiste en transformar una estructura de datos (ej: objeto)
    // en un string, formateado de manera tal que pueda revertirse el proceso. Es decir, que poedamos
    // recrear el objeto original a partir del string.
    // Esto es esencial si usamos Laravel como una API, para que al retornar en el JSON de la respuesta
    // no se agreguen estos campos.
    protected $hidden = ['password', 'remember_token'];
}
