<?php

namespace App\Http;

class Request{

    private $router;

    private $httpMethod;

    private $uri;

    //parâmetros da url

    private $queryParams = [];

    //variáveis do POST

    private $postVars = [];

    private $headers = [];

    public function __construct($router){
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    private function setUri(){
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';   

        $xUri = explode('?', $this->uri);
        $this->uri = $xUri[0];
    }

    public function getRouter() {
        return $this->router;
    }

    //método que retorna o método http da requisition

    public function getHttpMethod() {
        return $this->httpMethod;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getQueryParams() {
        return $this->queryParams;
    }

    public function getPostVars() {
        return $this->postVars;
    }

}