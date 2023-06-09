<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Entities\Usuario;

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
    
    public function criar() {

        $usuario = new Usuario();

        $data = [
            'titulo' => "Criando um novo usuario",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/criar', $data);

    }
    
    public function cadastrar() {

        $request = service('request');

        $method = $request->getMethod();

        if ($method === 'post') {
            
            $usuario = new Usuario($this->request->getPost());

            if ($this->usuarioModel->protect(false)->save($usuario)) {
                
                return redirect()->to(site_url("admin/usuarios/show/". $this->usuarioModel->getInsertID()))
                                 ->with('sucesso',"usuario $usuario->nome cadastrado com sucesso!");
                
            } else {

                return redirect()->back()
                        ->with('errors_model', $this->usuarioModel->errors())
                        ->with('atencao', 'Por favor verifique os erros abaixo')
                        ->withInput();

            }

        } else {
            
            return redirect()->back();
        }
       

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

        $request = service('request');

        $method = $request->getMethod();

        if ($method === 'post') {
            
            $usuario = $this->buscaUsuarioOu404($id);

            $post = $this->request->getPost();

            if (empty($post['password'])) {

                $this->usuarioModel->desabilitaValidacaoSenha();
                unset($post['password']);
                unset($post['password_comfirmation']);

            }

            $usuario->fill($post);

            if (!$usuario->hasChanged()) {

                return redirect()->back()->with('info', 'Não há dados para atualizar!');

            }

            if ($this->usuarioModel->protect(false)->save($usuario)) {
                
                return redirect()->to(site_url("admin/usuarios/show/$usuario->id"))
                                 ->with('sucesso',"usuario $usuario->nome atualizado com sucesso!");
                
            } else {

                return redirect()->back()
                        ->with('errors_model', $this->usuarioModel->errors())
                        ->with('atencao', 'Por favor verifique os erros abaixo')
                        ->withInput();

            }

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
