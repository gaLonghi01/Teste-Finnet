<?php

use \App\Http\Response;
use \App\Controller\Pages;

//rota home
$obRouter->get('/', [
    function() {
        return new Response(200, Pages\Home::getHome());
    }
]);

//rota sobre
$obRouter->get('/sobre', [
    function() {
        return new Response(200, Pages\About::getAbout());
    }
]);

// $obRouter->get('/pagina/{idPagina}/{acao}', [
//     function($idPagina, $acao) {
//         return new Response(200, 'Página: '.$idPagina.' - '.$acao);
//     }
// ]);

//rota depoimentos
$obRouter->get('/cursos', [
    function($request) {
        return new Response(200, Pages\Cursos::getCursos($request));
    }
]);

//rota depoimentos (post)
$obRouter->post('/cursos', [
    function($request) {
        return new Response(200, Pages\Cursos::insertCurso($request));
    }
]);