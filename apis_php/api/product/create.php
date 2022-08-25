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

    $product->id            = $data->id           ;
    $product->name          = $data->name         ;
    $product->description   = $data->description  ;
    $product->image         = $data->image        ;
    $product->price         = $data->price        ;
    $product->shipping_cost = $data->shipping_cost;
    $product->brand         = $data->brand        ;
    
    if($product->createProduct()){
        http_response_code(201);
        echo json_encode(
            array("message" => "Product created successfully.")
        );
    } else{
        http_response_code(400);
        echo json_encode(
            array("message" => "Product could not be created.")
        );
    }
?>