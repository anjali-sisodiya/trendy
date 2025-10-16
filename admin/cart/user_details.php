<?php
 session_start();
    if(!isset($_SESSION['is_admin_login'])){
     header("Location: ../pages/samples/login.php");
}
    include "../../dbconfig.php";
    include "../partials/header.php";
    include "../partials/navbar.php";
    include "../partials/sidebar.php";
  // $id = $_GET['p'];

    $sql = "SELECT * FROM user_details WHERE user_id=1";
$result = $conn->query($sql);
    ?>
 <div class="col-12 grid-margin stretch-card">
    <div class="card">
                  <div class="card-body packageform">
                    <h4 class="card-title">User details</h4>
                    <form method="post" class="form-sample" enctype="multipart/form-data">
                      <?php
while($row = $result->fetch_assoc()) {

                      ?>
                      
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                              <input type="text" name="fname" class="form-control" value="<?php echo $row["first_name"]?><?php echo $row["last_name"]?>" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Profile Image</label>
                            <div class="col-sm-9">
                              <input type="text" name="p_name" class="form-control" />
                              <img src="../../<?php echo $row["profile_image"]?>" class="userdtl_img">

                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email_id</label>
                            <div class="col-sm-9">
                              <input type="text" name="p_description" class="form-control" value="<?php echo $row["email"]?>"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Gender</label>
                            <div class="col-sm-9">
                              <input type="text" name="country" class="form-control" value="<?php echo $row["gender"]?>" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Phone no.</label>
                            <div class="col-sm-9">
                              <input type="text" name="days" class="form-control" value="<?php echo $row["phone"]?>" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">pincode</label>
                            <div class="col-sm-9">
                              <input type="text" name="people" class="form-control" value="<?php echo $row["pincode"]?>" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">address</label>
                            <div class="col-sm-9">
                              <input type="text" name="price" class="form-control" value="<?php echo $row["address"]?>" />                   
                            </div>
                          </div>

                        </div>
                      </div>                       
                      </div>
                      <?php
                    }
                      ?>
                    </form>
                  </div>
                </div>
              </div>


<?php

 include '../partials/footer.php';

?> 