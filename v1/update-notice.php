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



    if(!empty($data->Title) && !empty($data->Content)){


        $user_obj->notice_id = $data->Id;
        $user_obj->notice_title = $data->Title;
        $user_obj->notice_body = $data->Content;
        $user_obj->notice_image= $data->Picture;
        $user_obj->notice_created = $data->Created;


        if($user_obj->update_notice()){

            http_response_code(200); // ok
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "message" => "Notice has been updated"
            ));
        }else{

            http_response_code(500); //server error
            echo json_encode(array(

                "status" => 500,
                "success" => false,
                "message" => "Failed to update Notice"
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
