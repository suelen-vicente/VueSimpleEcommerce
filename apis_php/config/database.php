<?php 
    class Database {

        public function getDb(){
            $db_user = 'root';
            $db_password= '';

            $db = new PDO('mysql:dbname=ecommerce; host=localhost', $db_user, $db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $db;
        }
    }  
?>