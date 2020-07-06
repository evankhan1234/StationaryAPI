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

    if(!empty($data->Name)){

        try{

            $jwt = $headers["Authorization"];

            $secret_key = "owt125";

            $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));
            $user_obj->product_shop_user_id = $decoded_data->data->Id;
            $user_obj->product_name = $data->Name;
            $user_obj->product_details = $data->Details;
            $user_obj->product_code = $data->ProductCode;
            $user_obj->product_image = $data->ProductImage;
            $user_obj->product_sell_price= $data->SellPrice;
            $user_obj->product_supplier_price = $data->SupplierPrice;
            $user_obj->product_discount = $data->Discounts;
            $user_obj->product_unit_id = $data->UnitId;
            $user_obj->product_shop_id = $data->ShopId;
            $user_obj->product_stock = $data->Stock;
            $user_obj->product_created = $data->Created;
            $user_obj->product_status = $data->Status;
            $user_obj->product_category_type_id = $data->ProductCategoryId;
            $user_obj->product_id = $data->Id;

            if($user_obj->update_product()){

                http_response_code(200); // ok
                echo json_encode(array(
                    "status" => 200,
                    "success" => true,
                    "message" => "Product Updated SuccessFully"
                ));
            }else{

                http_response_code(500); //server error
                echo json_encode(array(

                    "status" => 500,
                    "success" => false,
                    "message" => "Failed to Updated Product "
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
