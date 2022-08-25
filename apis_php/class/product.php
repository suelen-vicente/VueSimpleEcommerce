<?php
    class Product{
        // Connection
        private $connection;

        // Table
        private $db_table = "Product";

        // Columns
        // id, name, description, image, price, shipping_cost, brand
        public $id;
        public $name;
        public $description;
        public $image;
        public $price;
        public $shipping_cost;
        public $brand;

        // Db connection
        public function __construct($db){
            $this->connection = $db;
        }

        // GET ALL
        public function getProducts(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . " ORDER BY id";
            $stmt = $this->connection->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createProduct(){

            $command = "INSERT INTO
                            ". $this->db_table ."
                        SET
                            name = :name, 
                            description = :description, 
                            image = :image, 
                            price = :price, 
                            shipping_cost = :shipping_cost, 
                            brand = :brand";
        
            $sql = $this->connection->prepare($command);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->image=htmlspecialchars(strip_tags($this->image));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->shipping_cost=htmlspecialchars(strip_tags($this->shipping_cost));
            $this->brand=htmlspecialchars(strip_tags($this->brand));
        
            $sql->bindParam(":name", $this->name);
            $sql->bindParam(":description", $this->description);
            $sql->bindParam(":image", $this->image);
            $sql->bindParam(":price", $this->price);
            $sql->bindParam(":shipping_cost", $this->shipping_cost);
            $sql->bindParam(":brand", $this->brand);
        
            if($sql->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleProduct(){
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

            $this->name = $dataRow['name'];
            $this->description = $dataRow['description'];
            $this->image = $dataRow['image'];
            $this->price = $dataRow['price'];
            $this->shipping_cost = $dataRow['shipping_cost'];
            $this->brand = $dataRow['brand'];
        }        

        // UPDATE
        public function updateProduct(){
            $command = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        description = :description, 
                        image = :image, 
                        price = :price, 
                        shipping_cost = :shipping_cost, 
                        brand = :brand
                    WHERE 
                        id = :id";
            
            $sql = $this->connection->prepare($command);

            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->image=htmlspecialchars(strip_tags($this->image));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->shipping_cost=htmlspecialchars(strip_tags($this->shipping_cost));
            $this->brand=htmlspecialchars(strip_tags($this->brand));
            $this->brand=htmlspecialchars(strip_tags($this->id));
            
            $sql->bindParam(":name", $this->name);
            $sql->bindParam(":description", $this->description);
            $sql->bindParam(":image", $this->image);
            $sql->bindParam(":price", $this->price);
            $sql->bindParam(":shipping_cost", $this->shipping_cost);
            $sql->bindParam(":brand", $this->brand);
            $sql->bindParam(":id", $this->id);
            
            if($sql->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteProduct(){
            $command = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $sql = $this->connection->prepare($command);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $sql->bindParam(1, $this->id);
        
            if($sql->execute()){
                return true;
            }
            return false;
        }
    }
?>