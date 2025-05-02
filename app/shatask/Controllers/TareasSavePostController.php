<?php

namespace App\Shatask\Controllers;

use App\Shatask\Models\Tarea;
use App\Shatask\Repositories\TareaRepository;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Services\LanguageService;
use App\Shared\Validation\Validator;
use App\Shatask\Services\Tarea\ProcessTarea;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Respect\Validation\Validator as v;

final class TareasSavePostController extends PostController
{
    public function __construct(protected ContainerInterface $container, protected Validator $validator, protected Flash $flash, protected TareaRepository $tareaRepository) 
    {
        parent::__construct($container, $validator, $flash);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try{
            $data = $request->getParsedBody();

            if (!empty($data['id'])) {
                $task = $this->tareaRepository->find($data['id']);
            } else {
                $task = new Tarea($this->container);
            }

            $task->lista_id = $data['lista_id'] ?? $task->lista_id;
            $task->titulo = $data['titulo'] ?? $task->titulo;
            $task->descripcion = $data['descripcion'] ?? $task->descripcion;
            $task->estado = $data['estado'] ?? $task->estado;

            $taskId = $this->tareaRepository->save($task);
            $task->ID = $taskId;

            $this->container->get(ProcessTarea::class)->process($data);
            $this->flash->addMessage('success', $this->container->get(LanguageService::class)->getText('Lista guardada con exito'));
        } catch (\Exception $e) {
            $this->flash->addMessage('error', $e->getMessage());
        }
        return RouteHelpers::redirect($request, $response, 'shatask.tareas.get.list', ['lista_id' => $task->lista_id]);    }
}