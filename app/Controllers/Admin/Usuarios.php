<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Usuarios extends BaseController
{

    private $usuarioModel;

    public function __construct () {

        $this->usuarioModel = new \App\Models\UsuarioModel();

    }

    public function index()
    {
        $data = [

            'titulo' => 'Listando Usuarios',
            'usuarios' => $this->usuarioModel->findAll(),

        ];
        
        return view('Admin/Usuarios/Index', $data);

    }

    public function procurar(){

        if (!$this->request->isAJAX()) {
            
            exit("Página não encontrada!");
        }

        $usuarios = $this->usuarioModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($usuarios as $usuario) {

            $data['id'] = $usuario->id;
            $data['value'] = $usuario->nome;

            $retorno[] = $data;            
        }    
            

        return $this->response->setJSON($retorno);        

    }    

}
