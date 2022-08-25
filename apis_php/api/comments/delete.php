<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");
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
      
      if($comments->id == null){
          http_response_code(404);
          echo json_encode(
            array("message" => "Comment not found.")
          );
      }else{
          if($comments->deleteComment()){
              http_response_code(200);
              echo json_encode(
                array("message" => "Comment deleted.")
              );
          } else{
              http_response_code(400);
              echo json_encode(
                array("message" => "Data could not be deleted.")
              );
          }
      }
    }else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>