<?php
    class Comments{
        // Connection
        private $connection;

        // Table
        private $db_table = "Comments";

        // Columns
        // id, product, user, rating, image, text
        public $id;
        public $product;
        public $user;
        public $rating;
        public $image;
        public $text;

        // Db connection
        public function __construct($db){
            $this->connection = $db;
        }

        // GET ALL
        public function getComments(){
            $command = "SELECT * FROM " . $this->db_table;
            $sql = $this->connection->prepare($command);
            $sql->execute();
            return $sql;
        }

        // GET ALL BY USER
        public function getCommentsByUser(){
            $command = "SELECT * FROM " . $this->db_table . " WHERE user = :user ORDER BY product";
            
            $sql = $this->connection->prepare($command);
            
            $this->user=htmlspecialchars(strip_tags($this->user));
            
            $sql->bindParam(":user", $this->user);
            
            $sql->execute();
            
            return $sql;
        }

        // GET ALL BY PRODUCT
        public function getCommentsByProduct(){
            $command = "SELECT * FROM " . $this->db_table . " WHERE product = :product ORDER BY user";
            
            $sql = $this->connection->prepare($command);

            $this->product=htmlspecialchars(strip_tags($this->product));
            
            $sql->bindParam(":product", $this->product);
            
            $sql->execute();
            
            return $sql;
        }

        // CREATE
        public function createComment(){
            $command = "INSERT INTO
                            ". $this->db_table ."
                        SET
                            product = :product,
                            user    = :user,
                            rating  = :rating,
                            image   = :image,
                            text    = :text";
        
            $sql = $this->connection->prepare($command);
        
            $this->product=htmlspecialchars(strip_tags($this->product));
            $this->user=htmlspecialchars(strip_tags($this->user));
            $this->rating=htmlspecialchars(strip_tags($this->rating));
            $this->image=htmlspecialchars(strip_tags($this->image));
            $this->text=htmlspecialchars(strip_tags($this->text));
        
            $sql->bindParam(":product", $this->product);
            $sql->bindParam(":user", $this->user);
            $sql->bindParam(":rating", $this->rating);
            $sql->bindParam(":image", $this->image);
            $sql->bindParam(":text", $this->text);
        
            if($sql->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleComment(){
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
            $this->product = $dataRow['product'];
            $this->user    = $dataRow['user'];
            $this->rating  = $dataRow['rating'];
            $this->image   = $dataRow['image'];
            $this->text    = $dataRow['text'];
        }        

        // UPDATE
        public function updateComment(){
            $command = "UPDATE
                        ". $this->db_table ."
                    SET
                        rating  = :rating,
                        image   = :image,
                        text    = :text
                    WHERE 
                        id = :id";
            
            $sql = $this->connection->prepare($command);

            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->rating=htmlspecialchars(strip_tags($this->rating));
            $this->image=htmlspecialchars(strip_tags($this->image));
            $this->text=htmlspecialchars(strip_tags($this->text));
        
            $sql->bindParam(":id", $this->id);
            $sql->bindParam(":rating", $this->rating);
            $sql->bindParam(":image", $this->image);
            $sql->bindParam(":text", $this->text);
            
            if($sql->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteComment(){
            $command = "DELETE FROM " . $this->db_table . " WHERE id = :id";
            $sql = $this->connection->prepare($command);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $sql->bindParam(":id", $this->id);
        
            if($sql->execute()){
                return true;
            }
            return false;
        }

        // DELETE BY USER
        function deleteCommentByUser(){
            $command = "DELETE FROM " . $this->db_table . " WHERE user = :user";
            $sql = $this->connection->prepare($command);
        
            $this->user=htmlspecialchars(strip_tags($this->user));
        
            $sql->bindParam(":user", $this->user);
        
            if($sql->execute()){
                return true;
            }
            return false;
        }

        // DELETE BY PRODUCT
        function deleteCommentByProduct(){
            $command = "DELETE FROM " . $this->db_table . " WHERE product = :product";
            $sql = $this->connection->prepare($command);
        
            $this->product=htmlspecialchars(strip_tags($this->product));
        
            $sql->bindParam(":product", $this->product);
        
            if($sql->execute()){
                return true;
            }
            return false;
        }
    }
?>