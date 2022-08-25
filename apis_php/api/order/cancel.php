<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    //imports all classes
    include_once '../../config/database.php';
    include_once '../../class/order.php';
    
    //instantiates all classes
    $database = new Database();
    $db = $database->getDb();
    $order = new Order($db);

    if(isset($_GET['id'])){
      $order->id = $_GET['id'];
      $order->getSingleOrder();
      
      if($order->id != null){
        $order->status = "CANCELED";
        
        if($order->changeStatus()){
          http_response_code(200);
          echo json_encode(
            array("message" => "Order canceled.")
          );

        }else{
          http_response_code(404);
          echo json_encode(
            array("message" => "Order could not be canceled.")
          );
        }

      }else{
        http_response_code(404);
        echo json_encode(
          array("message" => "Not found.")
        );
      }

    }else{
      http_response_code(400);
      echo json_encode(
        array("message" => "Id is required.")
      );
    }
?>