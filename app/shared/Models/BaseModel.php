<?php

namespace App\Shared\Models;

use App\Shared\Interfaces\ModelInterface;

class BaseModel implements ModelInterface
{
    public const DB_IDENTIFIER = 'id';
    public const RENAME = []; // Propiedades que deben ser renombradas
    public const BOOLEAN_PROPERTIES = []; // Propiedades que deben ser convertidas a booleano

    public function getUpdateValues(): array
    {
        return [];
    }

    public function getCreateValues(): array
    {
        return [];
    }

    public function __set(string $name, mixed $value): void
    {
        if (isset(static::RENAME[$name])) {
            $name = static::RENAME[$name];
        }

        // Convertir a booleano si es necesario
        if (in_array($name, static::BOOLEAN_PROPERTIES)) {
            $value = (bool)$value;
        }

        $this->$name = $value;
    }
}
