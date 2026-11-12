<?php
declare(strict_types=1);
// Controlador y acción que se ejecutan cuando la URL no indica ninguno
const CONTROLLER_DEFAULT = 'home';
const ACTION_DEFAULT = 'index';

//Direccion base del proyecto para el navegador
define('DEFINE_URL', '/miproyecto/');
define('RUTA_VIEWS',__DIR__ .'/Views/');
define('RUTA_JUGADORES',__DIR__ .'/data/jugadores.json');
define('RUTA_JUEGOS',__DIR__ .'/data/juegos.json');
define('RUTA_UPLOADS',__DIR__ .'/public/upload/juegos');
define('MAX_ZIP', 10 * 1024 * 1024 );
define('CATEGORIAS',['Aventura', 'Estrategia', 'Puzzle','Arcade']);