<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/cart.php';
    
    $database = new Database();
    $db = $database->getDb();
    $cart = new Cart($db);

    $data = json_decode(file_get_contents("php://input"));

    $cart->userId    = $data->user    ;
    $cart->productId = $data->product ;
    $cart->quantity  = $data->quantity;

    $cart->getSingleProduct();

    if($cart->productId == null){

        $cart->userId    = $data->user    ;
        $cart->productId = $data->product ;
        $cart->quantity  = $data->quantity;

        if($cart->addNewProduct()){
            http_response_code(201);
            echo json_encode(
                array("message" => "Product added to cart successfully.")
            );
        } else{
            http_response_code(400);
            echo json_encode(
                array("message" => "Product could not be added to cart.")
            );
        }
    }else{
      $cart->quantity  += $data->quantity;

      if($cart->updateProductQuantity()){
        http_response_code(200);
        echo json_encode(
          array("message" => "Product quantity updated.")
        );
      } else{
          http_response_code(400);
          echo json_encode(
            array("message" => "Data could not be updated.")
          );
      }
    }
    
    
?>