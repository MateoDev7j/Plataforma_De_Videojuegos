<?php
declare(strict_types=1);
//AuthController
use Models\JugadorModel;
use Lib\Pages;
class AuthController{

    private Pages $pagina;

     public function __construct()
    {
        $this->pagina = new Pages();
    }
}