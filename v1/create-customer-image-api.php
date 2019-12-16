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

if($_SERVER['REQUEST_METHOD'] === "POST") {

    // body
    //  $data = json_decode(file_get_contents("php://input"));


    $headers = getallheaders();

    if (isset($_FILES["uploaded_file"]["name"])) {
        $name = $_FILES['uploaded_file']["name"];
        $tmp_name = $_FILES['uploaded_file']["tmp_name"];
        $error = $_FILES['uploaded_file']["error"];

        if (!empty($name)) {
            $location = "./customer_img/";
            try {
                $jwt = $headers["Authorization"];

                $secret_key = "owt125";

                $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));

                $user_obj->user_id = $decoded_data->data->Id;
                if (!is_dir($location)) {
                    mkdir($location);
                }
                if (move_uploaded_file($tmp_name, $location . $name)) {
                    $total="http://".($headers["Host"])."/bazar/v1/". $location . $name;
                    $user_obj->user_image = $total;

                    echo json_encode(array(
                        "status" => 200,
                        "success" => true,
                        "img_address" => $user_obj->user_image,
                        "message" => "User Image Uploaded SuccessFull"
                    ));

                } else {
                    http_response_code(500); //server error
                    echo json_encode(array(
                        "status" => 501,
                        "success" => false,
                        "message" =>"UserId Missing"
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
        } else {
            echo json_encode("Please select a file");
        }
    }
}
?>
