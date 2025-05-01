<?php

namespace App\Shatask\Services\Tarea;

use App\Shatask\Models\Tarea;
use App\Shatask\Repositories\TareaRepository;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;

class ProcessTarea
{

    public function __construct(protected ContainerInterface $container, protected Validator $validator, protected TareaRepository $tareaRepo) {}

    public function process(array $data): Tarea
    {
        if (!empty($data['id'])) {
            $task = $this->tareaRepo->find($data['id']);
        } else {
            $task = new Tarea();
        }
    
        // $session = $_SESSION ?? [];
        // $userId = $session['usuario'] ?? null;
        // $task->user_id = $userId;
        $task->lista_id = $data['lista_id'] ?? '';
        $task->titulo = $data['titulo'] ?? '';
        $task->descripcion = $data['descripcion'] ?? '';
        $task->estado = $data['estado'] ?? 0;
    
        return $task;
    }
}
