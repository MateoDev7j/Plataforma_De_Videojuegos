<?php
declare(strict_types=1);

namespace Controllers;

use Lib\Pages;


class ErrorController{
    public static function show_error404(int $codigo=404):void{
        http_response_code($codigo);
        $datos = [
            'titulo' => 'Error ' . $codigo,
            'mensaje' => 'La página que buscas no existe.'
        ];
        (new Pages())->render('error/error404', $datos);
    }
}