<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    //imports all classes
    include_once '../../config/database.php';
    include_once '../../class/order.php';
    include_once '../../class/cart.php';
    include_once '../../class/order_product.php';
    include_once '../../class/product.php';
    
    //instantiates all classes
    $database = new Database();
    $db = $database->getDb();
    $cart = new Cart($db);
    $order = new Order($db);
    $orderProduct = new OrderProduct($db);
    $productObj = new Product($db);

    //Checks if the user id was informed in the path
    if(isset($_GET['user'])){
      $cart->userId = $_GET['user'];
      
      //get the user cart to build the order
      $cartResult = $cart->getCartByUser();
      $itemCount = $cartResult->rowCount();
      
      //if exists any item in the cart
      if($itemCount > 0){
        
        //Sets all values that will be inserted into the Order (Sale) table
        $order->user = $cart->userId;
        
        //CREATED: Order created but with no product on it yet
        //OPEN: Order was opened and will be processed by the store
        $order->status = "CREATED";
        $order->getSingleOrderByStatusAndUser();
        
        if($order->id == null){
          $order->user = $cart->userId;
          $order->sub_total = 0;
          $order->calc_tax = 0;
          $order->shipping_total = 0;
          $order->total = 0;
          
          //Creates the order with all values setted to zero.
          $order->createOrder();
          
          //Gets the order id to add products to it
          $order->getSingleOrderByStatusAndUser();
        }
        
        //Runs all the products that exists in the cart
        while ($row = $cartResult->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          
          //Sets all the values that will be inserted into the Product Order
          $orderProduct->product = $product;
          $orderProduct->order = $order->id;
          $orderProduct->quantity = $quantity;
          
          //Researches the product to collect costing data
          $productObj->id = $product;
          $productObj->getSingleProduct();
          
          //Calculates all totals
          $orderProduct->subTotal = $quantity * $productObj->price;
          $orderProduct->shippingCost = $quantity * $productObj->shipping_cost;
          $orderProduct->taxes = ($orderProduct->sub_total + $orderProduct->shipping_cost) * 0.13;
          $orderProduct->total = $orderProduct->sub_total + $orderProduct->shipping_cost + $orderProduct->taxes; 
          
          //Add this product to the order CREATED
          $orderProduct->addProductToOrder();
          echo "here";

          //Add the totals to the order columns related to totals
          $order->sub_total += $orderProduct->sub_total;
          $order->calc_tax += $orderProduct->taxes;
          $order->shipping_total += $orderProduct->shipping_cost;
          $order->total += $orderProduct->total;
        }


        //When the order creation is finalized, it changes to OPEN
        $order->status = "OPEN";
        $order->updateOrder();

        //Clear the cart, since it turned into an order
        $cart->clearByUser();

        http_response_code(201);
        echo json_encode(
          array("message" => "Order created.")
        );

      }else{
        http_response_code(404);
        echo json_encode(
          array("message" => "Cart is empty.")
        );
      }

    }
?>