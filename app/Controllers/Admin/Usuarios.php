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
    
    public function show($id = null) {

        $usuario = $this->buscaUsuarioOu404($id);       

        $data = [
            'titulo' => "Detalhando o usuario: $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/show', $data);

    }

    public function editar($id = null) {

        $usuario = $this->buscaUsuarioOu404($id);       

        $data = [
            'titulo' => "Editando o usuario: $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/editar', $data);

    }

    public function atualizar($id = null) {

        // if ($this->request->getMethod() === 'post') { // DEPRECATED
        //     # code...
        // }

        $request = service('request');

        $method = $request->getMethod();

        if ($method === 'post') {
            
            $usuario = $this->buscaUsuarioOu404($id);

            $post = $this->request->getPost();

            $usuario->fill($post);

            dd($usuario);

        } else {
            
            return redirect()->back();
        }
       

    }

    public function buscaUsuarioOu404(int $id = null) {

        if (!$id || !$usuario =  $this->usuarioModel->where('id', $id)->first() ) {
            
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuario: $id");          

        }

        return $usuario;
    }

}
