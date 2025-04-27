<?php

namespace App\Shared\Middlewares;

use Nyholm\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class RedirectRefererMiddleware extends BaseMiddleware
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
        $this->twig->getEnvironment()->addGlobal('redirect_url', null);

        if (isset($_SERVER['HTTP_REFERER'])) {
            $parseUrlReferer = parse_url((string)$_SERVER['HTTP_REFERER']);
            $parseUrlHost = parse_url((string)$_SERVER['HTTP_HOST']);

            if ($parseUrlReferer && $parseUrlHost && isset($parseUrlReferer['host']) && ((isset($parseUrlHost['host']) && $parseUrlReferer['host'] === $parseUrlHost['host']) || $parseUrlReferer['host'] === $parseUrlHost['path']) && !empty($parseUrlReferer['path'])) {
                $this->twig->getEnvironment()->addGlobal('redirect_url', $parseUrlReferer['path']);
            }
        }

        return $handler->handle($request);
    }
}
