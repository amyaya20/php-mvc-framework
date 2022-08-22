<?php

use amohd12\phpmvc\Application;

    class m0002_add_password_column {

        // each class in migration have two methods (up and down methods)

        public function up(){

            $db = Application::$app-> db;
            $sql = " ALTER TABLE users ADD COLUMN password VARCHAR(512) not null;";
            $db-> pdo-> exec($sql);
        }
        

        public function down(){

            $db = Application::$app-> db;
            $sql = " ALTER TABLE users DROP COLUMN password;";
            $db-> pdo-> exec($sql);

        }


    }