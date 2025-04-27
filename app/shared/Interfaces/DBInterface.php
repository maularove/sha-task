<?php

namespace App\Shared\Interfaces;

use PDOStatement;

interface DBInterface
{
    public function prepare(string $query, array $options = []): PDOStatement|false;
}
