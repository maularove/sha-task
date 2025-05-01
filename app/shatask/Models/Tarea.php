<?php

namespace App\Shatask\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Tarea extends BaseModel implements ModelInterface
{
    public $id;
    public $lista_id;
    public $titulo;
    public $descripcion;

    public $estado;
}
