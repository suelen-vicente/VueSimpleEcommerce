<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/comments.php';
    
    $database = new Database();
    $db = $database->getDb();
    $comments = new Comments($db);
    
    if(isset($_GET['id'])){
        $comments->id = $_GET['id'];
        $comments->getSingleComment();
        $itemCount = $comments->id != null ? 1 : 0;
    }else{
        $result = $comments->getComments();
        $itemCount = $result->rowCount();
    }
    
    if($itemCount > 0){
        $commentsArr = array();
        $commentsArr["itemCount"] = $itemCount;
        $commentsArr["body"] = array();
        
        if(isset($_GET['id'])){
            $e = array(
                "id"       => $comments->id      ,
                "product"  => $comments->product ,
                "user"     => $comments->user    ,
                "rating"   => $comments->rating  ,
                "image"    => $comments->image   ,
                "text"     => $comments->text    
            );
            array_push($commentsArr["body"], $e);
        }else{
            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $e = array(
                    "id"       => $id      ,
                    "product"  => $product ,
                    "user"     => $user    ,
                    "rating"   => $rating  ,
                    "image"    => $image   ,
                    "text"     => $text    
                );
                array_push($commentsArr["body"], $e);
            }
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