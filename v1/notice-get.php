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

if($_SERVER['REQUEST_METHOD'] === "POST"){

    // body
    $data = json_decode(file_get_contents("php://input"));

    //  $user_obj->user_email = $data->Email;
    $headers = getallheaders();





    try{


        $jwt = $headers["Authorization"];

        $secret_key = "owt125";

        $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));
        $user_obj->notice_type= $data->Type;
        $notice=$user_obj->getNotice();

        if($notice){

            http_response_code(200); // ok
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "data" => $notice,
                "message" => "Notice Found"
            ));
        }else{

            http_response_code(200); //server error
            echo json_encode(array(

                "status" => 200,
                "success" => true,
                "data" => $notice,
                "message" => "No Notice Found"
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
