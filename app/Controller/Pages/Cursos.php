<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Cursos as EntityCursos;
use \WilliamCosta\DatabaseManager\Pagination;

class Cursos extends Page{

    private static function getCursoItens($request, &$obPagination){
        $itens = '';

        //qnt de registros
        $quantidadeTotal = EntityCursos::getCurso(null,null,null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //pg atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instanciando a paginação
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 2);

        $results = EntityCursos::getCurso(null, 'id DESC', $obPagination->getLimit());

        while($obCurso = $results->fetchObject(EntityCursos::class)){
            $itens .= View::render('pages/cursos/item',[
                'nome_curso' => $obCurso->nome_curso,
                'descricao' => $obCurso->descricao,
            ]);
        }

        return $itens;  
    }

/**
 * @return string
 * 
 * método que retorna o cont da view
 */
    
    public static function getCursos($request){

        $content = View::render('pages/cursos', [
            'itens' => self::getCursoItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
        ]);
        return parent::getPage('Meu Valioso Curso', $content);
    }

    //método que cadastra um curso

    public static function insertCurso($request){
        $postVars = $request->getPostVars();

        $obCurso = new EntityCursos;
        $obCurso->nome_curso = $postVars['nome_curso'];
        $obCurso->descricao = $postVars['descricao'];
        // var_dump($obCurso);
        $obCurso->cadastrar();

        return self::getCursos($request);
    }

}