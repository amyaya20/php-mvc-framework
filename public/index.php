<?php


    require_once __DIR__ .'/../vendor/autoload.php';
    //$app = new \app\core\Application();
    // OR
    use app\core\Application;

    use app\controllers\SiteController;

    use app\controllers\AuthController;

    
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    $config = [

        'userClass' => \app\models\User::class,

        'db' => [

            'dsn' => $_ENV['DB_DSN'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
        ]
    ];
    
    $app = new Application(dirname(__DIR__), $config); // dirname(__DIR__) => returns the path of the project


    // you can configure as many get routes as we want and we can navigate between pages.
    $app -> router -> get('/',[SiteController::class, 'home']);

    $app -> router -> get('/contact', [SiteController::class,'contact']);

    $app -> router -> post('/contact', [SiteController::class, 'contact']); // from SiteController class call the handleContact function

    $app -> router -> get('/login', [AuthController::class, 'login']);
    $app -> router -> post('/login', [AuthController::class, 'login']);

    $app -> router -> get('/register', [AuthController::class, 'register']);
    $app -> router -> post('/register', [AuthController::class, 'register']);

    $app -> router -> get('/logout', [AuthController::class, 'logout']); // it should be post for security purposes

    $app -> router -> get('/profile', [AuthController::class, 'profile']); 

    


    $app -> run();
