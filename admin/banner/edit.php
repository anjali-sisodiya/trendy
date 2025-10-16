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

$id = $_GET['b'];
$message = "";

if (isset($_POST['update'])) {
    $description = $_POST["description"];
    $sub_description = $_POST["sub_description"];
    $status = $_POST["status"];

    if (!empty($_FILES['img']['name'])) {
        $fileTmpPath = $_FILES['img']['tmp_name'];
        $fileName = basename($_FILES['img']['name']);
        $uploadDir = "../../images/banner/";
        $destPath = $uploadDir . $fileName;
        $save_fileName = "images/banner/" . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // File moved successfully
        } else {
            $message = "<div class='alert alert-danger mt-3'>❌ Failed to upload image.</div>";
        }
    } else {
        // No new image uploaded, fetch current image from DB
        $sql_img = "SELECT banner_image FROM tbl_banner WHERE banner_id = ?";
        $stmt_img = $conn->prepare($sql_img);
        $stmt_img->bind_param('i', $id);
        $stmt_img->execute();
        $result_img = $stmt_img->get_result();
        $row_img = $result_img->fetch_assoc();
        $save_fileName = $row_img['banner_image'];
    }

    if (empty($message)) {
        $sql1 = "UPDATE tbl_banner SET banner_image = ?, banner_description = ?, sub_description = ?, status = ? WHERE banner_id = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('ssssi', $save_fileName, $description, $sub_description, $status, $id);

        if ($stmt1->execute()) {
            $message = "<div class='alert alert-success mt-3'>✅ Banner updated successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger mt-3'>❌ Oops... something went wrong! Please try again.</div>";
        }
    }
}

// Fetch current banner data after possible update to reflect changes
$sql = "SELECT * FROM tbl_banner WHERE banner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!-- 🌟 Styles for Design -->
<style>
  body, html {
    background-color: #f0f2f5;
    height: 100%;
  }

 .edit-banner-wrapper {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    padding: 30px 40px;
    margin: 80px auto 40px auto; /* top margin increased from 40px to 80px */
    max-width: 700px;
}


  .form-label {
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
  }

  .form-control {
    border: 1px solid #ced4da !important;
    border-radius: 6px;
    padding: 8px 12px;
  }

  .banner_editimg {
    border-radius: 6px;
    margin-top: 10px;
    margin-left: 5px;
    padding: 5px;
    max-height: 120px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    display: block;
  }

  .form-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #007bff;
    margin-bottom: 30px;
    text-align: center;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    font-weight: 600;
  }

  .alert {
    max-width: 700px;
    margin: 20px auto 0;
    padding: 15px;
    border-radius: 8px;
    font-size: 1rem;
    text-align: center;
  }
</style>

<!-- ✅ Form Layout -->
<div class="container">
  
  <div class="edit-banner-wrapper">
    <div class="form-title">Edit Banner</div>
    <?php echo $message; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Upload New Image (Optional)</label>
        <input type="file" name="img" class="form-control" accept="image/*">
        <img src="<?php echo "../../" . htmlspecialchars($row["banner_image"]); ?>" class="banner_editimg" alt="Current Banner">
      </div>

      <div class="mb-3">
        <label class="form-label">Banner Description</label>
        <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($row["banner_description"]); ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Sub Description</label>
        <input type="text" name="sub_description" class="form-control" value="<?php echo htmlspecialchars($row["sub_description"]); ?>" required>
      </div>

      <div class="mb-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-control" required>
          <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>>Active</option>
          <option value="0" <?php if ($row['status'] == 0) echo 'selected'; ?>>Inactive</option>
        </select>
      </div>

      <div class="text-center">
        <input type="submit" name="update" value="Update Banner" class="btn btn-primary px-5 py-2">
      </div>
    </form>
  </div>
</div>

<?php include '../partials/footer.php'; ?>
