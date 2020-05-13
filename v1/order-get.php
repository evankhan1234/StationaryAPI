<?php

ini_set("display_errors", 1);

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../classes/Users.php");

//objects
$db = new Database();

$connection = $db->connect();

$user_obj = new Users($connection);

if($_SERVER['REQUEST_METHOD'] === "GET"){

    // body
    $data = json_decode(file_get_contents("php://input"));


    $headers = getallheaders();



    try{


        $jwt = $headers["Authorization"];

        $secret_key = "owt125";

        $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));
        $user_obj->user_id = $decoded_data->data->Id;

        $orders=$user_obj->getOrders();

        if($orders){

            http_response_code(200); // ok
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "data" => $orders,
                "message" => "Orders Found"
            ));
        }else{

            http_response_code(500); //server error
            echo json_encode(array(

                "status" => 200,
                "success" => true,
                "data" => $orders,
                "message" => "No Orders Found"
            ));
        }
    }catch(Exception $ex){

        http_response_code(500); //server error
        echo json_encode(array(
            "status" => 501,
            "success" => false,
            "message" => $ex->getMessage()
        ));
    }


}

?>
