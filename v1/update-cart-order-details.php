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



    try{

        $jwt = $headers["Authorization"];

        $secret_key = "owt125";

        $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));

        foreach ($data->data as $val) {
            $user_obj->cart_list_customer_id = $decoded_data->data->Id;
            $user_obj->cart_list_shop_user_id= $val->ShopUserId;
            $user_obj->cart_list_product_id= $val->ProductId;
            $user_obj->cart_list_status= $val->Status;

            if ($user_obj->update_cart_order_status_details()) {
            }
        }
        http_response_code(200); // ok
        echo json_encode(array(
            "status" => 200,
            "success" => true,
            "message" => "Cart Updated SuccessFull"
        ));
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
