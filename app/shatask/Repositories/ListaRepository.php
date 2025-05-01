<?php

namespace App\Shatask\Repositories;

use App\Shared\Helpers\DB;
use App\Shared\Repositories\BaseRepository;
use App\Shatask\Models\Lista;
use Psr\Container\ContainerInterface;


final class ListaRepository extends BaseRepository
{
    public string $tableName = 'listas';
    public string $class = Lista::class;

    public function __construct(DB $db, ContainerInterface $container)
    {
        parent::__construct($db, $container);
    }

    public function findByUserId(int $userId): array
    {
        $query = "SELECT * FROM {$this->tableName} WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->class);
    }
}
