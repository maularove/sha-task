<?php

namespace App\Shatask\Controllers;

use App\Shared\Controllers\FrontController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListasGetController extends FrontController
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->twig->render($response, '@shatask/listas/listas_list.twig');
    }
}
