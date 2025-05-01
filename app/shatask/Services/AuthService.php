<?php

namespace App\Shatask\Services;

use App\Shatask\Repositories\UsuarioRepository;
use App\Shared\Services\LanguageService;
use App\Shatask\Models\Usuario;
use Slim\Flash\Messages as Flash;

final class AuthService
{
    private ?Usuario $usuario;

    public function __construct(
        private readonly UsuarioRepository $usuarioRepository, // Corregido: Tipo y nombre coinciden
        private readonly Flash $flash,
        private readonly LanguageService $languageService
    ) {
        $this->usuario = $this->getUsuario();
    }

    public function getUsuario(): ?Usuario
    {
        if (isset($_SESSION['usuario'])) {
            if (isset($this->usuario) && $this->usuario->ID == $_SESSION['usuario']) {
                return $this->usuario;
            }
            if (!isset($this->usuario) || $this->usuario->ID != $_SESSION['usuario']) {
                $this->usuario = $this->usuarioRepository->find($_SESSION['usuario']);
                return $this->usuario;
            }
        }
        return null;
    }

    public function check(): bool
    {
        return isset($this->usuario);
    }

    public function signIn(string $usuario, string $password): bool
    {
        $usuario = $this->usuarioRepository->findWhere('WHERE usuario = :usuario', [
            ':usuario' => [
                'value' => $usuario,
                'type' => \PDO::PARAM_STR,
            ],
        ]);

        if (!$usuario) {
            $this->flash->addMessage(
                'error',
                $this->languageService->getText('¡Error de acceso! - El usuario introducido no se encuentra en el sistema.')
            );
            return false;
        }

        if ($this->passwordCheck($password, $usuario->password)) {
            $_SESSION['usuario'] = $usuario->ID;
            return true;
        }

        $this->flash->addMessage(
            'error',
            $this->languageService->getText('¡Error de acceso! - El password introducido no es correcto.')
        );
        return false;
    }

    private function passwordCheck(string $password, string $password_db): bool
    {
        return $password === $password_db;
    }

    public function logout(): void
    {
        unset($_SESSION['usuario']);
        unset($_SESSION['passwordmd5']);
    }
}