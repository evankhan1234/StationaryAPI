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

    if(!empty($data->ProductName)){

        try{

            $jwt = $headers["Authorization"];

            $secret_key = "owt125";

            $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));
            $user_obj->purchase_shop_user_id = $decoded_data->data->Id;
            $user_obj->purchase_id = $data->Id;
            $user_obj->purchase_name = $data->ProductName;
            $user_obj->purchase_details = $data->ProductDetails;
            $user_obj->purchase_no = $data->PurchaseNo;
            $user_obj->purchase_date = $data->PurchaseDate;
            $user_obj->purchase_item = $data->Item;
            $user_obj->purchase_quantity = $data->Quantity;
            $user_obj->purchase_discount = $data->Discount;
            $user_obj->purchase_rate = $data->Rate;
            $user_obj->purchase_total = $data->Total;
            $user_obj->purchase_grand_total = $data->GrandTotal;
            $user_obj->purchase_unit_id = $data->UnitId;
            $user_obj->purchase_shop_id = $data->ShopId;
            $user_obj->purchase_stock = $data->Stock;
            $user_obj->purchase_created = $data->Created;

            if($user_obj->update_purchase()){

                http_response_code(200); // ok
                echo json_encode(array(
                    "status" => 200,
                    "success" => true,
                    "message" => "Purchase Updated SuccessFully"
                ));
            }else{

                http_response_code(500); //server error
                echo json_encode(array(

                    "status" => 500,
                    "success" => false,
                    "message" => "Failed to Updated Purchase "
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
