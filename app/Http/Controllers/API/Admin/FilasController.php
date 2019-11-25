<?php

namespace App\Http\Controllers\API\Admin;

use App\Entities\Fila;
use App\Entities\Senha;
use App\Http\Controllers\Controller;

class FilasController extends Controller
{

    public function index()
    {
        $filas = Fila::with('senhasOrdenadas', 'senhasChamadas')->get();

        return [
            'data' => $filas
        ];
    }

    public function chamar($senha)
    {
        $senha = Senha::findOrFail($senha);

        $senha->chamar();

        return [
            'data' => [
                'message' => 'Senha chamada!'
            ]
        ];
    }
}
