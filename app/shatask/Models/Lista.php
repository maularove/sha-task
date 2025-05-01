<?php

namespace App\Shatask\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Lista extends BaseModel implements ModelInterface
{
    public $ID;
    public $user_id;
    public $nombre;

    public const DB_IDENTIFIER = 'ID';

    public function getUpdateValues(): array
    {
        return [
            'user_id',
            'nombre'
        ];
    }
    public function getCreateValues(): array
    {
        return [
            'user_id',
            'nombre'
        ];
    }
}
