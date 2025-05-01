<?php

namespace App\Shatask\Controllers;

use App\Shared\Controllers\FrontController;
use App\Shatask\Models\Lista;
use App\Shatask\Repositories\ListaRepository;
use App\Shatask\Repositories\TareaRepository;
use App\Shatask\Services\AuthService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;

final class TareasGetController extends FrontController
{
    private AuthService $authService;
    private TareaRepository $tareaRepository;

    private ListaRepository $listaRepository;

    public function __construct(
        ContainerInterface $container,
        Twig $twig,
        Flash $flash,
        AuthService $authService,
        TareaRepository $tareaRepository,
        ListaRepository $listaRepository
    ) {
        parent::__construct($container, $twig, $flash);
        $this->authService = $authService;
        $this->tareaRepository = $tareaRepository;
        $this->listaRepository = $listaRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $listaId = $args['lista_id'] ?? $request->getQueryParams()['lista_id'] ?? null;
        $tasks = $this->tareaRepository->findByListId((int)$listaId);

        $list = $this->listaRepository->find($listaId);

        return $this->twig->render($response, '@shatask/tareas/tareas_list.twig', [
            'tasks' => $tasks,
            'list'=> $list
        ]);
    }
}