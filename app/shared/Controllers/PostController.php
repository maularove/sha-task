<?php

namespace App\Shared\Controllers;

use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;

class PostController
{
    public function __construct(protected ContainerInterface $container, protected Validator $validator, protected Flash $flash)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $response;
    }

    protected function getRequestParsedBody(ServerRequestInterface $request): array
    {
        if (!$request->getParsedBody()) {
            return [];
        }

        return (array)$request->getParsedBody();
    }
    protected function getRequestUploadFiles(ServerRequestInterface $request): array
    {
        if (!$request->getUploadedFiles()) {
            return [];
        }

        return (array)$request->getUploadedFiles();
    }
}
