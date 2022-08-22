<?php

    namespace amohd12\phpmvc;

    use amohd12\phpmvc\exception\NotFoundException;

    class Router{

        public Request $request;

        protected array $routes = [];

        public Response $response;

        public function __construct(Request $request, Response $response){

            $this -> request = $request;
            $this -> response = $response;
        }

        public function get($path, $callback){

            $this -> routes['get'][$path] = $callback;

        }


        public function post($path, $callback){

            $this -> routes['post'][$path] = $callback;

        }

        public function resolve(){

            $path = $this -> request ->getPath();

            // echo "<pre>";
            // var_dump($path);
            // echo "</pre>";
            // exit;

            $method = $this -> request -> method();

            $callback = $this -> routes[$method][$path] ?? false;

            // echo "<pre>";
            // var_dump($callback);
            // echo "</pre>";
            // exit;

            if($callback === false){

                //Application::$app -> response -> setStatusCode(404); 
                // OR
                // $this-> response-> setStatusCode(404);

                //return $this -> renderContent("Not found");
                // OR
                // return $this -> renderView("_404");


                throw new NotFoundException();
            }

            if(is_string($callback)) return Application::$app-> view-> renderView($callback);

            if(is_array($callback)){

                /** @var \amohd12\phpmvc\Controller $controller */

                $controller = new $callback[0]();
                Application::$app-> controller= $controller;
                $controller-> action = $callback[1];
                $callback[0] = $controller;
                foreach($controller->getMiddlewares() as $middleware){

                    $middleware-> execute();
                }

                
            }



            return call_user_func($callback, $this->request, $this-> response);

        }


    }