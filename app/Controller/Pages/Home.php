<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page{

/**
 * @return string
 * 
 * método que retorna o cont da view
 */
    
    public static function getHome(){
        $obOrganization = new Organization;

        $content = View::render('pages/home', [
            'name' => $obOrganization->name,
            'saudacoes' => $obOrganization->saudacoes,
        ]);
        return parent::getPage('Meu Valioso Curso', $content);
    }

}