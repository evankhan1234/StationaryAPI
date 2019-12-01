<?php

class Users{

  // define properties
  public $customer_name;
  public $customer_mobile_number;
  public $customer_address;
  public $customer_email;
  public $customer_password;
  public $customer_created_by;
  public $customer_picture;
  public $customer_created;
  public $customer_status;
  public $user_id;
  public $user_email;
  public $user_password;
  public $user_address;
  public $user_mobile;
  public $user_picture;
  public $user_created_date;
  public $agreement_date;
  public $status;
  public $shop_type_id;
  public $shop_user_id;
  public $shop_name;
  public $product_category_name;
  public $product_category_shop_user_id;
  public $product_category_id;
  public $product_category_status;
  public $product_category_created;
  public $product_category_shop_id;
  public $shop_license_number;
  public $shop_addres;
  public $shop_status;

  private $conn;
  private $users_tbl;
  private $shop_tbl;
  private $projects_tbl;
  private $product_type_tbl;
  private $customer_users_tbl;


  public function __construct($db){
     $this->conn = $db;
     $this->users_tbl = "shopusers";
     $this->customer_users_tbl = "customer";
     $this->shop_tbl = "shop";
     $this->projects_tbl = "tbl_projects";
     $this->product_type_tbl = "product_category_type";
  }

  public function create_user(){

    $user_query = "INSERT INTO ".$this->users_tbl." SET OwnerName = ?, Email = ?, Password = ?, AgreementDate =?, OwnerAddress =?, OwnerMobileNumber =?, Status =?, ShopTypeId=?, Picture =?, Created=?";

    $user_obj = $this->conn->prepare($user_query);

    $user_obj->bind_param("ssssssssss", $this->user_name, $this->user_email, $this->user_password, $this->agreement_date, $this->user_address, $this->user_mobile, $this->status, $this->shop_type_id, $this->user_picture, $this->user_created_date);

    if($user_obj->execute()){
      return true;
    }

    return false;
  }
    public function create_customer(){

      //  $customer_query = "INSERT INTO ".$this->customer_users_tbl." SET Name = ?, Email = ?, Password = ?, MobileNumber =?, Address =?, CreatedBy =?, Status =?, Picture=?, Created=?";
        $customer_query = "INSERT INTO ".$this->customer_users_tbl." SET Name = ?, Email = ?, Password = ?, MobileNumber =?, Address =?,CreatedBy =?, Status =?, Picture=?, Created=?";

        $customer_obj = $this->conn->prepare($customer_query);



      //  $customer_obj->bind_param("sssssssss", $this->customer_name, $this->customer_email,$this->customer_password, $this->customer_mobile_number, $this->customer_address, $this->user_id, $this->customer_status, $this->customer_picture, $this->customer_created);
        $customer_obj->bind_param("sssssssss", $this->customer_name, $this->customer_email,$this->customer_password, $this->customer_mobile_number, $this->customer_address, $this->user_id, $this->customer_status, $this->customer_picture, $this->customer_created);

        if($customer_obj->execute()){
            return true;
            echo "true";
        }
        else{
            echo "false";
            return false;
        }

        return false;
    }
    public function create_shop(){

    //  echo json_encode($shop_obj);
        $shop_query = "INSERT INTO ".$this->shop_tbl." SET Name = ?, Address = ?, LicenseNumber = ?, Status =?, ShopUserId =?";

        $shop_obj = $this->conn->prepare($shop_query);

        $shop_obj->bind_param("sssss", $this->shop_name, $this->shop_addres, $this->shop_license_number, $this->shop_status, $this->shop_user_id);

        if($shop_obj->execute()){
            return true;
        }

        return false;
    }



  public function check_login(){

    $email_query = "SELECT * from ".$this->users_tbl." WHERE Email = ?";

    $usr_obj = $this->conn->prepare($email_query);

    $usr_obj->bind_param("s", $this->user_email);

    if($usr_obj->execute()){

       $data = $usr_obj->get_result();

       return $data->fetch_assoc();
    }

    return array();
  }

  // to create projects
  public function create_project(){

      $project_query = "INSERT into ".$this->projects_tbl." SET user_id = ?, name = ?, description = ?, status = ?";

      $project_obj = $this->conn->prepare($project_query);
      // sanitize input variables
      $project_name = htmlspecialchars(strip_tags($this->project_name));
      $description = htmlspecialchars(strip_tags($this->description));
      $status = htmlspecialchars(strip_tags($this->status));
      // bind parameters
      $project_obj->bind_param("isss", $this->user_id, $project_name, $description, $status);

      if($project_obj->execute()){
        return true;
      }

      return false;

  }
    public function create_product_type(){


        $product_type_query = "INSERT into ".$this->product_type_tbl." SET Name = ?, Status = ?, ShopId = ?, created = ?,ShopUserId=?";

        $product_type_obj = $this->conn->prepare($product_type_query);

        $product_type_obj->bind_param("sssss", $this->product_category_name, $this->product_category_status, $this->product_category_shop_id, $this->product_category_created, $this->product_category_shop_user_id);
        if($product_type_obj->execute()){
            return true;
        }

        return false;

    }
    public function update_product_type(){
        $product_update_type_query = "UPDATE ".$this->product_type_tbl." SET Name = ?, Status = ?, ShopId = ?, created = ?,ShopUserId=? Where Id=?";
        $product_update_type_obj = $this->conn->prepare($product_update_type_query);


        $product_update_type_obj->bind_param("ssssss", $this->product_category_name, $this->product_category_status, $this->product_category_shop_id, $this->product_category_created, $this->product_category_shop_user_id, $this->product_category_id);
        if($product_update_type_obj->execute()){
            return true;
        }
        return false;

    }
    public function update_shop_user_details(){
        $shop_user_update_type_query=("UPDATE ".$this->users_tbl." as u inner join ".$this->shop_tbl." as s on  u.Id =s.ShopUserId SET u.OwnerName=? , u.OwnerAddress=?,s.Address=? where u.Id=?");

        $shop_user_update_type_obj = $this->conn->prepare($shop_user_update_type_query);


        $shop_user_update_type_obj->bind_param("ssss", $this->user_name, $this->user_address, $this->shop_addres,$this->user_id);
        if($shop_user_update_type_obj->execute()){
            return true;
        }
        return false;

    }
    public function delete_product_type(){
        $product_delete_type_query = "DELETE FROM ".$this->product_type_tbl."  Where Id=? and ShopUserId=? ";
        $product_delete_type_obj = $this->conn->prepare($product_delete_type_query);


        $product_delete_type_obj->bind_param("ss",  $this->product_category_id, $this->product_category_shop_user_id);
        if($product_delete_type_obj->execute()){
            return true;
        }
        return false;

    }
    public function getShopUserInformation(){

        $shop_user_details_query=("Select * from ".$this->users_tbl." as u inner join ".$this->shop_tbl." as s on  u.Id =s.ShopUserId where u.Id=?");
        json_encode($shop_user_details_query);
        $shop_user_details_obj = $this->conn->prepare($shop_user_details_query);
        $shop_user_details_obj->bind_param("s",$this->user_id);
        if($shop_user_details_obj->execute()){
            $data = $shop_user_details_obj->get_result();

            return $data->fetch_assoc();
            return $data;
        }
        return NULL;


    }
    public function getShopUserStatus(){

        $shop_user_status_query=("Select * from ".$this->users_tbl." where Id=?");

        $shop_user_status_obj = $this->conn->prepare($shop_user_status_query);
        $shop_user_status_obj->bind_param("s",$this->user_id);
        if($shop_user_status_obj->execute()){
            $data = $shop_user_status_obj->get_result();

            return $data->fetch_assoc();
            return $data;
        }
        return NULL;


    }
    public function check_email(){

        //$email_query = "SELECT * from ".$this->users_tbl." WHERE Email = ?";
        $email_query = "Select * from ".$this->users_tbl." WHERE (Email = ? ) OR ( OwnerMobileNumber = ?)";


//        $email_query = "Select * from ".$this->users_tbl." WHERE
//  (Email = ? AND Password = ?) OR
//  (Password = ? AND OwnerMobileNumber = ?)";

        $usr_obj = $this->conn->prepare($email_query);
        $usr_obj->bind_param("ss", $this->user_email,$this->user_mobile);

        if($usr_obj->execute()){

            $data = $usr_obj->get_result();

            return $data->fetch_assoc();
        }

        return array();
    }
    public function check_login_details(){



        $email_query = "Select * from ".$this->users_tbl." WHERE
  (Email = ? AND Password = ?) OR
  (Password = ? AND OwnerMobileNumber = ?)";


        $usr_obj = $this->conn->prepare($email_query);

        $usr_obj->bind_param("ssss", $this->user_email,$this->user_password,$this->user_password,$this->user_mobile);

        if($usr_obj->execute()){

            $data = $usr_obj->get_result();

            return $data->fetch_assoc();
        }

        return array();
    }
    public function check_email_customer(){

        $email_query = "SELECT * from ".$this->customer_users_tbl." WHERE (Email = ? ) OR ( MobileNumber = ?)";
        $usr_obj = $this->conn->prepare($email_query);
        $usr_obj->bind_param("ss", $this->customer_email, $this->customer_mobile_number);

        if($usr_obj->execute()){

            $data = $usr_obj->get_result();

            return $data->fetch_assoc();
        }

        return array();
    }
//    public function check_emails(){
//
//        $email_query=("Select * from ".$this->users_tbl." as u inner join ".$this->shop_tbl." as s on  u.Id =s.ShopUserId where u.Id=?");
//        echo json_encode($email_query);
//        $email_querys=("Select * from shopusers as u where u.Id=?");
//
//        $usr_obj = $this->conn->prepare($email_query);
//        $usr_obj->bind_param("s", $this->user_id);
//
//        if($usr_obj->execute()){
//
//            $data = $usr_obj->get_result();
//
//            return $data->fetch_assoc();
//        }
//
//        return array();
//    }
    public function update_shop_user_password(){

        $shop_user_update_type_query = "UPDATE ".$this->users_tbl." SET OwnerName = ? Where Id=? AND OwnerMobileNumber=?";
        $shop_user_update_type_obj = $this->conn->prepare($shop_user_update_type_query);


        $shop_user_update_type_obj->bind_param("sss", $this->user_password, $this->user_id, $this->user_mobile);
        if($shop_user_update_type_obj->execute()){
            return true;
        }
        return false;

    }

}

 ?>
