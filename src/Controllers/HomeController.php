<?php
declare(strict_types=1);
namespace Controllers;
//Juegocontroller

use Lib\Pages;
use Models\JugadorModel;
use Models\JuegoModel;
class HomeController
{
    private Pages $pagina;

    public function __construct()
    {
        $this->pagina = new Pages();
    }

    /** Muestra el formulario */
    public function index(): void
    {
        $usuario=$_GET['bienvenido'] ?? null;
        $jugador=new JugadorModel();
        $juego=new JuegoModel();
        $totalJugador=$jugador->total();
        $totalJuego=$juego->total();
        $this->pagina->render('home/formulario',['totalJugador'=>$totalJugador,
                                                    'totalJuego'=>$totalJuego,
                                                    'usuario' => $usuario]);
    }


    /** Redirige a una acción del controlador de usuario */
    private function redirigir(string $accion): void 
    {
        header('Location: index.php?controller=usuario&action=' . $accion);
        //redirigimos a la accion o funcion que tenemos en el controlador
        //UsuarioController y la funcion/accion sera el parametro que le pasamos
        //ejemplo login() que renderiza nuestra vista de login
        exit;
        //las cabezeras obligatoriamente tiene que tener exi; si no
        //el programa no sale de la accion
    }
}