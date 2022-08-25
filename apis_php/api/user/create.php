<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/user.php';
    
    $database = new Database();
    $db = $database->getDb();
    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    $user->id               = $data->id               ;
    $user->name             = $data->name             ;
    $user->email            = $data->email            ;
    $user->password         = $data->password         ;
    $user->shipping_address = $data->shipping_address ;
    
    if($user->createUser()){
        http_response_code(201);
        echo json_encode(
            array("message" => "User created successfully.")
        );
    } else{
        http_response_code(400);
        echo json_encode(
            array("message" => "User could not be create.")
        );
    }
?>