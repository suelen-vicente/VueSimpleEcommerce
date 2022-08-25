<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/comments.php';
    include_once '../../class/user.php';
    include_once '../../class/product.php';
    
    $database = new Database();
    $db = $database->getDb();
    $comments = new Comments($db);
    $userObj = new User($db);
    $productObj = new Product($db);
    
    if(isset($_GET['user'])){
        $comments->user = $_GET['user'];
        $result = $comments->getCommentsByUser();
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

        $userObj->id = $_GET['user'];
        $userObj->getSingleUser();

        $commentsArr["user"] = $userObj;

        $commentsArr["comments"] = array();
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $productObj->id = $product;
            $productObj->getSingleProduct();

            $e = array(
                "product"    => $productObj ,
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