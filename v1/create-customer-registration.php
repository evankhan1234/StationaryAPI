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




    if(!empty($data->Name) && !empty($data->Password)){


            $user_obj->customer_name = $data->Name;
            $user_obj->customer_email = $data->Email;
            $user_obj->customer_picture = $data->Picture;
            $user_obj->customer_created = $data->Created;
            $user_obj->customer_address = $data->Address;
            $user_obj->customer_mobile_number = $data->MobileNumber;
            $user_obj->customer_status = $data->Status;
            $user_obj->customer_gender = $data->Gender;
            $user_obj->customer_password = md5($data->Password);

            $email_data = $user_obj->check_email_customer();

            if (!empty($email_data)) {
                // some data we have - insert should not go
                http_response_code(500);
                echo json_encode(array(
                    "status" => 201,
                    "message" => "User already exists, try another email address and mobile Number"
                ));
            } else {

                if ($user_obj->create_customer()) {

                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 200,
                        "success" => true,
                        "message" => "Customer has been created"

                    ));
                } else {

                    http_response_code(500);
                    echo json_encode(array(
                        "status" => 500,
                        "success" => false,
                        "message" => "Failed to save Customer"
                    ));
                }
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
