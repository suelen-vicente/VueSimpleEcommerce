<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/comments.php';
    
    $database = new Database();
    $db = $database->getDb();
    $comments = new Comments($db);

    $data = json_decode(file_get_contents("php://input"));

    $comments->product  = $data->product ;
    $comments->user     = $data->user    ;
    $comments->rating   = $data->rating  ;
    $comments->image    = $data->image   ;
    $comments->text     = $data->text    ;

    if($comments->createComment()){
        http_response_code(201);
        echo json_encode(
            array("message" => "Comment created successfully.")
        );
    } else{
        http_response_code(400);
        echo json_encode(
            array("message" => "Comment could not be create.")
        );
    }
?>