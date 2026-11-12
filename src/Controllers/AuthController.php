<?php
declare(strict_types=1);
namespace Controllers;
//AuthController
use Models\JugadorModel;
use Lib\Pages;
use Request\FormRegistroRequest;
class AuthController{

    private Pages $pagina;

     public function __construct()
    {
        $this->pagina = new Pages();
    }

    /** Metodo registro */
    public function registro(){
        $modelo = new JugadorModel(RUTA_JUGADORES);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $this->pagina->render('usuario/registro',[
                'errores'=> $request->errpres(),
                'datos'=>[] $request->datos(),
            ]);
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $request= new FormRegistroRequest($_POST['usuario']);
            if($request->esValido()){
                if( $modelo->existeEmail($request->email())){
                    $request->agregarError('usuario', 'ya existe ese email');
                }
                if($modelo->existeUsername($request->username()) ){
                    $request->agregarError('usuario', 'ya existe ese usuario');
                }
                $this->pagina->render('usuario/registro',[
                    'errores'=> [],
                    'datos'=>[],
                ]);
            }
            $modelo->crear('datosUsuariio');
        }
    }
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




?>