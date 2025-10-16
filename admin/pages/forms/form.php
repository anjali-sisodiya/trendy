
      <?php
      session_start();
      if(!isset($_SESSION['is_admin_login'])){
     header("Location: ../samples/login.php");
      }
      include '../../../dbconfig.php';    
      include '../../partials/header.php';    
      include '../../partials/navbar.php';    
      include '../../partials/sidebar.php';
       $sql = "SELECT * FROM tbl_banner WHERE status=1";
    $result = $conn->query($sql);
      ?>
        
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Form elements </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Forms</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Form elements</li>
                </ol>
              </nav>
            </div>
            <div class="row">             
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Basic form elements</h4>
                    <p class="card-description"> Basic form elements </p>
                    <form class="forms-sample">
                       <table class="table table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th class="text-center"> banner_image </th>
                          <th class="text-center"> Descrition </th>
                          <th class="text-center"> Sub Descrition </th>
                          <th class="text-center"> Status </th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>

                      <?php
                      $i = 1;
                    while($row = $result->fetch_assoc()) {                        
                      ?>

                      <tbody>
                        <tr>
                          <td class="text-center"><?php echo $i?> </td>
                          <td>
                            <img src="<?php echo "../../". $row["banner_image"]?>" class="admin_banner_img" alt="image" />
                          </td>
                          <td class="text-center"><?php echo $row["banner_description"]?> </td>
                          <td class="text-center"><?php echo $row["sub_description"]?></td>                          
                          <td class="text-center"> <?php echo ($row["status"] ==1 ? "active" : "deactive");?> </td>                        
                          <td class="text-center"><button type="button" class="btn btn-gradient-dark btn-icon-text"><a href="edit.php">Edit</a>  <i class="mdi mdi-file-check btn-icon-append"></i>
                          </button> </td>

                           <?php
                           $i++;
                           }
                          ?>
                          
                        </tr>                      
                      </tbody>
                    </table>
                    </form>
                  </div>
                </div>
              </div>                        
            </div>
          </div>
         
          <?php
          include '../../partials/footer.php';
        ?>