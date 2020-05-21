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

    if(!empty($data->ProductId) && !empty($data->ShopUserId)){

        try{

            $jwt = $headers["Authorization"];

            $secret_key = "owt125";

            $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));
            $user_obj->wish_list_customer_id = $decoded_data->data->Id;

            $user_obj->wish_list_product_id = $data->ProductId;
            $user_obj->wish_list_status = $data->Status;
            $user_obj->wish_list_shop_user_id= $data->ShopUserId;
            $user_obj->wish_list_created = $data->Created;
            $email_data = $user_obj->check_wish_list();
            if (!empty($email_data))
            {
                // some data we have - insert should not go
                http_response_code(500);
                echo json_encode(array(
                    "status" => 201,
                    "message" => "WishList already exists"
                ));
            } else {

                if ($user_obj->create_wish_list()) {

                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 200,
                        "success" => true,
                        "message" => "WishList  has been created"

                    ));
                } else {

                    http_response_code(500);
                    echo json_encode(array(
                        "status" => 500,
                        "success" => false,
                        "message" => "Failed to save WishList"
                    ));
                }
            }
        }catch(Exception $ex){

            http_response_code(500); //server error
            echo json_encode(array(
                "status" => 501,
                "success" => false,
                "message" => $ex->getMessage()
            ));
        }
    }else{

        http_response_code(404); // not found
        echo json_encode(array(
            "status" => 503,
            "success" => false,
            "message" => "All data needed"
        ));
    }
}

?>
