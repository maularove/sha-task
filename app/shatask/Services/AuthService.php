<?php

namespace App\Shatask\Services;


use App\Shatask\Repositories\UsuarioRepository;
use App\Shared\Services\LanguageService;
use App\Shatask\Models\Usuario;
use Slim\Flash\Messages as Flash;

final class AuthService
{
    private ?Usuario  $usuario;
    public function __construct(private readonly usuarioRepository $usuarioRepository, private readonly Flash $flash, private readonly LanguageService $languageService)
    {
        $this->usuario = $this->getUsuario();
    }

    public function getUsuario(): ?Usuario
    {
        if (isset($_SESSION['usuarios'])) {
            if (isset($this->usuario) && $this->usuario->id == $_SESSION['usuario']) {
                return $this->usuario;
            }
            if (!isset($this->usuario) || $this->usuario->id != $_SESSION['usuario']) {
                $this->usuarioRepository = $this->usuario->find($_SESSION['usuario']);

                return $this->usuario;
            }
        }
        return null;
    }

    public function check(): bool
    {
        return isset($this->usuario) ? true : false;
    }

    public function signIn($usuario, $password): bool
    {
        $usuario = $this->usuarioRepository->findWhere('WHERE usuario = :usuario ', [
            ':usuario' => [
                'value' => $usuario,
                'type' => \PDO::PARAM_STR,
            ],
        ]);

        if (!$usuario) {
            $this->flash->addMessage('error', $this->languageService->getText('¡Error de acceso! - El usuario introducido no se encuentra en el sistema.'));

            return false;
        }

        if ($this->passwordCheck($password, $usuario->password)) {
            $_SESSION['usuario'] = $usuario->id;
            return true;
        }

        $this->flash->addMessage('error', $this->languageService->getText('¡Error de acceso! - El password introducido no es correcto.'));

        return false;
    }

    private function passwordCheck(string $password, string $password_db): bool
    {
        //TODO encriptar

        return $password == $password_db;
    }

    public function logout(): void
    {
        unset($_SESSION['usuario']);
    }
}
