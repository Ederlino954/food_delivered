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
            'cpf' => '349.957.910-35',
            'telefone' => '99-99999-9999',

        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [
            'nome' => 'lino',
            'email' => 'lino@gmail',
            'cpf' => '349.466.600-89',
            'telefone' => '55-55555-5555',

        ];

        $usuarioModel->protect(false)->insert($usuario);

        dd($usuarioModel->errors());

    }
}
