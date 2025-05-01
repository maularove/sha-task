<?php

namespace App\Shatask\Controllers\Auth;

use App\Shatask\Services\AuthService;
use App\Shared\Helpers\RouteHelpers;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Shared\Controllers\FrontController;

final class LogoutPostController
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        session_unset();
    session_destroy();

        $this->authService->logout();
        return RouteHelpers::redirect($request, $response, 'shatask.login.get');
    }
}