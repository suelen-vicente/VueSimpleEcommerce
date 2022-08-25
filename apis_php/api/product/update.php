<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/product.php';
    
    $database = new Database();
    $db = $database->getDb();
    $product = new Product($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    if(isset($_GET['id'])){
      $product->id = $_GET['id'];
      $product->getSingleProduct();
      
      if($product->name == null){
        http_response_code(404);
        echo json_encode(
          array("message" => "Product not found.")
        );
      }else{
        if($data->name != null || $data->name != ""){
          $product->name = $data->name;
        }
        
        if($data->description != null || $data->description != ""){
          $product->description = $data->description;
        }
        
        if($data->image != null || $data->image != ""){
          $product->image = $data->image;
        }
        
        if($data->price != null || $data->price != ""){
          $product->price = $data->price;
        }
        
        if($data->shipping_cost != null || $data->shipping_cost != ""){
          $product->shipping_cost = $data->shipping_cost;
        }
        
        if($data->brand != null || $data->brand != ""){
          $product->brand = $data->brand;
        }
        
        if($product->updateProduct()){
          http_response_code(200);
          echo json_encode(
            array("message" => "Product data updated.")
          );
        } else{
            http_response_code(400);
            echo json_encode(
              array("message" => "Data could not be updated.")
            );
        }
      }
    }else{
      http_response_code(404);
      echo json_encode(
        array("message" => "Product not found.")
      );
    }
?>