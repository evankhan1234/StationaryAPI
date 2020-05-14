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


    if(!empty($data->InvoiceNumber) && !empty($data->OrderId) && !empty($data->CustomerId))
    {


        try{

            $jwt = $headers["Authorization"];

            $secret_key = "owt125";
            $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));
            $user_obj->orders_shop_id = $decoded_data->data->Id;
            $user_obj->orders_customer_id = $data->CustomerId;
            $user_obj->orders_order_id = $data->OrderId;
            $user_obj->orders_discount = $data->Discount;
            $user_obj->orders_grand_total = $data->GrandTotal;
            $user_obj->orders_paid_amount = $data->PaidAmount;
            $user_obj->orders_due_amount = $data->DueAmount;
            $user_obj->orders_total = $data->Total;
            $user_obj->orders_invoice_number = $data->InvoiceNumber;
            $user_obj->orders_orders_details = $data->OrderDetails;
            $user_obj->orders_created = $data->Created;
            $user_obj->orders_delivery_charge = $data->DeliveryCharge;
            $user_obj->orders_status = $data->Status;

            $delivery_data = $user_obj->check_delivery();

            if (!empty($delivery_data))
            {
                // some data we have - insert should not go
                http_response_code(500);
                echo json_encode(array(
                    "status" => 201,
                    "message" => "Delivery already exists"
                ));
            } else {

                if ($user_obj->create_delivery()) {

                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 200,
                        "success" => true,
                        "message" => "Delivery has been Successful"

                    ));
                } else {

                    http_response_code(500);
                    echo json_encode(array(
                        "status" => 500,
                        "success" => false,
                        "message" => "Failed to Delivery"
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
