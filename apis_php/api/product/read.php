<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/product.php';
    
    $database = new Database();
    $db = $database->getDb();
    $product = new Product($db);
    
    if(isset($_GET['id'])){
        $product->id = $_GET['id'];
        $product->getSingleProduct();
        $itemCount = $product->name != null ? 1 : 0;
    }else{
        $result = $product->getProducts();
        $itemCount = $result->rowCount();
    }
    
    if($itemCount > 0){
        $productArr = array();
        $productArr["itemCount"] = $itemCount;
        $productArr["body"] = array();
        if(isset($_GET['id'])){
            $e = array(
                "id"            => $product->id,
                "name"          => $product->name,
                "description"   => $product->description,
                "image"         => $product->image,
                "price"         => $product->price,
                "shipping_cost" => $product->shipping_cost,
                "brand"         => $product->brand
            );
            array_push($productArr["body"], $e);
        }else{
            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $e = array(
                    "id" => $id,
                    "name" => $name,
                    "description" => $description,
                    "image" => $image,
                    "price" => $price,
                    "shipping_cost" => $shipping_cost,
                    "brand" => $brand
                );
                array_push($productArr["body"], $e);
            }
        }
        http_response_code(200);
        echo json_encode($productArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>