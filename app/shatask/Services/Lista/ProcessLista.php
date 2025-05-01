<?php

namespace App\Shatask\Services\Lista;

use App\Shatask\Models\lista;
use App\Shatask\Repositories\ListaRepository;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;

class ProcessLista
{

    public function __construct(protected ContainerInterface $container, protected Validator $validator, protected ListaRepository $listaRepo) {}

    public function process(array $data): Lista
    {
        if (!empty($data['id'])) {
            $list = $this->listaRepo->find($data['id']);
        } else {
            $list = new Lista();
        }
    
        $session = $_SESSION ?? [];
        $userId = $session['usuario'] ?? null;
        $list->user_id = $userId;
        $list->nombre = $data['nombre'] ?? '';
    
        return $list;
    }
}
