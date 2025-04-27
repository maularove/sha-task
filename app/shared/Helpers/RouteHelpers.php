<?php

namespace App\Shared\Helpers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class RouteHelpers
{
    public static function redirect(ServerRequestInterface $request, ResponseInterface $response, string $url, array $data = [], array $queryParams = []): ResponseInterface
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor($url, $data, $queryParams);

        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }

    public static function redirectToUrl(ResponseInterface $response, string $url): ResponseInterface
    {
        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }
}
