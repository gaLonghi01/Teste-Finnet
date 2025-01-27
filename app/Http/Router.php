<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

class Router{

    private $url = '';
    private $prefix = '';
    private $routes = [];
    private $request;

    public function __construct($url){
        $this->request = new Request($this);
        $this->url = $url; 
        $this->setPrefix();
    }

    private function setPrefix() {
        $parseUrl = parse_url($this->url);

        $this->prefix = $parseUrl['path'] ?? '';
    }

    private function addRoute($method, $route, $params = []) {
        foreach($params as $key=>$value) {
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $params['variables'] = [];

        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable,$route,$matches)){
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //padrão para validar url
        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/ ';

        $this->routes[$patternRoute][$method] = $params;
    }

    public function get($route, $params = []){

        return $this->addRoute('GET', $route, $params);

    }

    public function post($route, $params = []){

        return $this->addRoute('POST', $route, $params);

    }

    public function put($route, $params = []){

        return $this->addRoute('PUT', $route, $params);

    }

    public function delete($route, $params = []){

        return $this->addRoute('DELETE', $route, $params);

    }

    //método responsável por retornar a uri
    private function getUri() {
        $uri = $this->request->getUri();
        
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        
        return end($xUri);
    }

    //método retorna os dados da rota atual
    private function getRoute(){
        $uri = $this->getUri();

        $httpMethod = $this->request->getHttpMethod();
        
        //valida as rotas
        foreach($this->routes as $patternRoute=>$methods){
            //verifica se a uri bate o padrão
            if(preg_match($patternRoute, $uri, $matches)){
                //verifica o método
                if(isset($methods[$httpMethod])) {
                    unset($matches[0]);

                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;
                    

                    return $methods [$httpMethod];
                }

                throw new Exception ("Método não permitido", 405);
            }
        }
        throw new Exception ("URL não encontrada", 404);
    }

    public function run() {
        try{
            
            $route = $this->getRoute();
            // var_dump($route);
            // return new Response (200,'success');

            if(!isset($route['controller'])){
                throw new Exception("A URL não pode ser processada", 500);
            }

            $args = [];

            //reflection f
            $reflection = new ReflectionFunction($route['controller']);
            foreach($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            // var_dump($args);

            return call_user_func_array($route['controller'], $args);

        } catch(Exception $e){
            return new Response($e->getCode(), $e->getMessage());
        }

    }

    public function getCurrentUrl() {
        return $this->url.$this->getUri();
    }

}