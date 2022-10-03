<?php
/** @var string $token */
?>

@extends('layouts.main')

@section('title', 'Iniciar Sesión')

@section('main')
    <h1>Restablecer Password</h1>

    <p>Escribí el nueva password que querés poner a tu cuenta.</p>

    <form action="{{ route('password.update') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nuevo Password</label>
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Nuevo Password</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control"
            >
        </div>
        <button type="submit" class="btn btn-primary w-100">Restablecer Password</button>
    </form>
@endsection

