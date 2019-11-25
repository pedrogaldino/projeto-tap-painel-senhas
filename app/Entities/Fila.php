<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fila extends Model
{
    use SoftDeletes;

    protected $table = 'filas';

    protected $fillable = [
        'nome'
    ];

    public function senhas()
    {
        return $this->hasMany(Senha::class, 'fila_id', 'id');
    }

    public function senhasOrdenadas()
    {
        return $this->senhas()
            ->naoAtendidas()
            ->porPrioridade()
            ->limit(10);
    }

    public function senhasChamadas()
    {
        return $this
            ->senhas()
            ->atendidas()
            ->limit(6);
    }
}
