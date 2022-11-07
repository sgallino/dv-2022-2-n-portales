<?php

namespace Tests\Unit;

use App\Cart\CarritoItem;
use App\Models\Pelicula;
use PHPUnit\Framework\TestCase;

/*
 * Las clases de tests deben, por convención, llevar el sufijo "Test".
 *
 * De la misma forma, cada uno de los tests que realice la clase van a estar organizados en un método por
 * test.
 * Y esos métodos llevan como prefijo "test".
 *
 * En Laravel, por convención, los nombres de los métodos de los tests se escriben con "snake_case", y no
 * "camelCase".
 *
 * Y en general, siempre en testing, solemos priorizar poner nombres bien descriptivos de lo que se está
 * testeando, sin importar si quedan muy largos.
 */
class CarritoItemTest extends TestCase
{
    /*
     * Como primer test, vamos a testear que podamos crear una instancia de CarritoItem, y que solo requiera
     * una instancia de Pelicula en el constructor.
     */
    public function test_puedo_instanciar_un_carritoitem_con_solo_una_pelicula_y_la_contenga()
    {
        // Anatomía de un test:
        // 1. Definición de valores y configuración de entorno.
        // 2. Ejecución del método que queremos testear.
        // 3. Verificación de las expectativas ("assertions").

        // 1.
        $id = 1;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;

        // 2.
        $ci = new \App\Cart\CarritoItem($pelicula);

        // 3.
        // Verificamos que $ci sea una instancia de la clase CarritoItem.
        $this->assertInstanceOf(\App\Cart\CarritoItem::class, $ci);
        // Verificamos que esté el id $id en getProducto().
        // assertEquals verifica que dos valores sean equivalentes. Similar a la comparación con "==".
//        $this->assertEquals($id, $ci->getProducto()->pelicula_id);
        // Verificamos que el producto que tiene el $ci sea la misma película que le pasamos en el
        // constructor.
        // assertEquals, cuando usamos objetos, hace una comparación de las propiedades del objeto, además
        // de la clase a la que pertenece.
        // No nos sirve para este chequeo.
//        $this->assertEquals($pelicula, $ci->getProducto());
        // assertSame hace una comparación por tipo y valor (similar al "==="). En el caso de objetos, hace
        // también la comparación "normal" de php con "===", que implica una comparación por referencia.
        $this->assertSame($pelicula, $ci->getProducto());
    }

    public function test_puedo_instanciar_un_carritoitem_con_una_pelicula_y_una_cantidad()
    {
        // 1.
        $id = 1;
        $cantidad = 5;
        $cantidad2 = 7;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;

        // 2.
        $ci = new CarritoItem($pelicula, $cantidad);
        $ci2 = new CarritoItem($pelicula, $cantidad2);

        // 3.
        $this->assertEquals($cantidad, $ci->getCantidad());
        $this->assertEquals($cantidad2, $ci2->getCantidad());
    }

    public function test_puedo_modificar_la_cantidad_de_un_carritoitem()
    {
        $cantidad = 8;
        $cantidad2 = 3;
        $id = 1;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $ci = new CarritoItem($pelicula);

        $ci->setCantidad($cantidad);
        $this->assertEquals($cantidad, $ci->getCantidad());

        $ci->setCantidad($cantidad2);
        $this->assertEquals($cantidad2, $ci->getCantidad());
    }

    public function test_puedo_obtener_el_subtotal_de_un_carritoitem()
    {
        $subtotal = 3198;

        $id = 1;
        $precio = 1599;
        $cantidad = 2;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $pelicula->precio = $precio;
        $ci = new CarritoItem($pelicula, $cantidad);

        $this->assertEquals($subtotal, $ci->getSubtotal());
    }

    // TODO: Pasar a dataset :)
    public function test_puedo_obtener_el_subtotal_de_un_carritoitem_v2()
    {
        $subtotal = 8796;

        $id = 1;
        $precio = 2199;
        $cantidad = 4;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $pelicula->precio = $precio;
        $ci = new CarritoItem($pelicula, $cantidad);

        $this->assertEquals($subtotal, $ci->getSubtotal());
    }
}
