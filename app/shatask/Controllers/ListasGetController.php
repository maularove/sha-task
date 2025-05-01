<?php

namespace App\Shatask\Controllers;

use App\Shared\Controllers\FrontController;
use App\Shatask\Repositories\ListaRepository;
use App\Shatask\Services\AuthService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;

final class ListasGetController extends FrontController
{
    private AuthService $authService;
    private ListaRepository $listaRepository;

    public function __construct(
        ContainerInterface $container,
        Twig $twig,
        Flash $flash,
        AuthService $authService,
        ListaRepository $listaRepository
    ) {
        parent::__construct($container, $twig, $flash);
        $this->authService = $authService;
        $this->listaRepository = $listaRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Obtener el usuario autenticado
        $usuario = $this->authService->getUsuario();

        if (!$usuario) {
            // Redirigir al login si no hay usuario autenticado
            return $response->withHeader('Location', '/shatask/login')->withStatus(302);
        }

        // Obtener las listas del usuario
        $listas = $this->listaRepository->findByUserId($usuario->ID);

        // Renderizar la vista con las listas y el usuario
        return $this->twig->render($response, '@shatask/listas/listas_list.twig', [
            'lists' => $listas,
            'users' => [$usuario], // Pasar el usuario como un array para mantener compatibilidad con la vista
        ]);
    }
}