<div class="content-wrapper" style="min-height: 926px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List Brands
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a class="active">List Brands</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">

              <?php if($this->session->flashdata("success")){
                ?>
                <div class="alert alert-success">
                  <?php echo $this->session->flashdata("success"); ?>
                </div>
                <?php
              } ?>

              <?php if($this->session->flashdata("error")){
                ?>
                <div class="alert alert-danger">
                  <?php echo $this->session->flashdata("error"); ?>
                </div>
                <?php
              } ?>


              <div class="panel panel-primary">
                <div class="panel-heading">
                  Listing Brands
                  <button id="btn-add-brand" data-toggle="modal" data-target="#brand-modal" class="btn btn-warning pull-right btn-placement-class">Add Brand</button>
                </div>
                <div class="panel-body">
                  <table id="list-brands" class="display" style="width:100%">
                          <thead>
                              <tr>
                                  <th>Sr No</th>
                                  <th>Name</th>
                                  <th>Category</th>
                                  <th>Created at</th>
                                  <th>Status</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>

                            <?php

                          if(count($brands) > 0){
                            $count =1;
                            foreach($brands as $index => $value){
                              ?>
                              <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $value->name ?></td>
                                    <td><?php
                                      $brand_data = $brand_controller->get_category_name($value->category_id);
                                      echo $brand_data->name;
                                    ?></td>
                                    <td><?php echo $value->created_at ?></td>
                                    <td><?php
                                    if($value->status){
                                      ?>
                                      <button class="btn btn-success">Active</button>
                                      <?php
                                    }else{
                                      ?>
                                      <button class="btn btn-danger">Inactive</button>
                                      <?php
                                    }
                                     ?></td>
                                     <td>
                                       <button class="btn btn-warning btn-edit-brand" data-id="<?php echo $value->id ?>">Edit</button>
                                       <button class="btn btn-danger btn-delete-brand" data-id="<?php echo $value->id ?>">Delete</button>
                                     </td>
                                </tr>
                                <?php
                                $count++;
                            }
                          }
                          ?>

                          </tbody>
                          <tfoot>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Created at</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tfoot>
                      </table>
                </div>
              </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Modal -->
<div id="brand-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal-title">Add Brand</h4>
      </div>
      <div class="modal-body">
        <form action="javascript:void(0)" class="validate-custom-form-error" id="frm-add-brand" method="post">

            <input type="hidden" name="opt_type" id="opt_type" value="add"/>
            <input type="hidden" name="edit_id" id="edit_id" value=""/>

            <div class="form-group">
              <label for="dd_category">Category:</label>
              <select class="form-control" name="dd_category" id="dd_category">
                 <option value="">Choose Category</option>
                 <?php
                  if(count($categories) > 0){
                    foreach($categories as $index => $value){
                      ?>
                       <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                      <?php
                    }
                  }
                 ?>
              </select>
            </div>

            <div class="form-group">
              <label for="txt_add_name">Name:</label>
              <input type="text" class="form-control" required id="txt_add_name" name="txt_add_name" placeholder="Brand name">
            </div>
            <div class="form-group">
              <label for="dd_status">Status:</label>
              <select class="form-control" name="dd_status" id="dd_status">
                 <option value="1">Active</option>
                 <option value="0">Inactive</option>
              </select>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
          </form>
      </div>
    </div>

  </div>
</div>
