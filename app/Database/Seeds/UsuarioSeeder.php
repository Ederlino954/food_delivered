<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $usuarioModel = new \App\Models\UsuarioModel;

        $usuario = [
            'nome' => 'Eder',
            'email' => 'eder@gmail',
            'telefone' => '99-99999-9999',

        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [
            'nome' => 'lino',
            'email' => 'lino@gmail',
            'telefone' => '55-55555-5555',

        ];

        $usuarioModel->protect(false)->insert($usuario);

        dd($usuarioModel->errors());

    }
}
