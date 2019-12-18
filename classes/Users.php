<?php

class Users{

  // define properties

  public $product_id;
  public $product_name;
  public $product_details;
  public $product_stock;
  public $product_unit_id;
  public $product_shop_id;
  public $product_shop_user_id;
  public $product_discount;
  public $product_sell_price;
  public $product_supplier_price;
  public $product_status;
  public $product_created;
  public $product_supplier_id;
  public $product_code;
  public $product_image;
  public $product_category_type_id;
  public $purchase_name;
  public $purchase_details;
  public $purchase_no;
  public $purchase_date;
  public $purchase_stock;
  public $purchase_item;
  public $purchase_quantity;
  public $purchase_rate;
  public $purchase_discount;
  public $purchase_total;
  public $purchase_grand_total;
  public $purchase_unit_id;
  public $purchase_shop_id;
  public $purchase_created;
  public $purchase_shop_user_id;
  public $purchase_id;
  public $supplier_shop_id;
  public $supplier_shop_user_id;
  public $supplier_address;
  public $supplier_email;
  public $supplier_contact_number;
  public $supplier_status;
  public $supplier_image;
  public $supplier_details;
  public $supplier_name;
  public $supplier_id;
  public $supplier_created;
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
  public $user_image;
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
  private $supplier_tbl;
  private $unit_tbl;
  private $product_tbl;
  private $purchase_tbl;


  public function __construct($db){
     $this->conn = $db;
     $this->users_tbl = "shopusers";
     $this->customer_users_tbl = "customer";
     $this->shop_tbl = "shop";
     $this->projects_tbl = "tbl_projects";
     $this->product_type_tbl = "product_category_type";
     $this->supplier_tbl = "supplier";
     $this->unit_tbl = "unit";
     $this->product_tbl = "product";
     $this->purchase_tbl = "purchase";
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

        $customer_query = "INSERT INTO ".$this->customer_users_tbl." SET Name = ?, Email = ?, Password = ?, MobileNumber =?, Address =?,CreatedBy =?, Status =?, Picture=?, Created=?";

        $customer_obj = $this->conn->prepare($customer_query);
        $customer_obj->bind_param("sssssssss", $this->customer_name, $this->customer_email,$this->customer_password, $this->customer_mobile_number, $this->customer_address, $this->user_id, $this->customer_status, $this->customer_picture, $this->customer_created);

        if($customer_obj->execute()){
            return true;

        }
        else{

            return false;
        }

        return false;
    }
    public function create_purchase(){

        $purchase_query = "INSERT INTO ".$this->purchase_tbl." SET ProductName = ?, ProductDetails = ?, PurchaseNo = ?, PurchaseDate =?, Stock =?,Item =?, Quantity =?, Rate=?, Discount=?, Total =?,GrandTotal =?, UnitId =?, ShopId=?, Created=?,ShopUserId=?";

        $purchase_obj = $this->conn->prepare($purchase_query);
        $purchase_obj->bind_param("sssssssssssssss", $this->purchase_name, $this->purchase_details,$this->purchase_no, $this->purchase_date, $this->purchase_stock, $this->purchase_item, $this->purchase_quantity, $this->purchase_rate, $this->purchase_discount, $this->purchase_total, $this->purchase_grand_total, $this->purchase_unit_id, $this->purchase_shop_id, $this->purchase_created, $this->purchase_shop_user_id);

        if($purchase_obj->execute()){
            return true;

        }
        else{

            return false;
        }

        return false;
    }
    public function create_product(){

        $product_query = "INSERT INTO ".$this->product_tbl." SET Name = ?, Details = ?, ProductCode = ?, ProductImage =?, SellPrice =?,SupplierPrice =?, SupplierId =?, Status=?, Discounts=?, Created =?,UnitId =?, Stock =?, ShopId=?, ProductCategoryId=?,ShopUserId=?";


        $product_obj = $this->conn->prepare($product_query);

        $product_obj->bind_param("sssssssssssssss", $this->product_name, $this->product_details,$this->product_code, $this->product_image, $this->product_sell_price, $this->product_supplier_price, $this->product_supplier_id, $this->product_status, $this->product_discount, $this->product_created, $this->product_unit_id, $this->product_stock, $this->product_shop_id, $this->product_category_type_id, $this->product_shop_user_id);

        if($product_obj->execute()){
            return true;

        }
        else{

            return false;
        }

        return false;
    }
    public function create_supplier(){

        $supplier_query = "INSERT INTO ".$this->supplier_tbl." SET Name = ?, Email = ?, Address = ?, ContactNumber =?, SupplierImage =?,Details =?,ShopId=?, Created=?, ShopUserId=?,Status =?";

        $supplier_obj = $this->conn->prepare($supplier_query);

        $supplier_obj->bind_param("ssssssssss", $this->supplier_name, $this->supplier_email,$this->supplier_address, $this->supplier_contact_number, $this->supplier_image, $this->supplier_details, $this->supplier_shop_id, $this->supplier_created, $this->supplier_shop_user_id, $this->supplier_status);

        if($supplier_obj->execute()){
            return true;

        }
        else{

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


        $product_update_type_obj->bind_param("ssssss", $this->product_category_name, $this->product_category_status, $this->product_category_shop_id, $this->product_category_created, $this->product_category_shop_user_id, $this->product_shop_user_id);
        if($product_update_type_obj->execute()){
            return true;
        }
        return false;

    }
    function updateAvatar(){
        return $result=$this->conn->query("Update ".$this->users_tbl." set Picture='$this->user_image' where Id='$this->user_id'");

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
    public function update_supplier(){

        $supplier_update_type_query=("UPDATE ".$this->supplier_tbl." SET Name = ?, Email = ?, Address = ?, ContactNumber =?, SupplierImage =?,Details =?,ShopUserId=?,Status =? where Id=?");

        $supplier_update_type_obj = $this->conn->prepare($supplier_update_type_query);

        $supplier_update_type_obj->bind_param("sssssssss", $this->supplier_name, $this->supplier_email,$this->supplier_address, $this->supplier_contact_number, $this->supplier_image, $this->supplier_details,$this->supplier_shop_user_id, $this->supplier_status, $this->supplier_id);

        if($supplier_update_type_obj->execute()){
            return true;
        }
        return false;

    }
    public function update_purchase(){
        $purchase_update_type_query=("UPDATE ".$this->purchase_tbl." SET ProductName = ?, ProductDetails = ?, PurchaseNo = ?, PurchaseDate =?, Stock =?,Item =?, Quantity =?, Rate=?, Discount=?, Total =?,GrandTotal =?, UnitId =?, ShopId=?, Created=?,ShopUserId=? where Id=? AND ShopUserId=? ");


        $purchase_update_type_obj = $this->conn->prepare($purchase_update_type_query);

        $purchase_update_type_obj->bind_param("sssssssssssssssss", $this->purchase_name, $this->purchase_details,$this->purchase_no, $this->purchase_date, $this->purchase_stock, $this->purchase_item, $this->purchase_quantity, $this->purchase_rate, $this->purchase_discount, $this->purchase_total, $this->purchase_grand_total, $this->purchase_unit_id, $this->purchase_shop_id, $this->purchase_created, $this->purchase_shop_user_id, $this->purchase_id, $this->purchase_shop_user_id);

        if($purchase_update_type_obj->execute()){
            return true;
        }
        return false;

    }
    public function update_product(){
        $product_update_type_query=("UPDATE ".$this->product_tbl." SET Name = ?, Details = ?, ProductCode = ?, ProductImage =?, SellPrice =?,SupplierPrice =?, SupplierId =?, Status=?, Discounts=?, Created =?,UnitId =?, Stock =?, ShopId=?, ProductCategoryId=?,ShopUserId=? where Id=? AND ShopUserId=?");


        $product_update_type_obj = $this->conn->prepare($product_update_type_query);

        $product_update_type_obj->bind_param("sssssssssssssssss", $this->product_name, $this->product_details,$this->product_code, $this->product_image, $this->product_sell_price, $this->product_supplier_price, $this->product_supplier_id, $this->product_status, $this->product_discount, $this->product_created, $this->product_unit_id, $this->product_stock, $this->product_shop_id, $this->product_category_type_id, $this->product_shop_user_id, $this->product_id, $this->product_shop_user_id);

        if($product_update_type_obj->execute()){
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
    public function delete_supplier(){
        $supplier_delete_type_query = "DELETE FROM ".$this->supplier_tbl."  Where Id=? and ShopUserId=? ";
        $supplier_delete_type_obj = $this->conn->prepare($supplier_delete_type_query);


        $supplier_delete_type_obj->bind_param("ss",  $this->supplier_id, $this->supplier_shop_user_id);
        if($supplier_delete_type_obj->execute()){
            return true;
        }
        return false;

    }
    public function delete_purchase(){
        $purchase_delete_type_query = "DELETE FROM ".$this->purchase_tbl."  Where Id=? and ShopUserId=? ";
        $purchase_delete_type_obj = $this->conn->prepare($purchase_delete_type_query);


        $purchase_delete_type_obj->bind_param("ss",  $this->purchase_id, $this->purchase_shop_user_id);
        if($purchase_delete_type_obj->execute()){
            return true;
        }
        return false;

    }
    public function delete_product(){
        $purchase_delete_type_query = "DELETE FROM ".$this->product_tbl."  Where Id=? and ShopUserId=? ";
        $purchase_delete_type_obj = $this->conn->prepare($purchase_delete_type_query);


        $purchase_delete_type_obj->bind_param("ss",  $this->product_id, $this->product_shop_user_id);
        if($purchase_delete_type_obj->execute()){
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
    public function getUnit(){


        $result= $this->conn->query("Select * from unit");
        $units=array();
        while ($item=$result->fetch_assoc())
            $units[]=$item;
        return $units;


    }
    public function getProductCategoryType(){

        $categorys_query=("Select * from product_category_type where  ShopUserId=?");

        $categorys_query_obj = $this->conn->prepare($categorys_query);

        $categorys_query_obj->bind_param("s",$this->user_id);
        $units=array();
        if($categorys_query_obj->execute()){
            $data = $categorys_query_obj->get_result();

            while ($item=$data->fetch_assoc())
                $units[]=$item;
            return $units;
        }





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
    public function check_product(){

        $product_query = "SELECT * from ".$this->product_tbl." WHERE Name = ?";
        $product_obj = $this->conn->prepare($product_query);
        $product_obj->bind_param("s", $this->product_name);

        if($product_obj->execute()){

            $data = $product_obj->get_result();

            return $data->fetch_assoc();
        }

        return array();
    }
    public function check_purchase(){

        $email_query = "SELECT * from ".$this->purchase_tbl." WHERE ProductName = ? ";
        $usr_obj = $this->conn->prepare($email_query);
        $usr_obj->bind_param("s", $this->purchase_name);

        if($usr_obj->execute()){

            $data = $usr_obj->get_result();

            return $data->fetch_assoc();
        }

        return array();
    }
    public function check_email_supplier(){

        $email_query = "SELECT * from ".$this->supplier_tbl." WHERE (Email = ? ) OR ( ContactNumber = ?)";
        $usr_obj = $this->conn->prepare($email_query);
        $usr_obj->bind_param("ss", $this->supplier_email, $this->supplier_contact_number);

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
