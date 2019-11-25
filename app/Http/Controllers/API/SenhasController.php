<?php

namespace App\Http\Controllers\API;

use App\Entities\Fila;
use App\Entities\Senha;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotifyRequest;
use Illuminate\Http\Request;

class SenhasController extends Controller
{

    public function store($fila, Request $request)
    {
        $fila = Fila::findOrFail($fila);

        $senha = $fila
            ->senhas()
            ->create([
                'preferencial' => $request->input('preferencial', false)
            ]);

        return [
            'data' => $senha
        ];
    }

    public function notification(NotifyRequest $request)
    {
        $senha = Senha::byValor($request->input('senha'))
            ->latest()
            ->firstOrFail();

        $senha->notification_token = $request->input('token');
        $senha->save();

        return [
            'data' => $senha
        ];
    }

}
