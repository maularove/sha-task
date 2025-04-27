<?php

namespace App\Shatask\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Lista extends BaseModel implements ModelInterface
{
    public $id;
    public $user_id;
    public $nombre;
    public $descripcion;
}
