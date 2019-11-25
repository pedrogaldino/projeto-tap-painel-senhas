<?php

namespace App\Observers;

use App\Entities\Senha;
use App\Events\NovaSenhaGeradaEvent;
use App\Events\SenhaChamadaEvent;
use App\Jobs\NotifyUserAboutSenha;

class SenhaObserver
{

    public function creating(Senha $senha)
    {
        $fila = $senha->fila->nome[0];
        $seq = $senha->fila->senhas()->count() + 1;

        if($senha->preferencial) {
            $fila = 'P' . $fila;
        }

        if(empty($senha->valor)) {
            $senha->valor = $fila . '-' . $seq;
        }

        return $senha;
    }

    public function created(Senha $senha)
    {
        event(new NovaSenhaGeradaEvent($senha));
    }

    public function updating(Senha $senha)
    {
        if(
            $senha->getOriginal('ultima_chamada_em') == null
            && !empty($senha->ultima_chamada_em)
        ) {
            event(new SenhaChamadaEvent($senha));

            if($senha->notification_token)
                dispatch(new NotifyUserAboutSenha($senha));
        }
    }

}
