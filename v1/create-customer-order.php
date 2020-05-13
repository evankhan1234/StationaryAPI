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
    $headers = getallheaders();
    try {
        $jwt = $headers["Authorization"];
        $secret_key = "owt125";
        $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));
       // $user_obj->order_customer_id = $decoded_data->data->Id;
        $user_obj->order_customer_id = $data->CustomerId;
        $user_obj->order_shop_id = $data->ShopId;
        $user_obj->order_created = $data->Created;
        $user_obj->order_status = $data->Status;
        $user_obj->order_address = $data->OrderAddress;
        $user_obj->order_area = $data->OrderArea;
        $user_obj->order_latitude = $data->OrderLatitude;
        $user_obj->order_longitude = $data->OrderLongitude;
        if ($user_obj->create_order())
        {
            $datas = $user_obj->check_order();
            $id=$datas["Id"];
            $user_obj->create_order_details();
            foreach ($data->data as $val)
            {
                $user_obj->order_id = $id;
                $user_obj->order_details_created = $val->Created;
                $user_obj->order_details_name = $val->Name;
                $user_obj->order_details_quantity = $val->Quantity;
                $user_obj->order_details_price = $val->Price;
                $user_obj->order_details_product_id = $val->ProductId;
                $user_obj->order_details_item = $val->Item;
                $user_obj->order_details_status = $val->OrderStatus;
                $user_obj->order_details_shop_id = $val->ShopId;
                $user_obj->order_details_picture = $val->Picture;
                $user_obj->order_details_customer_id = $data->CustomerId;;
                if($user_obj->create_order_details()){
                }
            }
            http_response_code(200);
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "message" => "Order  has been created"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array(
                "status" => 500,
                "success" => false,
                "message" => "Failed to save Order"
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
?>