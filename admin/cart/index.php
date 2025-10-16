<?php 
session_start();
if(!isset($_SESSION['is_admin_login'])){
  header("Location: ../pages/samples/login.php");
  exit();
}

include "../../dbconfig.php";
include "../partials/header.php";
include "../partials/navbar.php";
include "../partials/sidebar.php";

$sql = "SELECT * FROM cart c 
        JOIN tbl_package tp ON c.package_id=tp.package_id 
        JOIN user_details ud ON c.user_id=ud.user_id";
$result = $conn->query($sql);
?>

<!-- Optional: Font Awesome CDN for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
  .content-wrapper {
    padding: 25px 30px;
    background-color: #f8f9fa;
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .page-header {
    margin-bottom: 25px;
  }

  .page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #007bff;
    text-decoration: none;
  }
  .page-title:hover {
    text-decoration: underline;
  }

  .card {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    padding: 20px;
    border: none;
  }

  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 0 1px #dee2e6;
    background: #fff;
  }

  thead th {
    background: #007bff;
    color: white;
    text-align: center;
    padding: 12px 10px;
    font-weight: 600;
    font-size: 0.95rem;
  }

  tbody td {
    text-align: center;
    padding: 12px 10px;
    font-size: 0.9rem;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
    color: #333;
  }

  tbody tr:hover {
    background-color: #e9f2ff;
  }

  .admin_banner_img {
    height: 70px;
    width: 100px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ccc;
    transition: transform 0.3s ease;
  }
  .admin_banner_img:hover {
    transform: scale(1.05);
  }

  a.view-link {
    color: #007bff;
    font-size: 1.2rem;
    transition: color 0.3s ease;
  }
  a.view-link:hover {
    color: #0056b3;
    text-decoration: none;
  }

  /* Responsive */
  @media (max-width: 768px) {
    tbody td, thead th {
      font-size: 0.8rem;
      padding: 8px 6px;
    }

    .admin_banner_img {
      width: 80px;
      height: 55px;
    }
  }
</style>

<div class="content-wrapper">
  <div class="page-header">
    <a href="create.php" class="page-title">+ Create Banner</a>
  </div>
  <div class="card">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Email ID</th>
            <th>Mobile No.</th>
            <th>Package Name</th>
            <th>Package Image</th>
            <th>Price</th>
            <th>View</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $fullName = htmlspecialchars($row['first_name'] . " " . $row['last_name']);
              $email = htmlspecialchars($row['email']);
              $phone = htmlspecialchars($row['phone']);
              $packName = htmlspecialchars($row['pack_name']);
              $price = htmlspecialchars($row['price']);
              $imagePath = "../../" . htmlspecialchars($row['pack_image']);
              $cartId = $row['cart_id'];
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $fullName; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $phone; ?></td>
            <td><?php echo $packName; ?></td>
            <td><img src="<?php echo $imagePath; ?>" alt="Package Image" class="admin_banner_img"></td>
            <td>Rs. <?php echo $price; ?></td>
            <td>
              <a href="view_cart_details.php?p=<?php echo $cartId; ?>" class="view-link" title="View Details">
                <i class="fas fa-eye"></i>
              </a>
            </td>
          </tr>
          <?php
              $i++;
            }
          } else {
            echo '<tr><td colspan="8" style="text-align:center; padding:20px;">No cart records found.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../partials/footer.php'; ?>
