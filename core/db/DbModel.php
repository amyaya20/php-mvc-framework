<?php

    namespace app\core\db;
    use app\core\Model;
    use app\core\Application;



    abstract class DbModel extends Model {


        abstract public static function tableName(): string;
        abstract public function attributes(): array;

        abstract public static function primaryKey(): string;


        public function save(){

            $tableName = $this-> tableName();
            $attributes = $this-> attributes();

            $params = array_map(fn($attr) => ":$attr", $attributes);

            
            $sql = "INSERT INTO $tableName (".implode(',', $attributes).")
                     VALUES (".implode(',', $params).");";

            $statment = self::prepare($sql);

            // echo "<pre>";
            // var_dump($statment, $params, $attributes);
            // echo "</pre>";
            // exit;

            // to bind the parameters.
            foreach($attributes as $attribute){

                $statment-> bindValue(":$attribute", $this-> {$attribute});

            }

            $statment-> execute();
            return true;

        }

        public static function findOne($where){ // $where = [email => zura@example.com, firstname => zura]

            $tableName = static::tableName(); // static will be replaced by the name of the class that will use this method.

            $attributes = array_keys($where);

            $attr = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));

            $sql = "SELECT * FROM $tableName WHERE $attr";

            $statement = self::prepare($sql);
            
            foreach($where as $key => $value){

                $statement-> bindValue(":$key", $value);

            }

            $statement-> execute();
            return $statement-> fetchObject(static::class);
        }


        public static function prepare($sql){

            return Application::$app-> db-> pdo-> prepare($sql); 
        }



    }