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

    public function process(ServerRequestInterface $request): Lista
    {
        $data = $request->getParsedBody();
        if(!empty($data['id'])) {
            $lista = $this->listaRepo->find($data['id']);
        } else {
            $lista = new Lista();
        }
        
        $lista->lista = $data['nombre'] ?? '';
        $lista->lista = $data['user_id'] ?? 'null';
        $lista->lista = $data['descripcion'] ?? '';

        return $lista;
    }
}
