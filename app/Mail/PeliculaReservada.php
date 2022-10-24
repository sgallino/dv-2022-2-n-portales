<?php

namespace App\Mail;

use App\Models\Pelicula;
use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeliculaReservada extends Mailable
{
    use Queueable, SerializesModels;

    /*
     * En muchos casos, pasa esto de tener un constructor que pida datos que se van a cargar en propiedades
     * de la clase.
     * Lo cual es bastante reiterativo:
     * - Definimos las propiedades.
     * - Definimos el constructor, que reciba como parámetro los valores para las propiedades, típicamente
     *  llamados igual que las propiedades.
     * - Asignamos esas variables, típicamente llamadas igual que las propiedades, a las propiedades.
     *
     * A partir de php 8+, tenemos lo que se llama "propiedades promovidas"
     * https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion
     *
     * Esto nos permite declarar las propiedades como parámetros del método constructor, sin necesidad de
     * declararlos antes, ni de asignarlos.
     */
    public function __construct(public Pelicula $pelicula, public Usuario $usuario)
    {}

//    public Pelicula $pelicula;
//    public Usuario $usuario;
//
//    /**
//     * Create a new message instance.
//     *
//     * @return void
//     */
//    public function __construct(Pelicula $pelicula, Usuario $usuario)
//    {
//        $this->pelicula = $pelicula;
//        $this->usuario = $usuario;
//    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        return $this
            ->from('no-responder@dv-peliculas.com.ar', 'DV Películas')
            ->subject('Confirmación de Reserva de Película')
            ->view('mails.pelicula-reservada');
    }
}
