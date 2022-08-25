<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/cart.php';
    include_once '../../class/user.php';
    include_once '../../class/product.php';
    
    $database = new Database();
    $db = $database->getDb();
    $cart = new Cart($db);
    $user = new User($db);
    $productObj = new Product($db);
    
    if(isset($_GET['user'])){
        $cart->userId = $_GET['user'];
        $user->id = $_GET['user'];
        $result = $cart->getCartByUser();
        $itemCount = $result->rowCount();
    }else{
        http_response_code(400);
        echo json_encode(
            array("message" => "User id is required.")
        );
    }
    
    if($itemCount > 0){
        $cartArr = array();
        $user->getSingleUser();
        $cartArr["user"] = $user;
        $cartArr["cart"] = array();
        $cartArr["itemCount"] = $itemCount;
        $cartArr["products"] = array();

        $subTotal = 0;
        $totalShippingCost = 0;
        $taxes = 0;
        $total = 0;

        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $productObj->id = $product;
            $productObj->getSingleProduct();
            $productArray = array(
                "id" => $productObj->id,
                "name" => $productObj->name,
                "brand" => $productObj->brand,
                "image" => $productObj->image,
                "price" => $productObj->price,
                "shipping_cost" => $productObj->shipping_cost
            );

            $productSubTotal = $quantity * $productObj->price;
            $productShippingCost = $quantity * $productObj->shipping_cost;
            $productTaxes = ($productSubTotal + $productShippingCost) * 0.13;
            $productTotal = $productSubTotal + $productShippingCost + $productTaxes;

            $productResult = array(
                "quantity"                    => $quantity,
                "product_sub_total"           => $productSubTotal,
                "product_taxes"               => $productTaxes,
                "product_total_shipping_cost" => $productShippingCost,
                "product_total"               => $productTotal,
                "product"                     => $productArray
            );

            array_push($cartArr["products"], $productResult);

            $subTotal += $productSubTotal;
            $totalShippingCost += $productShippingCost;
            $taxes += $productTaxes;
            $total += $productTotal;

        }

        $cartResult = array(
            "sub_total"           => $subTotal,
            "total_shipping_cost" => $totalShippingCost,
            "taxes"               => $taxes,
            "total"               => $total
        );

        array_push($cartArr["cart"], $cartResult);

        http_response_code(200);
        echo json_encode($cartArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>