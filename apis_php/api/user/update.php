<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/user.php';
    
    $database = new Database();
    $db = $database->getDb();
    $user = new User($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    if(isset($_GET['id'])){
      $user->id = $_GET['id'];
      $user->getSingleUser();
      
      if($user->name == null){
        http_response_code(404);
        echo json_encode(
          array("message" => "User not found.")
        );
      }else{
        if($data->name != null || $data->name != ""){
          $user->name = $data->name;
        }
        
        if($data->email != null || $data->email != ""){
          $user->email = $data->email;
        }
        
        if($data->password != null || $data->password != ""){
          $user->password = $data->password;
        }
        
        if($data->shipping_address != null || $data->shipping_address != ""){
          $user->shipping_address = $data->shipping_address;
        }
        
        if($user->updateUser()){
          http_response_code(200);
          echo json_encode(
            array("message" => "User data updated.")
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
        array("message" => "User not found.")
      );
    }
?>