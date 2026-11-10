<?php
declare(strict_types=1);

namespace Controllers;

/**
 * Controlador frontal: único punto de entrada de la aplicación.
 *
 * Lee ?controller=...&action=... de la URL, comprueba que existen
 * y llama a la acción. Si no es válido, muestra un error 404.
 *
 * Requiere las constantes CONTROLLER_DEFAULT y ACTION_DEFAULT (config/config.php).
 */
class FrontController
{
    public static function main(): void
    {
        // Controlador y acción: los de la URL o los predeterminados
        $controller_name = $_GET['controller'] ?? CONTROLLER_DEFAULT;
        $action_name = $_GET['action'] ?? ACTION_DEFAULT;


        // Construimos el nombre completo de la clase: baraja -> Controllers\BarajaController
        $nombre_controlador = 'Controllers\\' . ucfirst($controller_name) . 'Controller';

        // El controlador debe existir y no pueden invocarse el frontal ni el de errores
        if (
            !class_exists($nombre_controlador)
            || in_array($nombre_controlador, [self::class, ErrorController::class], true)
        ) {
            ErrorController::show_error404();
            return;
        }

        $controlador = new $nombre_controlador();

        // is_callable comprueba si ese método está en la clase y
        // además comprueba si quien pregunta puede llamarlo
        //respeta la visibilidad: los métodos privados no cuentan
        if (is_callable([$controlador, $action_name])) {
            $controlador->$action_name();
        } else {
            ErrorController::show_error404();
        }
    }

}