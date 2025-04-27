<?php

namespace App\Shared\Middlewares;

use Psr\Container\ContainerInterface;
use Slim\Views\Twig;

class BaseMiddleware
{
    public function __construct(protected ContainerInterface $container, protected Twig $twig)
    {
    }
}
