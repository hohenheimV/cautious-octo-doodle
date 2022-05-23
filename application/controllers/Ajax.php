<?php

class Ajax extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model("app_model");
  }

   public function index(){
      echo "This is sample message from Ajax Controller";
   }

   public function handle_ajax_requests(){

      $param = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

      if(!empty($param)){

        if($param == "save_category"){

          $category_name = $this->input->post("txt_add_name");
          $status = $this->input->post("dd_status");
          $opt_type = $this->input->post("opt_type");
          $edit_id = $this->input->post("edit_id");

          $category_data = array(
            "name" => $category_name,
            "status" => $status
          );

          if($opt_type == "add"){

            if($this->app_model->save_resource_data(tbl_categories(),$category_data)){

              $this->session->set_flashdata("success","Category added successfully");
            }else{
              $this->session->set_flashdata("error","Failed to save category");
            }

            $this->json(1,"Category added successfully");
          }elseif($opt_type == "edit"){

            if($this->app_model->edit_resource_data(tbl_categories(), $category_data,array("id" => $edit_id))){

              $this->session->set_flashdata("success","Category edited successfully");
            }else{
              $this->session->set_flashdata("error","Failed to edit category");
            }
          }
        }elseif($param == "get_category"){

          $category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : "";

          if(!empty($category_id)){

            $category_data = $this->app_model->get_category_data($category_id);
            $this->json(1,"category data",array("data"=>$category_data));
          }else{
            $this->session->set_flashdata("error","Failed to get the category data");
          }

        }elseif($param == "delete_category"){

          $cat_id = isset($_REQUEST['delete_id']) ? $_REQUEST['delete_id'] : "";

          if(!empty($cat_id)){

            if($this->app_model->delete_resource_data(tbl_categories(),array("id" => $cat_id))){

              $this->session->set_flashdata("success","Category deleted successfully");
            }else{
              $this->session->set_flashdata("error","Failed to delete category");
            }
          }
        }elseif($param == "save_brand"){

          $brand_name = $this->input->post("txt_add_name");
          $status = $this->input->post("dd_status");
          $category_id = $this->input->post("dd_category");
          $opt_type = $this->input->post("opt_type");
          $edit_id = $this->input->post("edit_id");

          $brand_data = array(
            "name" => $brand_name,
            "category_id" => $category_id,
            "status" => $status
          );

          if($opt_type == "add"){

            if($this->app_model->save_resource_data(tbl_brands(),$brand_data)){

              $this->session->set_flashdata("success","Brand added successfully");
            }else{
              $this->session->set_flashdata("error","Failed to save brand");
            }

            $this->json(1,"Brand added successfully");
          }elseif($opt_type == "edit"){

            if($this->app_model->edit_resource_data(tbl_brands(), $brand_data,array("id" => $edit_id))){

              $this->session->set_flashdata("success","Brand edited successfully");
            }else{
              $this->session->set_flashdata("error","Failed to edit brand");
            }
          }
        }elseif($param == "get_brand"){

          $brand_id = isset($_REQUEST['brand_id']) ? $_REQUEST['brand_id'] : "";
          if(!empty($brand_id)){

            $brand_data = $this->app_model->get_brand_data($brand_id);
            $this->json(1,"brand data",array("data"=>$brand_data));
          }else{
            $this->session->set_flashdata("error","Failed to get the brand data");
          }
        }elseif($param == "delete_brand"){

          $brand_id = isset($_REQUEST['delete_id']) ? $_REQUEST['delete_id'] : "";

          if(!empty($brand_id)){

            if($this->app_model->delete_resource_data(tbl_brands(),array("id" => $brand_id))){

              $this->session->set_flashdata("success","Brand deleted successfully");
            }else{
              $this->session->set_flashdata("error","Failed to delete brand");
            }
          }
        }elseif($param == "list_category_brands"){

          $cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : "";
          if(!empty($cat_id)){

             $brands = $this->app_model->get_resource_data(tbl_brands(),array("status" => 1,"category_id" => $cat_id));
             $this->json(1,"brands found",array("data" => $brands));
          }
        }elseif($param == "delete_product"){

          $product_id = isset($_REQUEST['delete_id']) ? $_REQUEST['delete_id'] : "";

          if(!empty($product_id)){

            if($this->app_model->delete_resource_data(tbl_products(),array("id" => $product_id))){

              $this->session->set_flashdata("success","Product deleted successfully");
            }else{
              $this->session->set_flashdata("error","Failed to delete product");
            }
          }
        }elseif($param == "add_more_product_row"){

           $categories = $this->app_model->get_resource_data(tbl_categories(),array("status" => 1));
           ob_start();
           $this->load->view("pages/tmpl/add-more-row-layout",array("categories" => $categories),FALSE);
           $template = ob_get_contents();
           ob_end_clean();

           $this->json(1,"template found",array(
             "template" => $template
           ));
        }elseif($param == "list_order_category_brands"){

          $cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : "";
          if(!empty($cat_id)){

             $brands = $this->app_model->get_resource_data(tbl_brands(),array("status" => 1,"category_id" => $cat_id));
             $this->json(1,"brands found",array("data" => $brands));
          }
        }elseif($param == "list_order_products"){

          $brand_id = isset($_REQUEST['brand_id']) ? $_REQUEST['brand_id'] : "";
          if(!empty($brand_id)){

             $products = $this->app_model->get_resource_data(tbl_products(),array("status" => 1,"brand_id" => $brand_id));
             $this->json(1,"brands found",array("data" => $products));
          }
        }elseif($param == "get_product_information"){

          $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : "";
          if(!empty($product_id)){

             $product_info = $this->app_model->get_resource_data(tbl_products(),array("status" => 1,"id" => $product_id));
             $product_info = $product_info[0];
             //print_r($product_info);
             $this->json(1,"product found",array("data" => $product_info));
          }
        }
      }
   }

   public function json($status,$message,$arr = array()){
      $data = array("sts" => $status, "message" => $message, "arr" => $arr);
      print_r(json_encode($data));
      die;
   }

}

 ?>
