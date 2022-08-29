<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Pelicula[] $peliculas */
?>
@extends('layouts.admin')

@section('title', 'Administración de Películas')

@section('main')
<h1>Administrar de Películas</h1>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Precio</th>
        <th>Fecha de Estreno</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach($peliculas as $pelicula)
    <tr>
        <td>{{ $pelicula->pelicula_id }}</td>
        <td>{{ $pelicula->titulo }}</td>
        <td>$ {{ $pelicula->precio }}</td>
        <td>{{ $pelicula->fecha_estreno }}</td>
        <td>Coming soon &trade;</td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection
