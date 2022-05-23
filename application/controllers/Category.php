<?php

class Category extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model("app_model");
  }

   public function index(){
      echo "This is sample message from Category Controller";
   }

   public function list_categories(){

     if($this->session->userdata("is_active") == 1){

       $categories = $this->app_model->get_resource_data(tbl_categories());

       $data = array(
         "page_content" => "pages/list-categories",
         "categories" => $categories
       );
       $this->load->view("layout/main_layout",$data);
     }else{
        $this->load->view("pages/login");
     }
   }

}

 ?>
