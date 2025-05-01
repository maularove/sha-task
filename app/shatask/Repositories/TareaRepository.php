<?php

namespace App\Shatask\Repositories;

use App\Shared\Helpers\DB;
use App\Shared\Repositories\BaseRepository;
use App\Shatask\Models\Tarea;
use Psr\Container\ContainerInterface;


final class TareaRepository extends BaseRepository
{
    public string $tableName = 'tareas';
    public string $class = Tarea::class;

    public function __construct(DB $db, ContainerInterface $container)
    {
        parent::__construct($db, $container);
    }

    public function findByListId(int $listId): array
    {
        $query = "SELECT * FROM {$this->tableName} WHERE lista_id = :lista_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['lista_id' => $listId]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->class);
    }
}
