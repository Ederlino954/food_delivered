<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Testes extends BaseController
{
    public function index()
    {

        $data = [
            "titulo" => "  Sistema de entrega de comida com codeigniter 4!  ",
            // "subtitulo" => "  vamos la "
        ];

        return view('Testes/index', $data);

    }

    public function novo()
    {
        echo "Novo";
    }
}
