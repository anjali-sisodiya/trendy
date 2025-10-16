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

$sql = "SELECT * FROM tbl_banner WHERE status=1";
$result = $conn->query($sql);
?>

<style>
  /* Container with padding and shadow */
  .content-wrapper {
    padding: 20px; /* Reduced from 30px */
    background-color: #f8f9fa;
    min-height: 100vh;
  }

  /* Card-like container */
  .card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    border: none;
    padding: 15px; /* Reduced from 20px */
  }

  /* Table styles */
  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 0 0 1px #dee2e6;
  }

  thead {
    background-color: #007bff;
    color: #fff;
  }

  thead th {
    padding: 8px 10px; /* Reduced from 12px 15px */
    font-weight: 600;
    text-align: center;
    border-bottom: 2px solid #0056b3;
    font-size: 0.9rem; /* Smaller font */
  }

  tbody tr {
    background-color: #ffffff;
    transition: background-color 0.3s ease;
  }

  tbody tr:hover {
    background-color: #e9f0ff;
  }

  tbody td {
    padding: 10px 8px; /* Reduced from 15px 12px */
    text-align: center;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
    word-wrap: break-word;
    font-size: 0.9rem; /* Smaller font */
  }

  /* Special styling for description columns */
  .desc-col {
    max-width: 250px;
    text-align: left;
    padding-left: 20px;
  }

  /* Banner image styling */
  .admin_banner_img {
    height: 80px;   /* Reduced from 100px */
    width: 120px;   /* Reduced from 160px */
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #ddd;
    transition: transform 0.3s ease;
  }

  .admin_banner_img:hover {
    transform: scale(1.05);
  }

  /* Button styles */
  .btn-primary {
    background-color: #007bff;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none;
    display: inline-block;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    text-decoration: none;
    color: white;
  }

  .btn-outline-primary {
    border: 1.5px solid #007bff;
    background: transparent;
    color: #007bff;
    padding: 6px 12px;
    border-radius: 6px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
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
  border: 1px solid #dee2e6;
}

.page-header h1 {
  margin: 0;
  font-weight: 700;
  font-size: 1.75rem;
  color: #343a40;
  font-family: 'Inter', sans-serif;
}

.page-header a.btn-primary {
  font-size: 0.95rem;
  padding: 8px 18px;
}

</style>

<div class="content-wrapper">
  <div class="page-header">
    <h1>Manage Banners</h1>
    <a href="create.php" class="btn-primary">+ Create Banner</a>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table>
        <thead>
  <tr style="background: linear-gradient(to right, #0062E6, #33AEFF); color: #fff; font-size: 0.95rem;">
    <th style="width: 40px; text-align: center; padding: 10px 0;">#</th>
    <th style="width: 180px; text-align: center;">
      <i class="fas fa-image" style="margin-right: 6px;"></i>Image
    </th>
    <th class="desc-col" style="text-align: left;">
      <i class="fas fa-align-left" style="margin-right: 6px;"></i>Description
    </th>
    <th class="desc-col" style="text-align: left;">
      <i class="fas fa-sticky-note" style="margin-right: 6px;"></i>Sub Description
    </th>
    <th style="width: 100px; text-align: center;">
      <i class="fas fa-toggle-on" style="margin-right: 6px;"></i>Status
    </th>
    <th style="width: 80px; text-align: center;">
      <i class="fas fa-cog" style="margin-right: 6px;"></i>Action
    </th>
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
              <img src="<?php echo "../../" . htmlspecialchars($row["banner_image"]); ?>" alt="Banner Image" class="admin_banner_img" />
            </td>
            <td class="desc-col"><?php echo htmlspecialchars($row["banner_description"]); ?></td>
            <td class="desc-col"><?php echo htmlspecialchars($row["sub_description"]); ?></td>
            <td>
              <?php if ($row["status"] == 1): ?>
                <span style="color: #198754; font-weight: 600;">Active</span>
              <?php else: ?>
                <span style="color: #6c757d; font-weight: 600;">Deactive</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="edit.php?b=<?php echo $row["banner_id"]; ?>" class="btn-outline-primary" title="Edit Banner">
                <i class="fas fa-edit"></i>
              </a>
            </td>
          </tr>
          <?php
              $i++;
            }
          } else {
            echo '<tr><td colspan="6" style="text-align:center; padding:20px;">No banners found.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../partials/footer.php'; ?>
