<?php
//inlcude headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charst=UTF-8");

// including files
include_once("../config/database.php");
include_once("../classes/Users.php");

//objects
$db = new Database();

$connection = $db->connect();

$user_obj = new Users($connection);

if($_SERVER['REQUEST_METHOD'] === "POST"){

    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->OwnerName) && !empty($data->Email) && !empty($data->Password)){

       $user_obj->user_name = $data->OwnerName;
       $user_obj->user_email = $data->Email;
       $user_obj->agreement_date = $data->AgreementDate;
       $user_obj->user_address = $data->OwnerAddress;
       $user_obj->user_mobile = $data->OwnerMobileNumber;
       $user_obj->user_picture = $data->Picture;
       $user_obj->user_created_date = $data->Created;
       $user_obj->status = $data->Status;
       $user_obj->shop_type_id = $data->ShopTypeId;
       $user_obj->user_password = md5($data->Password);

       $email_data = $user_obj->check_email();

       if(!empty($email_data))
       {
         // some data we have - insert should not go
         http_response_code(500);
         echo json_encode(array(
           "status" => 201,
           "message" => "User already exists, try another email address or Phone Number"
         ));
       }
       else{

         if($user_obj->create_user()){

           http_response_code(200);
             $email_datas = $user_obj->check_email();
             $id=$email_datas["Id"];
             $user_obj->shop_name = $data->Name;
             $user_obj->shop_addres = $data->Address;
             $user_obj->shop_license_number = $data->LicenseNumber;
             $user_obj->shop_status = "0";
             $user_obj->shop_user_id = $id;
             if($user_obj->create_shop()){
                 echo json_encode(array(
                     "status" => 200,
                     "success" => true,
                     "message" => "User has been created",
                     "messageForShop" => "Shop Created"
                 ));
             }
         }else{

           http_response_code(500);
           echo json_encode(array(
             "status" => 500,
               "success" => false,
             "message" => "Failed to save user"
           ));
         }
       }
    }else{
      http_response_code(404);
      echo json_encode(array(
        "status" => 503,
          "success" => false,
        "message" => "All data needed"
      ));
    }
}else{

  http_response_code(503);
  echo json_encode(array(
    "status" => 0,
    "message" => "Access Denied"
  ));
}

 ?>
