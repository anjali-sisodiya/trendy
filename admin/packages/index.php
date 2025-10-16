<?php 
session_start();
if (!isset($_SESSION['is_admin_login'])) {
    header("Location: ../pages/samples/login.php");
    exit();
}

include "../../dbconfig.php";
include "../partials/header.php";
include "../partials/navbar.php";
include "../partials/sidebar.php";

$sql = "SELECT * FROM tbl_package tp 
        JOIN city c ON tp.city_id = c.id 
        JOIN state s ON c.state_id = s.state_id";
$result = $conn->query($sql);
?>

<!-- Font Awesome CDN (if not already added) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
  .content-wrapper {
    padding: 20px;
    background-color: #f8f9fa;
    min-height: 100vh;
  }

  .card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    border: none;
    padding: 20px;
  }

  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 0 0 1px #dee2e6;
  }

  thead th {
  padding: 10px;
  text-align: center;
  font-weight: 600;
  font-size: 0.9rem;
  background-color: #007bff; /* Single solid blue */
  color: #fff;
}


  tbody td {
    padding: 10px;
    text-align: center;
    vertical-align: middle;
    font-size: 0.9rem;
    border-bottom: 1px solid #dee2e6;
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

  .btn-outline-primary {
    border: 1.5px solid #007bff;
    background: transparent;
    color: #007bff;
    padding: 6px 10px;
    border-radius: 6px;
    transition: all 0.3s ease;
    text-decoration: none;
  }

  .btn-outline-primary:hover {
    background-color: #007bff;
    color: white;
  }

  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding: 15px 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  }

  .page-header h1 {
    margin: 0;
    font-weight: 700;
    font-size: 1.75rem;
    color: #343a40;
    font-family: 'Inter', sans-serif;
  }

  .btn-primary {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    color: white;
  }
</style>

<div class="content-wrapper">
  <div class="page-header">
    <h1>Manage Packages</h1>
    <a href="create.php" class="btn-primary">+ Create Package</a>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th><i class="fas fa-image me-1"></i>Image</th>
            <th><i class="fas fa-box me-1"></i>Name</th>
            <th><i class="fas fa-city me-1"></i>City</th>
            <th><i class="fas fa-map-marker-alt me-1"></i>State</th>
            <th><i class="fas fa-globe me-1"></i>Country</th>
            <th><i class="fas fa-rupee-sign me-1"></i>Price</th>
            <th><i class="fas fa-toggle-on me-1"></i>Status</th>
            <th><i class="fas fa-cog me-1"></i>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td>
              <img src="<?php echo "../../" . htmlspecialchars($row["pack_image"]); ?>" class="admin_banner_img" alt="Package Image" />
            </td>
            <td><?php echo htmlspecialchars($row["pack_name"]); ?></td>
            <td><?php echo htmlspecialchars($row["name"]); ?></td>
            <td><?php echo htmlspecialchars($row["state_title"]); ?></td>
            <td><?php echo htmlspecialchars($row["country"]); ?></td>
            <td><?php echo htmlspecialchars($row["price"]); ?></td>
            <td>
              <?php if ($row["status"] == 0): ?>
                <span style="color: #198754; font-weight: 600;">Active</span>
              <?php else: ?>
                <span style="color: #dc3545; font-weight: 600;">Deactive</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="edit.php?b=<?php echo $row["package_id"]; ?>" class="btn-outline-primary" title="Edit Package">
                <i class="fas fa-edit"></i>
              </a>
            </td>
          </tr>
          <?php
              $i++;
            }
          } else {
            echo '<tr><td colspan="9" style="text-align:center; padding:20px;">No packages found.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../partials/footer.php'; ?>
