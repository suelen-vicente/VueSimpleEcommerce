<?php
    class OrderProduct{
        // Connection
        private $connection;

        // Table
        private $db_table = "Sale_Product";

        // Columns
        // sale, product, quantity, sub_total, shipping_cost, taxes, total
        public $order;
        public $product;
        public $quantity;
        public $subTotal;
        public $shippingCost;
        public $taxes;
        public $total;

        // Db connection
        public function __construct($db){
            $this->connection = $db;
        }

        // GET ALL
        public function getProductsByOrder(){
            $command = "SELECT * FROM " . $this->db_table. " WHERE sale = :order";

            $sql = $this->connection->prepare($command);
            $this->order=htmlspecialchars(strip_tags($this->order));
            $sql->bindParam(":order", $this->order);

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
                        sale = :order and
                        product = :product";
                       
            $sql = $this->connection->prepare($command);

            $this->order=htmlspecialchars(strip_tags($this->order));
            $this->product=htmlspecialchars(strip_tags($this->product));

            $sql->bindParam(":order", $this->order);
            $sql->bindParam(":product", $this->product);

            $sql->execute();

            $dataRow = $sql->fetch(PDO::FETCH_ASSOC);

            $this->order = $dataRow['sale'];
            $this->product = $dataRow['product'];
            $this->quantity = $dataRow['quantity'];
            $this->subTotal = $dataRow['sub_total'];
            $this->shippingCost = $dataRow['shipping_cost'];
            $this->taxes = $dataRow['taxes'];
            $this->total = $dataRow['total'];
        } 

        // CREATE
        public function addProductToOrder(){
            $command = "INSERT INTO
                            ". $this->db_table ."
                        SET
                        sale          = :order, 
                        product       = :product,
                        quantity      = :quantity,
                        sub_total     = :sub_total,
                        shipping_cost = :shipping_cost,
                        taxes         = :taxes,
                        total         = :total";
                        
            $sql = $this->connection->prepare($command);

            $this->order=htmlspecialchars(strip_tags($this->order));
            $this->product=htmlspecialchars(strip_tags($this->product));
            $this->quantity=htmlspecialchars(strip_tags($this->quantity));
            $this->subTotal=htmlspecialchars(strip_tags($this->subTotal));
            $this->shippingCost=htmlspecialchars(strip_tags($this->shippingCost));
            $this->taxes=htmlspecialchars(strip_tags($this->taxes));
            $this->total=htmlspecialchars(strip_tags($this->total));
            
            $sql->bindParam(":order", $this->order);
            $sql->bindParam(":product", $this->product);
            $sql->bindParam(":quantity", $this->quantity);
            $sql->bindParam(":sub_total", $this->subTotal);
            $sql->bindParam(":shipping_cost", $this->shippingCost);
            $sql->bindParam(":taxes", $this->taxes);
            $sql->bindParam(":total", $this->total);
            
            if($sql->execute()){
                return true;
            }
            return false;
        }

        // DELETE
        function deleteProduct(){
            $command = "  DELETE FROM " . $this->db_table . 
                        " WHERE sale    = :order and
                                product = :product";

            $sql = $this->connection->prepare($command);
        
            $this->order=htmlspecialchars(strip_tags($this->order));
            $this->product=htmlspecialchars(strip_tags($this->product));
        
            $sql->bindParam(":order", $this->order);
            $sql->bindParam(":product", $this->product);
        
            if($sql->execute()){
                return true;
            }
            return false;
        }
    }
?>