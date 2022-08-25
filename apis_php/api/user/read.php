<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/user.php';
    
    $database = new Database();
    $db = $database->getDb();
    $user = new User($db);
    
    if(isset($_GET['id'])){
        $user->id = $_GET['id'];
        $user->getSingleUser();
        $itemCount = $user->name != null ? 1 : 0;
    }else{
        $result = $user->getUsers();
        $itemCount = $result->rowCount();
    }
    
    if($itemCount > 0){
        $userArr = array();
        $userArr["itemCount"] = $itemCount;
        $userArr["body"] = array();
        if(isset($_GET['id'])){
            $e = array(
                "id"               => $user->id,
                "name"             => $user->name,
                "email"            => $user->email,
                "password"         => $user->password,
                "shipping_address" => $user->shipping_address
            );
            array_push($userArr["body"], $e);
        }else{
            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $e = array(
                    "id"               => $id,
                    "name"             => $name,
                    "email"            => $email,
                    "password"         => $password,
                    "shipping_address" => $shipping_address
                );
                array_push($userArr["body"], $e);
            }
        }
        http_response_code(200);
        echo json_encode($userArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>