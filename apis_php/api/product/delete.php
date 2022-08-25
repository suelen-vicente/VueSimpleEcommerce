<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");
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
          if($product->deleteProduct()){
              http_response_code(200);
              echo json_encode(
                array("message" => "Product deleted.")
              );
          } else{
              http_response_code(400);
              echo json_encode(
                array("message" => "Data could not be deleted.")
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