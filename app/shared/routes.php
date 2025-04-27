<?php

use App\Shared\Helpers\RouteHelpers;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
/*
 * SHARED APP ROUTES
 */
return function (App $app): void {
    $app->group('/', function (RouteCollectorProxy $group): void {
        $group->get('', fn(ServerRequestInterface $request, ResponseInterface $response) => RouteHelpers::redirect($request, $response, 'shatask.login.get'));
    });
};