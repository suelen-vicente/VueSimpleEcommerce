<?php
    class Order{
        // Connection
        private $connection;

        // Table
        private $db_table = "Sale";

        // Columns
        // id, user, status, sub_total, calc_tax, shipping_total, total
        public $id;
        public $user;
        public $status;
        public $sub_total;
        public $calc_tax;
        public $shipping_total;
        public $total;

        // Db connection
        public function __construct($db){
            $this->connection = $db;
        }

        // GET ALL
        public function getOrderByUser(){
            $command = "SELECT * FROM " . $this->db_table. " WHERE user = :user";

            $sql = $this->connection->prepare($command);
            $this->user=htmlspecialchars(strip_tags($this->user));
            $sql->bindParam(":user", $this->user);

            $sql->execute();
            return $sql;
        }

        //GET ONE
        public function getSingleOrderByStatusAndUser(){

            $command = "SELECT
                        *
                      FROM
                        ". $this->db_table ."
                      WHERE 
                        user   = :user and
                        status = :status";
                       
            $sql = $this->connection->prepare($command);

            $this->user=htmlspecialchars(strip_tags($this->user));
            $this->status=htmlspecialchars(strip_tags($this->status));

            $sql->bindParam(":user", $this->user);
            $sql->bindParam(":status", $this->status);

            $sql->execute();

            $dataRow = $sql->fetch(PDO::FETCH_ASSOC);

            $this->id = $dataRow['id'];
            $this->user = $dataRow['user'];
            $this->status = $dataRow['status'];
            $this->sub_total = $dataRow['sub_total'];
            $this->calc_tax = $dataRow['calc_tax'];
            $this->shipping_total = $dataRow['shipping_total'];
            $this->total = $dataRow['total'];
        } 

        //GET ONE
        public function getSingleOrder(){

            $command = "SELECT
                        *
                      FROM
                        ". $this->db_table ."
                      WHERE 
                        id = :id";
                       
            $sql = $this->connection->prepare($command);

            $this->id=htmlspecialchars(strip_tags($this->id));

            $sql->bindParam(":id", $this->id);

            $sql->execute();

            $dataRow = $sql->fetch(PDO::FETCH_ASSOC);

            $this->id = $dataRow['id'];
            $this->user = $dataRow['user'];
            $this->status = $dataRow['status'];
            $this->sub_total = $dataRow['sub_total'];
            $this->calc_tax = $dataRow['calc_tax'];
            $this->shipping_total = $dataRow['shipping_total'];
            $this->total = $dataRow['total'];
        } 

        // CREATE
        public function createOrder(){
            $command = "INSERT INTO
                            ". $this->db_table ."
                        SET
                        user           = :user, 
                        status         = :status, 
                        sub_total      = :sub_total, 
                        calc_tax       = :calc_tax,
                        shipping_total = :shipping_total, 
                        total          = :total";

            
            $sql = $this->connection->prepare($command);
            
            $this->user=htmlspecialchars(strip_tags($this->user));
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->sub_total=htmlspecialchars(strip_tags($this->sub_total));
            $this->calc_tax=htmlspecialchars(strip_tags($this->calc_tax));
            $this->shipping_total=htmlspecialchars(strip_tags($this->shipping_total));
            $this->total=htmlspecialchars(strip_tags($this->total));
            
            $sql->bindParam(":user", $this->user);
            $sql->bindParam(":status", $this->status);
            $sql->bindParam(":sub_total", $this->sub_total);
            $sql->bindParam(":calc_tax", $this->calc_tax);
            $sql->bindParam(":shipping_total", $this->shipping_total);
            $sql->bindParam(":total", $this->total);
            
            if($sql->execute()){
                return true;
            }
            return false;
        }

        // UPDATE
        public function updateOrder(){
            $command = "UPDATE
                        ". $this->db_table ."
                    SET
                        status = :status,
                        sub_total = :sub_total,
                        calc_tax = :calc_tax,
                        shipping_total = :shipping_total,
                        total = :total
                    WHERE 
                        id = :id";
            
            $sql = $this->connection->prepare($command);

            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->sub_total=htmlspecialchars(strip_tags($this->sub_total));
            $this->calc_tax=htmlspecialchars(strip_tags($this->calc_tax));
            $this->shipping_total=htmlspecialchars(strip_tags($this->shipping_total));
            $this->total=htmlspecialchars(strip_tags($this->total));
            
            $sql->bindParam(":id", $this->id);
            $sql->bindParam(":status", $this->status);
            $sql->bindParam(":sub_total", $this->sub_total);
            $sql->bindParam(":calc_tax", $this->calc_tax);
            $sql->bindParam(":shipping_total", $this->shipping_total);
            $sql->bindParam(":total", $this->total);
            
            if($sql->execute()){
               return true;
            }
            return false;
        }

        // ChangeStatus
        function changeStatus(){
            $command = "UPDATE
                        ". $this->db_table ."
                    SET
                        status = :status
                    WHERE 
                        id = :id";

            $sql = $this->connection->prepare($command);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->status=htmlspecialchars(strip_tags($this->status));
        
            $sql->bindParam(":id", $this->id);
            $sql->bindParam(":status", $this->status);
        
            if($sql->execute()){
                return true;
            }
            return false;
        }
    }
?>