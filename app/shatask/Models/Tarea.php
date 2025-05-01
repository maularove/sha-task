<?php

namespace App\Shatask\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Tarea extends BaseModel implements ModelInterface
{
    public $ID;
    public $lista_id;
    public $titulo;
    public $descripcion;

    public $estado;

    public const DB_IDENTIFIER = 'ID';

    public function getUpdateValues(): array
    {
        return [
            'lista_id',
            'titulo',
            'descripcion',
            'estado'
        ];
    }
    public function getCreateValues(): array
    {
        return [
            'lista_id',
            'titulo',
            'descripcion',
            'estado'
        ];
    }
}
