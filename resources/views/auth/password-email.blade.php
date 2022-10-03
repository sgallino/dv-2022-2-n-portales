@extends('layouts.main')

@section('title', 'Iniciar Sesión')

@section('main')
    <h1>Recuperar Password</h1>

    <p>¿Olvidaste tu password? No te preocupes, solo completá el form con tu email y se te enviará un correo con las instrucciones para recuperar la cuenta.</p>

    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
            >
        </div>
        <button type="submit" class="btn btn-primary w-100">Enviar Email de Recuperación</button>
    </form>
@endsection

