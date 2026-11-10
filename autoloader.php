<?php
/**
 * Registra una función de autocarga.
 * Esta función se llamará automáticamente cada vez que se intente
 * usar una clase que aún no haya sido cargada.
 */
spl_autoload_register(function (string $clase): void {
       // Reemplaza las barras invertidas del namespace (\) por barras de directorio (/)
    $archivo = __DIR__ . '/src/'
        . str_replace('\\', '/', $clase)
        . '.php';

    if (is_file($archivo)) {    // Comprueba si el archivo PHP para esa clase existe
        require_once $archivo;
    }
});
