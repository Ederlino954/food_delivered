<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $useTimestamps    = true;
    protected $table            = 'usuarios';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;   
    protected $allowedFields    = ['nome', 'email', 'telefone'];    
    
}
