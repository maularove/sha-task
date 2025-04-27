<?php

namespace App\Shatask\Controllers\Auth;

use App\Shatask\Services\AuthService;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Services\LanguageService;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages as Flash;

final class LoginPostController extends PostController
{
    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash, private readonly AuthService $authService, private readonly LanguageService $languageService)
    {
        parent::__construct($container, $validator, $flash);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $validation = $this->validator->validate($request, [
            'username' => v::noWhitespace()->notEmpty(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            $this->flash->addMessage('error', $this->languageService->getText('Error de validación de datos.'));
            return RouteHelpers::redirect($request, $response, 'shatask.login.get');
        }

        $signIn = $this->authService->signIn(
            $request->getParsedBody()['username'],
            $request->getParsedBody()['password']
        );

        if (!$signIn) {
            $this->flash->addMessage('error', $this->languageService->getText('Credenciales incorrectas.'));
            return RouteHelpers::redirect($request, $response, 'shatask.login.get');
        }

        // Iniciamos sesión para páginas fuera de slim (public\adminrrhh\inc\inc-login.php) -- Temporal hasta finalizar refactorización
        $_SESSION['username'] = $request->getParsedBody()['username'];
        $_SESSION['passwordmd5'] = strtolower(MD5(strtolower((string) $request->getParsedBody()['password']) . "DFHsrhgu4hxrihjx5r8DH658ur"));

        return RouteHelpers::redirect($request, $response, 'shatask.listas.get.list');
    }
}
