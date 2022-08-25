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

    //Checks if id was informed in the path
    if(isset($_GET['id'])){
      $order->id = $_GET['id'];
      $order->getSingleOrder();
      $itemCount = $order->id != null ? 1 : 0;
    }else{
      http_response_code(400);
      echo json_encode(
        array("message" => "Id is required.")
      );
    }
    
    if($itemCount > 0){
      $orderArr = array();
      $user->id = $order->user;
      $user->getSingleUser();

      $orderArr["itemCount"] = $itemCount;
      $orderArr["user"] = $user;
      
      $orderProduct->order = $order->id;
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
        "details" => $order,
        "products" => $productsArr
      );

      $orderArr["order"] = $orderJson;
      
      http_response_code(200);
      echo json_encode($orderArr);

    }else{
      http_response_code(404);
      echo json_encode(
          array("message" => "No record found.")
      );  
    }
?>