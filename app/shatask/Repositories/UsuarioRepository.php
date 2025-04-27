<?php

namespace App\Shatask\Repositories;

use App\Shared\Helpers\DB;
use App\Shatask\Models\Usuario;
use App\Shared\Repositories\BaseRepository;
use Psr\Container\ContainerInterface;


final class UsuarioRepository extends BaseRepository
{
    public string $tableName = 'usuarios';
    public string $class = Usuario::class;

    public function __construct(DB $db, ContainerInterface $container)
    {
        parent::__construct($db, $container);
    }

}
