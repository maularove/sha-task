<?php

namespace App\Shatask\Controllers\Auth;

use App\Shatask\Services\AuthService;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Controllers\FrontController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;

final class LoginGetController extends FrontController
{
    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, private readonly AuthService $authService) 
    {
        parent::__construct($container, $twig, $flash);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if ($this->authService->check()) {
            return RouteHelpers::redirect($request, $response, 'shatask.listas.get.list');
        }

        return $this->twig->render($response, '@shatask/login.twig');
    }
}
