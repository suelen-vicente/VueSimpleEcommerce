<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/comments.php';
    include_once '../../class/product.php';
    include_once '../../class/user.php';
    
    $database = new Database();
    $db = $database->getDb();
    $comments = new Comments($db);
    $productObj = new Product($db);
    $userObj = new User($db);
    
    if(isset($_GET['product'])){
        $comments->product = $_GET['product'];
        $result = $comments->getCommentsByProduct();
        $itemCount = $result->rowCount();
    }else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
    
    if($itemCount > 0){
        $commentsArr = array();
        $commentsArr["itemCount"] = $itemCount;

        
        $productObj->id = $comments->product;
        $productObj->getSingleProduct();
        $commentsArr["product"] = $productObj;
        
        $commentsArr["comments"] = array();
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $userObj->id = $user;
            $userObj->getSingleUser();

            $e = array(
                "user"       => $userObj    ,
                "comment_id" => $id         ,
                "rating"     => $rating     ,
                "image"      => $image      ,
                "text"       => $text    
            );

            array_push($commentsArr["comments"], $e);
        }
        
        http_response_code(200);
        echo json_encode($commentsArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>