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

    echo json_encode($data);
    $headers = getallheaders();

    if(!empty($data->Name) ){

        try{

            $jwt = $headers["Authorization"];
            echo json_encode($jwt);

            $secret_key = "owt125";

            $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));
            $user_obj->product_category_shop_user_id = $decoded_data->data->Id;
            $user_obj->product_category_name = $data->Name;
            $user_obj->product_category_status = $data->Status;
            $user_obj->product_category_shop_id= $data->ShopId;
            $user_obj->product_category_created = $data->created;
            $user_obj->product_category_id = $data->Id;

            if($user_obj->update_product_type()){

                http_response_code(200); // ok
                echo json_encode(array(
                    "status" => 200,
                    "success" => true,
                    "message" => "Product Category Updated SuccessFull"
                ));
            }else{

                http_response_code(500); //server error
                echo json_encode(array(

                    "status" => 500,
                    "success" => false,
                    "message" => "Failed to Updated Product Category"
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
