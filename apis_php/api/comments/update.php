<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/comments.php';
    
    $database = new Database();
    $db = $database->getDb();
    $comment = new Comments($db);
    
    $data = json_decode(file_get_contents("php://input"));

    if(isset($_GET['id'])){
      $comment->id = $_GET['id'];
      $comment->getSingleComment();

      if($comment->id == null){
        http_response_code(404);
        echo json_encode(
          array("message" => "Comment not found.")
        );
      }else{
        
        if($data->rating != null || $data->rating != ""){
          $comment->rating = $data->rating;
        }
        
        if($data->image != null || $data->image != ""){
          $comment->image = $data->image;
        }
        
        if($data->text != null || $data->text != ""){
          $comment->text = $data->text;
        }
        
        if($comment->updateComment()){
          http_response_code(200);
          echo json_encode(
            array("message" => "Comment data updated.")
          );
        } else{
            http_response_code(400);
            echo json_encode(
              array("message" => "Data could not be updated.")
            );
        }
      }
    }else{
      http_response_code(404);
      echo json_encode(
        array("message" => "Comment not found.")
      );
    }
?>