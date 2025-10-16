<?php 
session_start();
include '../dbconfig.php';    

if(!isset($_SESSION['is_admin_login'])){
    header("Location: pages/samples/login.php");
}
include "partials/header.php";
include "partials/navbar.php";
include "partials/sidebar.php";
?>

<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-hotel"></i>
      </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
      <ul class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          Overview <i class="mdi mdi-map-marker-radius icon-sm text-primary align-middle"></i>
        </li>
      </ul>
    </nav>
  </div>

  <div class="row">
    <!-- Total Bookings -->
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-primary card-img-holder text-white">
        <div class="card-body">
          <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Total Bookings <i class="mdi mdi-calendar-check mdi-24px float-end"></i></h4>
          <h2 class="mb-4">1,250</h2>
          <h6 class="card-text">Updated today</h6>
        </div>
      </div>
    </div>

    <!-- Active Hotels -->
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-success card-img-holder text-white">
        <div class="card-body">
          <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Active Hotels <i class="mdi mdi-city mdi-24px float-end"></i></h4>
          <h2 class="mb-4">342</h2>
          <h6 class="card-text">Across all cities</h6>
        </div>
      </div>
    </div>

    <!-- Today's Check-ins -->
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-warning card-img-holder text-white">
        <div class="card-body">
          <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Today’s Check-ins <i class="mdi mdi-account-location mdi-24px float-end"></i></h4>
          <h2 class="mb-4">78</h2>
          <h6 class="card-text">Guests checked in</h6>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional: Add more stats or graphs -->
</div>

<?php 
include 'partials/footer.php';
?>
