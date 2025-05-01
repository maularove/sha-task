<?php

namespace App\Shatask\Controllers;

use App\Shatask\Models\Lista;
use App\Shatask\Repositories\ListaRepository;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Services\LanguageService;
use App\Shared\Validation\Validator;
use App\Shatask\Services\Lista\ProcessLista;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Respect\Validation\Validator as v;

final class ListasSavePostController extends PostController
{
    public function __construct(protected ContainerInterface $container, protected Validator $validator, protected Flash $flash, protected ListaRepository $listaRepository) 
    {
        parent::__construct($container, $validator, $flash);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try{
            $data = $request->getParsedBody();

            if (!empty($data['id'])) {
                $list = $this->listaRepository->find($data['id']);
            } else {
                $list = new Lista($this->container);
            }

            $list->nombre = $data['nombre'] ?? $list->nombre;
            $session = $_SESSION ?? [];
            $userId = $session['usuario'] ?? null;
            $list->user_id = $userId;

            $listId = $this->listaRepository->save($list);
            $list->ID = $listId;

            $this->container->get(ProcessLista::class)->process($data);
            $this->flash->addMessage('success', $this->container->get(LanguageService::class)->getText('Lista guardada con exito'));
        } catch (\Exception $e) {
            $this->flash->addMessage('error', $e->getMessage());
        }
        return RouteHelpers::redirect($request, $response, 'shatask.listas.get.list');
    }
}
