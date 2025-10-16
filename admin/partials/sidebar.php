<?php
$base_url = "http://localhost/trendy/admin/";
$current_page = basename($_SERVER['PHP_SELF']);
$full_path = $_SERVER['PHP_SELF'];

$sql = "SELECT * FROM user_details";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>
<style type="text/css">
  /* Just highlight the link text — no background */
.nav .nav-link.active-link {
  color: #007bff !important;
  font-weight: 600;
}

.nav .nav-link.active-link i {
  color: #007bff !important;
}

</style>
<div class="container-fluid page-body-wrapper">
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <!-- Profile -->
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="<?php echo $base_url . "../" . $user['profile_image']; ?>" alt="profile">
            <span class="login-status online"></span>
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">
              <?php echo $user['first_name'] . " " . ucwords(strtolower($user['last_name'])); ?>
            </span>
            <span class="text-secondary text-small">Project Manager</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>

      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'index.php' && strpos($full_path, 'admin/index.php') !== false) ? 'active-link' : ''; ?>" href="<?php echo $base_url; ?>index.php">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>

      <!-- Banner -->
      <?php $is_banner = strpos($full_path, '/banner/') !== false; ?>
      <li class="nav-item">
        <a class="nav-link <?php echo $is_banner ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#banner-menu" aria-expanded="<?php echo $is_banner ? 'true' : 'false'; ?>" aria-controls="banner-menu">
          <span class="menu-title">Banner</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-crosshairs-gps menu-icon"></i>
        </a>
        <div class="collapse <?php echo $is_banner ? 'show' : ''; ?>" id="banner-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'index.php' && $is_banner) ? 'active-link' : ''; ?>" href="<?php echo $base_url; ?>banner">Banner List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'create.php' && $is_banner) ? 'active-link' : ''; ?>" href="<?php echo $base_url; ?>banner/create.php">Create Banner</a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Packages -->
      <?php $is_package = strpos($full_path, '/Packages/') !== false; ?>
      <li class="nav-item">
        <a class="nav-link <?php echo $is_package ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" href="#package-menu" aria-expanded="<?php echo $is_package ? 'true' : 'false'; ?>" aria-controls="package-menu">
          <span class="menu-title">Packages</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-crosshairs-gps menu-icon"></i>
        </a>
        <div class="collapse <?php echo $is_package ? 'show' : ''; ?>" id="package-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'index.php' && $is_package) ? 'active-link' : ''; ?>" href="<?php echo $base_url; ?>Packages">Package List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'create.php' && $is_package) ? 'active-link' : ''; ?>" href="<?php echo $base_url; ?>Packages/create.php">Create Package</a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Cart -->
      <li class="nav-item">
        <a class="nav-link <?php echo (strpos($full_path, '/cart/index.php') !== false) ? 'active-link' : ''; ?>" href="<?php echo $base_url; ?>cart/index.php">
          <span class="menu-title">Cart</span>
          <i class="mdi mdi-cart menu-icon"></i>
        </a>
      </li>
    </ul>
  </nav>

  <div class="main-panel">
