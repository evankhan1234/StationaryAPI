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


    $headers = getallheaders();


    if(!empty($data->Data)){

        try{

            $jwt = $headers["Authorization"];

            $secret_key = "owt125";
            $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));

            $user_obj->token_user_id = $decoded_data->data->Id;
            $user_obj->token_type = $data->Type;
            $user_obj->token_data = $data->Data;


            $token_data = $user_obj->check_token();

            if (!empty($token_data)) {
                // some data we have - insert should not go
                $user_obj->update_token();
                http_response_code(200);
                echo json_encode(array(
                    "status" => 200,
                    "success" => true,
                    "message" => "Token Update Successful"

                ));
            } else {

                if ($user_obj->create_token()) {

                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 200,
                        "success" => true,
                        "message" => "Token has been created"

                    ));
                } else {

                    http_response_code(500);
                    echo json_encode(array(
                        "status" => 500,
                        "success" => false,
                        "message" => "Failed to save Token"
                    ));
                }
            }
        }catch (Exception $ex){
            http_response_code(500); //server error
            echo json_encode(array(
                "status" => 501,
                "success" => false,
                "message" => $ex->getMessage()
            ));
        }


    }


}else{

    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}

?>
