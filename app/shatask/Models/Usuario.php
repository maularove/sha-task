<?php

namespace App\Shatask\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Usuario extends BaseModel implements ModelInterface
{
    public $id;
    public $nombre;
    public $usuario;
    public $password;
}
