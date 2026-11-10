<?php
//archivo de arranque
declare(strict_types=1);

//DEFINIMOS CONSTANTE BASE_PATH
define('BASE_PATH', dirname(__DIR__));

//CARGAMOS TODO
require BASE_PATH . '/autoloader.php';
require BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/src/Lib/helpers.php';

//USAMOS CONTROLADOR FRONTCONTROLLER
use Controllers\FrontController;
FrontController::main();
?>