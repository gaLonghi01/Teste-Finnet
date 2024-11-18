<?php

namespace App\Http;

class Response{

    private $httpCode = 200;
    private $headers = [];
    private $contentType = 'text/html';
    private $content;
    
    public function __construct($httpCode,$content,$contentType = 'text/html'){
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    //método responsável por alterar o content type do response
    public function setContentType($contentType) {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    // método que adiciona registros no header
    public function addHeader($key,$value) {
        $this->headers[$key] = $value;
    }

    //método que envia os headers para o navegador
    private function sendHeaders() {
        http_response_code($this->httpCode);

        foreach($this->headers as $key=>$value){
            header($key.': '.$value);
        }
    }

    //método que envia a resposta para o usuário
    public function sendResponse(){
        //envia os headers
        $this->sendHeaders();

        //mostra o cont
        switch($this->contentType){
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}