<?php
declare(strict_types=1);

namespace Models;

class JugadorModel
{
    private string $rutaJson;

    // recibimos la ruta desde config.php a través del controlador.
    public function __construct(string $rutaJson)
    {
        $this->rutaJson = $rutaJson;
    }

    // lee todos los jugadores del JSON.
    public function todos(): array
    {
        if (!file_exists($this->rutaJson)) {
            return [];
        }

        $json = file_get_contents($this->rutaJson);

        if ($json === false || trim($json) === '') {
            return [];
        }

        $jugadores = json_decode($json, true);

        return is_array($jugadores) ? $jugadores : [];
    }

    // comprueba si existe un nombre de usuario sin distinguir mayúsculas.
    public function existeUsername(string $username): bool
    {
        foreach ($this->todos() as $jugador) {
            if (
                mb_strtolower($jugador['username']) ===
                mb_strtolower($username)
            ) {
                return true;
            }
        }

        return false;
    }

    // comprueba si existe un correo sin distinguir mayúsculas.
    public function existeEmail(string $email): bool
    {
        foreach ($this->todos() as $jugador) {
            if (
                mb_strtolower($jugador['email']) ===
                mb_strtolower($email)
            ) {
                return true;
            }
        }

        return false;
    }

    // registra un jugador guardando su contraseña cifrada.
    public function crear(
        string $username,
        string $email,
        string $password
    ): void {
        // creamos la carpeta data si todavía no existe.
        $carpeta = dirname($this->rutaJson);

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }

        $jugadores = $this->todos();

        $nuevoJugador = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $jugadores[] = $nuevoJugador;

        $json = json_encode(
            $jugadores,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        if ($json === false) {
            throw new \RuntimeException('No se pudo convertir el JSON.');
        }

        file_put_contents($this->rutaJson, $json, LOCK_EX);
    }

    // comprueba el correo y la contraseña al iniciar sesión.
    public function verificarCredenciales(
        string $email,
        string $password
    ): ?array {
        foreach ($this->todos() as $jugador) {
            if (
                mb_strtolower($jugador['email']) ===
                mb_strtolower($email)
            ) {
                if (password_verify($password, $jugador['password'])) {
                    // No devolvemos la contraseña ni su hash.
                    unset($jugador['password']);
                    return $jugador;
                }
                return null;
            }
        }
        return null;
    }
}
