<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Senha extends Model
{
    use SoftDeletes;

    protected $table = 'filas_senhas';

    protected $fillable = [
        'valor',
        'preferencial',
        'ultima_chamada_em',
        'fila_id',
        'notification_token'
    ];

    protected $casts = [
        'preferencial' => 'boolean',
        'ultima_chamada_em' => 'datetime'
    ];

    public function fila()
    {
        return $this->belongsTo(Fila::class, 'fila_id');
    }

    public function scopePorPrioridade(Builder $builder)
    {
        return $builder
            ->orderByDesc('preferencial')
            ->orderBy('created_at');
    }

    public function scopeNaoAtendidas(Builder $builder)
    {
        return $builder->whereNull('ultima_chamada_em');
    }

    public function scopeAtendidas(Builder $builder)
    {
        return $builder->whereNotNull('ultima_chamada_em')->latest('ultima_chamada_em');
    }

    public function scopeByValor(Builder $builder, $valor)
    {
        return $builder->where('valor', $valor);
    }

    public function chamar()
    {
        $this->ultima_chamada_em = now();
        $this->save();
    }
}

