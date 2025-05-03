<?php

namespace App\Shatask\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Usuario extends BaseModel implements ModelInterface
{
    public $ID;
    public $nombre;
    public $usuario;
    public $password;

    public const DB_IDENTIFIER = 'ID';

}
