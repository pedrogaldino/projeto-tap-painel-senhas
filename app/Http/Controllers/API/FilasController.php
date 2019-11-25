<?php

namespace App\Http\Controllers\API;

use App\Entities\Fila;
use App\Http\Controllers\Controller;

class FilasController extends Controller
{

    public function index()
    {
        $filas = Fila::all();

        return [
            'data' => $filas
        ];
    }

    public function view($fila)
    {
        $fila = Fila::with('senhasOrdenadas', 'senhasChamadas')
            ->findOrFail($fila);

        return [
            'data' => $fila
        ];
    }

}
