<?php

use amohd12\phpmvc\Application;

    class m0001_initial {

        // each class in migration have two methods (up and down methods)

        public function up(){

            $db = Application::$app-> db;
            $sql = " CREATE TABLE users (

                    id INT AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(255) not null,
                    firstname VARCHAR(255) not null,
                    lastname VARCHAR(255) not null,
                    status TINYINT not null,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                
                ) ENGINE=INNODB;";

            $db-> pdo-> exec($sql);
        }
        

        public function down(){

            $db = Application::$app-> db;
            $sql = "DROP TABLE users;";
            $db-> pdo-> exec($sql);

        }


    }