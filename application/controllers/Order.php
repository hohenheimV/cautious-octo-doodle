<?php

class Order extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model("app_model");
  }

   public function index(){
      echo "This is sample message from Order Controller";
   }

   public function list_orders($report = ""){

     if($this->session->userdata("is_active") == 1){

       $rpt = 0;
       if(!empty($report)){
         $rpt = 1;
       }

       $buyers = $this->app_model->get_resource_data(tbl_buyers());

       $data = array(
         "page_content" => "pages/list-orders",
         "buyers" => $buyers,
         "order_controller" => $this,
         "report" => $rpt
       );
       $this->load->view("layout/main_layout",$data);
     }else{
        $this->load->view("pages/login");
     }
   }

   public function invoice_detail_page_layout($buyer_id){

     if($this->session->userdata("is_active") == 1){

       $buyer = $this->app_model->get_resource_data(tbl_buyers(),array("status" => 1,"id" => $buyer_id));
       $buyer = isset($buyer[0]) ? $buyer[0] : array();
       $products = $this->app_model->get_order_products_list($buyer_id);

       $data = array(
         "page_content" => "pages/invoice-details",
         "buyer" => $buyer,
         "products" => $products
       );
       $this->load->view("layout/main_layout",$data);
     }else{
        $this->load->view("pages/login");
     }
   }

   public function get_buyer_product_info($buyer_id){

     return $this->app_model->get_order_products($buyer_id);
   }

   public function add_order_layout(){

     if($this->session->userdata("is_active") == 1){

       $categories = $this->app_model->get_resource_data(tbl_categories(),array("status" => 1));

       $data = array(
         "page_content" => "pages/add-order",
         "categories" => $categories
       );
       $this->load->view("layout/main_layout",$data);
     }else{
        $this->load->view("pages/login");
     }
   }

   public function submit_created_order(){
       //print_r($this->input->post());
       $email = $this->input->post("txt_email");
       $name = $this->input->post("txt_name");
       $number = $this->input->post("txt_number");
       $address = $this->input->post("txt_address");
       $discount = $this->input->post("txt_discount");
       $pay_mode = $this->input->post("dd_payment_mode");
       $status = $this->input->post("dd_status");

       $products = $this->input->post("dd_order_product");
       $quantity = $this->input->post("txt_quantity");
       $amount_arr = $this->input->post("txt_order_amount");

       $buyer_information = array(
         "name" => $name,
         "email" => $email,
         "address" => $address,
         "mobile" => $number,
         "discount_percentage" => $discount,
         "payment_mode" => $pay_mode,
         "status" => $status
       );

       $buyer_id = $this->app_model->buyer_information_data(tbl_buyers(),$buyer_information);

       if($buyer_id > 0){

           $products_array = array();

           if(count($products) > 0){

             foreach($products as $index => $product){

               $products_array[] = array(
                 "buyer_id" => $buyer_id,
                 "product_id" => $product,
                 "quantity" => $quantity[$index],
                 "total_amount" => $amount_arr[$index],
                 "status" => $status,
               );
             }

             if($this->app_model->save_orders(tbl_orders(),$products_array)){

               $this->session->set_flashdata("success","Order has been created");
             }else{

               $this->session->set_flashdata("error","Failed to create order");
             }

             return redirect("admin/order/add-order");
           }
       }
   }

}

 ?>
