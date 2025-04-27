<?php

namespace App\Shared\Middlewares;

use Nyholm\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Flash\Messages as FlashMessage;

class FlashMessageMiddleware
{
    /**
     * Flash Message Middleware.
     *
     * @param ServerRequest $request PSR-7 request
     * @param RequestHandler $handler PSR-15 request handler
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        // Start PHP session
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_name($_ENV['SESSION_NAME']);
            session_start();
        }

        // Change flash message storage
        $this->flashMessage->__construct($_SESSION);

        return $handler->handle($request);
    }

    public function __construct(private readonly FlashMessage $flashMessage)
    {
    }
}
