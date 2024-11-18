<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Cursos {

    public $id;

    public $nome_curso;

    public $descricao;

    public function cadastrar(){
        $this->id = (new Database('tb_curso'))->insert([
            'nome_curso' => $this->nome_curso,
            'descricao' => $this->descricao
        ]);
    }

    public static function getCurso($where = null, $order = null, $limit = null, $fields ='*'){
        return (new Database('tb_curso'))->select($where, $order, $limit, $fields);
    }

}