<?php

    namespace app\controllers;

    use amohd12\phpmvc\Application;
    use amohd12\phpmvc\Controller;
    use amohd12\phpmvc\Request;
    use amohd12\phpmvc\Response;
    use app\models\User;
    use app\models\LoginForm;
    use amohd12\phpmvc\middlewares\AuthMiddleware;
    

    class AuthController extends Controller{


        public function __construct(){

            $this-> registerMiddleware(new AuthMiddleware(['profile'])); // in general => middleware is between request and the controller

        }

        public function login(Request $request, Response $response){

            $loginForm = new LoginForm();

            if($request-> isPost()){

                $loginForm-> loadData($request-> getBody());
                if($loginForm-> validate() && $loginForm-> login()){

                    $response-> redirect('/');
                    return;
                }
            }

            $this -> setLayout('auth');
            return $this-> render('login', [

                'model' => $loginForm
            ]);
        }


        public function register(Request $request){

            $user = new User();

            if($request->isPost()){

                $user-> loadData($request-> getBody());

                // echo "<pre>";
                // var_dump($registerModel);
                // echo "</pre>";
                // exit;

                if($user-> validate() && $user-> save()){

                    Application::$app-> session-> setFlash('success', 'Thanks for registering');
                    Application::$app-> response-> redirect('/');
                    exit;
                }

                // echo "<pre>";
                // var_dump($registerModel-> errors);
                // echo "</pre>";
                // exit;

                 return $this-> render('register', [
                    'model' => $user
                 ]);
            }

            $this -> setLayout('auth');

            return $this-> render('register', [

                'model' => $user
             ]);


        }

        public function logout(Request $request, Response $response){

            Application::$app-> logout();
            $response-> redirect('/');
        }


        public function profile(){

            return $this-> render('profile');
        }


        


    }