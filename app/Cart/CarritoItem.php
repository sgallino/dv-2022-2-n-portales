<?php

namespace App\Cart;

use App\Models\Pelicula;

class CarritoItem
{
//    private Pelicula $producto;
//
//    public function __construct(Pelicula $producto)
//    {
//        $this->producto = $producto;
//    }
    public function __construct(
        private Pelicula $producto,
        private int $cantidad = 1
    )
    {}

    public function getProducto(): Pelicula
    {
        return $this->producto;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getSubtotal(): int
    {
        return $this->cantidad * $this->producto->precio;
    }
}
