<?php

    namespace amohd12\phpmvc;
    use amohd12\phpmvc\db\Database;
   



    class Application {

        // Typed properties
        public Router $router; 

        public Request $request;

        public static string $ROOT_DIR;

        public Response $response;

        public static Application $app;

        public ?Controller $controller = null;

        public Database $db;

        public Session $session;

        public ?UserModel $user; // ? => means this it might be null

        public string $userClass;

        public string $layout = 'main';

        public View $view;


       public function __construct($rootPath, array $config){

            // $config array is not used only for the database, it used for request or resourse or any otherthings in the future. 

            self:: $ROOT_DIR = $rootPath; 
            self::$app = $this; 
            $this -> request = new Request();
            $this -> response = new Response();
            $this-> session = new Session();
            $this -> router = new Router($this->request, $this -> response);
            $this-> view = new View();

            $this-> db = new Database($config['db']);

            
            $this-> userClass = $config['userClass'];
            $primaryValue = $this-> session-> get('user');
            if($primaryValue){

               $primaryKey = $this-> userClass::primaryKey();
               $this-> user = $this-> userClass :: findOne([$primaryKey => $primaryValue]);

            }

            else{
               $this-> user = null;
            }

       }

       public function run(){

          try{

               echo $this -> router -> resolve();
          }
          catch(\Exception $e){

               $this -> response -> setStatusCode($e-> getCode());

               echo $this-> view-> renderView('_error', [

                    'exception' => $e
               ]);
          }

       }

       public function getController(){

            return $this-> controller;

       }

       public function setController(Controller $controller){

            $this-> controller = $controller;
        
    }


    public function login(UserModel $user){

          $this-> user = $user;
          $primaryKey = $user-> primaryKey();
          $primaryValue = $user-> {$primaryKey};
          $this-> session-> set('user', $primaryValue);
          return true;
    }

    public function logout(){

          $this-> user = null;
          $this-> session-> remove('user');

     }


     public static function isGuest(){

          return !self::$app-> user;
     }


}