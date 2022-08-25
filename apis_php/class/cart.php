<?php
    class Cart{
        // Connection
        private $connection;

        // Table
        private $db_table = "Cart";

        // Columns
        // product, user, quantity
        public $productJson;
        public $productId;
        public $userJson;
        public $userId;
        public $quantity;

        //Totals variables
        public $subTotal;
        public $shipmentCost;
        public $taxes;
        public $total;

        // Db connection
        public function __construct($db){
            $this->connection = $db;
        }

        // GET ALL
        public function getCartByUser(){
            $command = "SELECT * FROM " . $this->db_table. " WHERE user = :userId";

            $sql = $this->connection->prepare($command);
            $this->userId=htmlspecialchars(strip_tags($this->userId));
            $sql->bindParam(":userId", $this->userId);

            $sql->execute();
            return $sql;
        }

        //GET ONE
        public function getSingleProduct(){

            $command = "SELECT
                        *
                      FROM
                        ". $this->db_table ."
                      WHERE 
                        product = :productId and
                        user    = :userId";
                       
            $sql = $this->connection->prepare($command);

            $this->productId=htmlspecialchars(strip_tags($this->productId));
            $this->userId=htmlspecialchars(strip_tags($this->userId));

            $sql->bindParam(":productId", $this->productId);
            $sql->bindParam(":userId", $this->userId);

            $sql->execute();

            $dataRow = $sql->fetch(PDO::FETCH_ASSOC);

            $this->productId = $dataRow['product'];
            $this->userId = $dataRow['user'];
            $this->quantity = $dataRow['quantity'];

        } 

        // CREATE
        public function addNewProduct(){
            
            $command = "INSERT INTO
                            ". $this->db_table ."
                        SET
                        user = :userId, 
                        product = :productId, 
                        quantity = :quantity";
                        
            $sql = $this->connection->prepare($command);
            
            $this->userId=htmlspecialchars(strip_tags($this->userId));
            $this->productId=htmlspecialchars(strip_tags($this->productId));
            $this->quantity=htmlspecialchars(strip_tags($this->quantity));
            
            $sql->bindParam(":userId", $this->userId);
            $sql->bindParam(":productId", $this->productId);
            $sql->bindParam(":quantity", $this->quantity);
            
            if($sql->execute()){
                return true;
            }
            return false;
        }

        // UPDATE
        public function updateProductQuantity(){
            $command = "UPDATE
                        ". $this->db_table ."
                    SET
                        quantity = :quantity
                    WHERE 
                        user    = :userId and
                        product = :productId";
            
            $sql = $this->connection->prepare($command);

            $this->quantity=htmlspecialchars(strip_tags($this->quantity));
            $this->userId=htmlspecialchars(strip_tags($this->userId));
            $this->productId=htmlspecialchars(strip_tags($this->productId));
            
            $sql->bindParam(":quantity", $this->quantity);
            $sql->bindParam(":userId", $this->userId);
            $sql->bindParam(":productId", $this->productId);
            
            if($sql->execute()){
               return true;
            }
            return false;
        }

        // DELETE SINGLE PRODUCT
        function deleteProduct(){
            $command = "  DELETE FROM " . $this->db_table . 
                        " WHERE user    = :userId and
                                product = :productId";

            $sql = $this->connection->prepare($command);
        
            $this->userId=htmlspecialchars(strip_tags($this->userId));
            $this->productId=htmlspecialchars(strip_tags($this->productId));
        
            $sql->bindParam(":userId", $this->userId);
            $sql->bindParam(":productId", $this->productId);
        
            if($sql->execute()){
                return true;
            }
            return false;
        }

        // DELETE ALL
        function clearByUser(){
            $command = "  DELETE FROM " . $this->db_table . 
                        " WHERE user    = :userId";

            $sql = $this->connection->prepare($command);
        
            $this->userId=htmlspecialchars(strip_tags($this->userId));
        
            $sql->bindParam(":userId", $this->userId);
        
            if($sql->execute()){
                return true;
            }
            return false;
        }
    }
?>