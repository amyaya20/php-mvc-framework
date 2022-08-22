<?php

    namespace amohd12\phpmvc\db;
    use amohd12\phpmvc\Application;
    class Database {


        public \PDO $pdo;


        public function __construct (array $config){

            $dsn = $config['dsn'] ?? '';
            $user = $config['user'] ?? '';
            $password = $config['password'] ?? '';

            $this-> pdo = new \PDO($dsn, $user, $password);
            $this-> pdo-> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); // to through exception if there are any problem 

        }


        public function applyMigrations(){

            $this-> createMigrationsTable();
            $appliedMigrations = $this-> getAppliedMigrations();

            $newMigrations = [];

            $files = scandir(Application::$ROOT_DIR.'/migrations');

            // echo "<pre>";
            // var_dump($files);
            // echo "</pre>";
            // exit;

            $toApplyMigrations = array_diff($files, $appliedMigrations);

            foreach($toApplyMigrations as $migration){

                if($migration === '.' || $migration === '..'){
                    continue;
                }

                require_once Application::$ROOT_DIR.'/migrations/'.$migration;
                $className = pathinfo($migration, PATHINFO_FILENAME); // to get the filename without the extention

                // echo "<pre>";
                // var_dump($className);
                // echo "</pre>";
                // exit;

                $instance = new $className();
                $this-> log("Applying migration $migration");
                $instance-> up();
                $this-> log("Applied migration $migration");

                $newMigrations [] = $migration;

            }

            if(!empty($newMigrations)){

                $this-> saveMigrations($newMigrations);
            }
            else{

                $this-> log("All migrations are applied");
            }

        }


        public function createMigrationsTable(){

            $this-> pdo-> exec(
                
                "
            
                    CREATE TABLE IF NOT EXISTS migrations (

                        id INT(11) not null AUTO_INCREMENT,
                        migration VARCHAR(255),
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id)

                    )ENGINE=INNODB;
                    
                ");
        }


        public function getAppliedMigrations(){

            $statment = $this-> pdo-> prepare("SELECT migration FROM migrations;");
            $statment-> execute();
            return $statment-> fetchAll(\PDO::FETCH_COLUMN);
        }


        public function saveMigrations(array $migrations){

            $migrations = array_map(fn($m) => "('$m')", $migrations);
            $str = implode(",", $migrations);

            $statment = $this-> pdo-> prepare("INSERT INTO migrations (migration) VALUES 
            
                    $str
                    ");


            $statment-> execute();

        }

        protected function log($message){

            echo '['.date('Y-m-d H:i:s').'] - ' . $message . PHP_EOL;
        }


        public function prepare($sql){

            return $this-> pdo-> prepare($sql); 
        }


    }