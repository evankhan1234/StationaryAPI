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

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // body
    $data = json_decode(file_get_contents("php://input"));
    json_encode($data);

    $headers = getallheaders();

    if (!empty($data->ItemCode) && !empty($data->ItemName)) {

        try {

            $jwt = $headers["Authorization"];

            $secret_key = "owt125";
            $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));

            $user_obj->system_created_by = $decoded_data->data->Id;
            $user_obj->system_item_code = $data->ItemCode;
            $user_obj->system_item_name = $data->ItemName;
            $user_obj->system_shop_type = $data->ShopType;
            $user_obj->system_sales_price = $data->SalesPrice;
            $user_obj->system_purchase_price = $data->PurchasePrice;
            $user_obj->system_item_description = $data->Description;
            $user_obj->system_picture = $data->Picture;
            $user_obj->system_unit_id = $data->UnitId;
            $user_obj->system_quantity = $data->Quantity;
            $user_obj->system_status = $data->Status;
            $user_obj->system_stock = $data->Stock;
            $user_obj->system_discount = $data->Discount;
            $user_obj->system_created = $data->Created;



            if ($user_obj->create_system_product()) {

                http_response_code(200);
                echo json_encode(array(
                    "status" => 200,
                    "success" => true,
                    "message" => "System Product has been created"

                ));
            } else {

                http_response_code(500);
                echo json_encode(array(
                    "status" => 500,
                    "success" => false,
                    "message" => "Failed to save System Product"
                ));
            }

        } catch (Exception $ex) {
            http_response_code(500); //server error
            echo json_encode(array(
                "status" => 501,
                "success" => false,
                "message" => $ex->getMessage()
            ));
        }


    }


} else {

    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}

?>
