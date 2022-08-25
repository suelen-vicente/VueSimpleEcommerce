<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    //imports all classes
    include_once '../../config/database.php';
    include_once '../../class/order.php';
    include_once '../../class/user.php';
    include_once '../../class/order_product.php';
    include_once '../../class/product.php';
    
    //instantiates all classes
    $database = new Database();
    $db = $database->getDb();
    $user = new User($db);
    $order = new Order($db);
    $orderProduct = new OrderProduct($db);
    $productObj = new Product($db);

    //Checks if the user id was informed in the path
    if(isset($_GET['user'])){
      $order->user = $_GET['user'];
      $orderResult = $order->getOrderByUser();
      $itemCount = $orderResult->rowCount();
    }else{
      http_response_code(400);
      echo json_encode(
        array("message" => "User id is required.")
      );
    }
    
    //if exists any product in the order
    if($itemCount > 0){
      $orderArr = array();
      $user->id = $order->user;
      $user->getSingleUser();

      $orderArr["user"] = $user;
      $orderArr["itemCount"] = $itemCount;
      $orderArr["orders"] = array();

      while ($row = $orderResult->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $orderProduct->order = $id;
        $orderProductResult = $orderProduct->getProductsByOrder();

        $productsArr = array();
        
        while ($row = $orderProductResult->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $productObj->id = $product;
          $productObj->getSingleProduct();
          
          $productResult = array(
              "quantity"      => $quantity,
              "sub_total"     => $sub_total,
              "shipping_cost" => $shipping_cost,
              "taxes"         => $taxes,
              "total"         => $total,
              "product"       => $productObj
          );
  
          array_push($productsArr, $productResult);
        }

        $orderJson = array(
          "id" => $id,
          "status" => $status,
          "sub_total" => $sub_total,
          "calc_tax" => $calc_tax,
          "shipping_total" => $shipping_total,
          "total" => $total,
          "products" => $productsArr
        );

        array_push($orderArr["orders"], $orderJson);

      }

      
      http_response_code(200);
      echo json_encode($orderArr);

    }else{
      http_response_code(404);
      echo json_encode(
          array("message" => "No record found.")
      );  
    }
?>