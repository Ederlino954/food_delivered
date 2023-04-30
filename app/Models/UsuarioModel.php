<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{

    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $allowedFields    = ['nome', 'email', 'telefone'];
    protected $useSoftDeletes   = true;   
    protected $useTimestamps    = true;
    protected $createdField     = 'criado_em';
    protected $updatedField     = 'atualizado_em';
    protected $deletedField     = 'deletado_em';

    protected $validationRules    = [
        'nome'     => 'required|min_length[3]|max_length[120]',
        'email'    => 'required|valid_email|is_unique[usuarios.email]',
        'cpf'    => 'required|exact_length[14]|is_unique[usuarios.cpf]',
        'password' => 'required|min_length[6]',
        'password_comfirmation' => 'required_with[password]|matches[password]',
    ];
    protected $validationMessages = [
        'nome'  => [
            'required'   => 'O campo Nome é obrigatório.',
            'min_length' => 'O campo Nome deve ter no mínimo 3 caracteres.',
            'max_length' => 'O campo Nome deve ter no máximo 120 caracteres.'
        ],
        'email' => [
            'required'    => 'O campo E-mail é obrigatório.',
            'valid_email' => 'O campo E-mail deve ser um endereço de e-mail válido.',
            'is_unique'   => 'Este endereço de e-mail já está em uso.'
        ],
        'cpf'  => [
            'required'   => 'O campo CPF é obrigatório.',
            'exact_length' => 'O campo CPF deve ter 14 caracteres.',
            'is_unique' => 'O campo CPF deve ser único.'
        ],
        'password' => [
            'required'   => 'O campo Senha é obrigatório.',
            'min_length' => 'O campo Senha deve ter no mínimo 6 caracteres.'
        ],
        'password_comfirmation' => [
            'required_with'   => 'É necessário confirmar o password.',
            'matches' => 'O password dever ser igual'
        ],
    ];

    public function procurar($term) {

        if ($term === null) {
           
            return [];

        }

        return $this->select('id, nome')
                            ->like('nome', $term)
                            ->get()
                            ->getResult();

    }

    public function desabilitaValidacaoSenha() {

        unset($this->validationRules['password']);
        unset($this->validationRules['password_comfirmation']);

    }
    
}
