<?php
ini_set("display_errors", 1);
// include vendor
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

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->Password)) {

        $user_obj->user_email = $data->Email;
        $user_obj->user_password = md5($data->Password);
        $user_obj->user_mobile = $data->OwnerMobileNumber;
        $user_data = $user_obj->check_login_details();
        $md5 = md5($data->Password);
        if ($user_data != null) { // normal password, hashed password
            $name = $user_data['OwnerName'];
            $email = $user_data['Email'];
            $password = $user_data['Password'];
            $iss = "localhost";
            $iat = time();
            $nbf = $iat + 10;
            $exp = $iat + 86400;
            $aud = "myusers";
            $user_arr_data = array(
                "Id" => $user_data['Id'],
                "OwnerName" => $user_data['OwnerName'],
                "Email" => $user_data['Email']
            );

            $secret_key = "owt125";

            $payload_info = array(
                "iss" => $iss,
                "iat" => $iat,
                "nbf" => $nbf,
                "exp" => $exp,
                "aud" => $aud,
                "data" => $user_arr_data
            );

            $jwt = JWT::encode($payload_info, $secret_key, 'HS512');
            $datas = $user_obj->check_email();
            $Status = $datas["Status"];
            if ($Status == 0) {
                echo json_encode(array(
                    "status" => 202,
                    "success" => false,

                    "message" => "You are not active User"
                ));
            } else {
                http_response_code(200);
                echo json_encode(array(
                    "status" => 200,
                    "success" => true,
                    "jwt" => $jwt,
                    "data" => $datas,
                    "message" => "User logged in successfully"
                ));
            }

        } else {

            http_response_code(404);
            $datas = $user_obj->check_email();
            echo json_encode(array(
                "status" => 201,
                "success" => false,

                "message" => "Invalid credentials"
            ));
        }

    } else {

        http_response_code(404);
        echo json_encode(array(
            "status" => 503,
            "success" => false,
            "message" => "All data needed"
        ));
    }
}
