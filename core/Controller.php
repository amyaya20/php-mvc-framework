<?php

    namespace amohd12\phpmvc;

    use amohd12\phpmvc\middlewares\BaseMiddleware;


    class Controller{


        public string $layout = 'main';

        // it is an array of BaseMiddleware => \amohd12\phpmvc\middleware[]
        protected array $middlewares = [];

        public string $action = '';

        public function render($view, $params=[]){

            return Application::$app-> view-> renderView($view, $params);
        }

        public function setLayout($layout){

            $this->layout = $layout;

        }


        public function registerMiddleware(BaseMiddleware $middleware){

            $this-> middlewares[] = $middleware;

        }

        public function getMiddlewares():array{

            return $this-> middlewares;
        }

    }