<?php

namespace App\Shatask\Controllers;

use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Services\LanguageService;
use App\Shared\Validation\Validator;
use App\Shatask\Repositories\TareaRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;

final class TareasDeletePostController extends PostController
{
    public function __construct(protected ContainerInterface $container, protected Validator $validator, protected Flash $flash, protected TareaRepository $tareaRepository) 
    {
        parent::__construct($container, $validator, $flash);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
     $id = $request->getParsedBody()['id'];
     $task = $this->tareaRepository->find($id);

        $this->tareaRepository->delete($task);
        $this->flash->addMessage('success', $this->container->get(LanguageService::class)->getText('Tarea eliminada correctamente'));
        return RouteHelpers::redirect($request, $response, 'shatask.tareas.get.list', ['lista_id' => $task->lista_id]);    
    } 
}