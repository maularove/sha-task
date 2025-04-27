<?php

namespace App\Shatask\Middlewares;


use App\Shatask\Services\AuthService;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Middlewares\BaseMiddleware;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Views\Twig;

final class AuthMiddleware extends BaseMiddleware
{
    public function __construct(ContainerInterface $container, Twig $twig, private readonly AuthService $authService)
    {
        parent::__construct($container, $twig);
    }

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        if (!$this->authService->check()) {
            $response = new Response();

            return RouteHelpers::redirect($request, $response, 'shatask.login.get');
        }

        return $handler->handle($request);
    }
}