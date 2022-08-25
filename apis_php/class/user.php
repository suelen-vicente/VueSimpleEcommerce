<?php
    class User{
        // Connection
        private $connection;

        // Table
        private $db_table = "Users";

        // Columns
        // id, name, email, password, shipping_address
        public $id;
        public $name;
        public $email;
        public $password;
        public $shipping_address;

        // Db connection
        public function __construct($db){
            $this->connection = $db;
        }

        // GET ALL
        public function getUsers(){
            $command = "SELECT * FROM " . $this->db_table . " ORDER BY id";
            $sql = $this->connection->prepare($command);
            $sql->execute();
            return $sql;
        }

        // CREATE
        public function createUser(){
            $command = "INSERT INTO
                            ". $this->db_table ."
                        SET
                            name = :name, 
                            email = :email, 
                            password = :password, 
                            shipping_address = :shipping_address";
        
            $sql = $this->connection->prepare($command);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->shipping_address=htmlspecialchars(strip_tags($this->shipping_address));
        
            $sql->bindParam(":name", $this->name);
            $sql->bindParam(":email", $this->email);
            $sql->bindParam(":password", $this->password);
            $sql->bindParam(":shipping_address", $this->shipping_address);
        
            if($sql->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleUser(){
            $command = "SELECT
                        *
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = :id";
                       
            $sql = $this->connection->prepare($command);
            $sql->bindParam(":id", $this->id);
            $sql->execute();
            $dataRow = $sql->fetch(PDO::FETCH_ASSOC);

            $this->id = $dataRow['id'];
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->password = $dataRow['password'];
            $this->shipping_address = $dataRow['shipping_address'];
        }        

        // UPDATE
        public function updateUser(){
            $command = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email, 
                        password = :password, 
                        shipping_address = :shipping_address
                    WHERE 
                        id = :id";
            
            $sql = $this->connection->prepare($command);

            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->shipping_address=htmlspecialchars(strip_tags($this->shipping_address));
            
            $sql->bindParam(":name", $this->name);
            $sql->bindParam(":email", $this->email);
            $sql->bindParam(":password", $this->password);
            $sql->bindParam(":shipping_address", $this->shipping_address);
            $sql->bindParam(":id", $this->id);
            
            if($sql->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteUser(){
            $command = "DELETE FROM " . $this->db_table . " WHERE id = :id";
            $sql = $this->connection->prepare($command);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $sql->bindParam(":id", $this->id);
        
            if($sql->execute()){
                return true;
            }
            return false;
        }
    }
?>