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
    json_encode($data);

    $headers = getallheaders();

    if(!empty($data->Name) && !empty($data->ContactNumber)){

        try{

            $jwt = $headers["Authorization"];

            $secret_key = "owt125";
            $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));

            $user_obj->supplier_shop_user_id = $decoded_data->data->Id;
            $user_obj->supplier_name = $data->Name;
            $user_obj->supplier_email = $data->Email;
            $user_obj->supplier_image = $data->SupplierImage;
            $user_obj->supplier_created = $data->Created;
            $user_obj->supplier_address = $data->Address;
            $user_obj->supplier_contact_number = $data->ContactNumber;
            $user_obj->supplier_status = $data->Status;
            $user_obj->supplier_details = $data->Details;
            $user_obj->supplier_shop_id = $data->ShopId;


            $email_data = $user_obj->check_email_supplier();


            if (!empty($email_data)) {
                // some data we have - insert should not go
                http_response_code(500);
                echo json_encode(array(
                    "status" => 201,
                    "message" => "User already exists, try another email address and mobile number"
                ));
            } else {

                if ($user_obj->create_supplier()) {

                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 200,
                        "success" => true,
                        "message" => "Supplier has been created"

                    ));
                } else {

                    http_response_code(500);
                    echo json_encode(array(
                        "status" => 500,
                        "success" => false,
                        "message" => "Failed to save Supplier"
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
