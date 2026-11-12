<?php
declare(strict_types=1);

namespace Models;

class JuegoModel
{
    private string $rutaJson;
    private string $rutaUploads;

    // Recibimos las rutas desde el controlador.
    public function __construct(
        string $rutaJson,
        string $rutaUploads
    ) {
        $this->rutaJson = $rutaJson;
        $this->rutaUploads = $rutaUploads;
    }

    // lee todos los juegos guardados.
    public function todos(): array
    {
        if (!file_exists($this->rutaJson)) {
            return [];
        }

        $json = file_get_contents($this->rutaJson);

        if ($json === false || trim($json) === '') {
            return [];
        }

        $juegos = json_decode($json, true);

        return is_array($juegos) ? $juegos : [];
    }

    // guarda el ZIP y sus datos en el JSON.
    public function guardar(array $datos, string $rutaTemporal): void
    {
        // creamos la carpeta de subidas si no existe.
        if (!is_dir($this->rutaUploads)) {
            mkdir($this->rutaUploads, 0755, true);
        }

        // generamos un nombre único para el ZIP.
        $nombreArchivo = bin2hex(random_bytes(16)) . '.zip';

        $destino = $this->rutaUploads . '/' . $nombreArchivo;

        // movemos el ZIP a la carpeta definitiva.
        if (!move_uploaded_file($rutaTemporal, $destino)) {
            throw new \RuntimeException('No se pudo guardar el archivo ZIP.');
        }

        // leemos los juegos que ya existen.
        $juegos = $this->todos();

        // preparamos los datos del nuevo juego.
        $nuevoJuego = [
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'autor' => $datos['autor'],
            'categoria' => $datos['categoria'],
            'archivo' => 'uploads/juegos/' . $nombreArchivo,
            'nombre_original' => $datos['nombre_original']
        ];

        $juegos[] = $nuevoJuego;

        // convertimos la lista a JSON.
        $json = json_encode(
            $juegos,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        if ($json === false) {
            throw new \RuntimeException('No se pudo convertir el JSON.');
        }

        // guardamos todos los juegos.
        $carpeta = dirname($this->rutaJson);

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }

        file_put_contents($this->rutaJson, $json, LOCK_EX);
    }
}
