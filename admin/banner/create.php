<?php
session_start();
if(!isset($_SESSION['is_admin_login'])){
    header("Location: ../pages/samples/login.php");
    exit;
}
include "../../dbconfig.php";
include "../partials/header.php";
include "../partials/navbar.php";
include "../partials/sidebar.php";

$alertMessage = "";

if(isset($_POST['submit'])) {
    $fileTmpPath = $_FILES['img']['tmp_name'];
    $fileName = "../../images/banner/".$_FILES['img']['name'];
    $save_fileName = "images/banner/".$_FILES['img']['name'];

    if (move_uploaded_file($fileTmpPath, $fileName)) {
        $description = $_POST["description"];
        $sub_description = $_POST["sub_description"];

        $sql = "INSERT INTO tbl_banner(banner_image, banner_description, sub_description) VALUES(?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $save_fileName, $description, $sub_description);
        if ($stmt->execute()) {
            $alertMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Banner uploaded successfully!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
    } else {
        $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed to upload image. Please try again.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
}
?>

<style>
  body {
    background-color: #f0f2f5;
  }

  /* Add spacing above the whole container */
  .container.py-5 {
    padding-top: 60px;
  }

  .custom-card {
    background: #ffffff;
    border: 1px solid #dee2e6;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    border-radius: 12px;
    overflow: hidden;
    margin-top: 30px; /* Added margin to push card down */
  }

  .form-wrapper {
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 0 0 12px 12px;
  }

  .form-label {
    font-weight: 600;
    color: #333;
  }

  .form-control {
    border: 1px solid #ced4da;
    background-color: #fff;
    transition: 0.3s ease;
  }

  .form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
  }

  .form-title {
    background-color: #007bff;
    color: white;
    padding: 20px; /* Padding on all sides */
    font-size: 1.25rem;
    font-weight: 600;
    border-bottom: 1px solid #ccc;
  }
</style>

<div class="container py-5">
 
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="custom-card">
        <!-- Card Header -->
        <div class="form-title">
          <i class="mdi mdi-image-area me-2"></i> Upload New Banner
        </div>
         <?php echo $alertMessage; ?>
        <!-- Card Body with Light Background -->
        <div class="form-wrapper">
          <form method="post" enctype="multipart/form-data">
            <!-- Image Upload -->
            <div class="mb-4">
              <label class="form-label">Banner Image <span class="text-danger">*</span></label>
              <input type="file" name="img" accept="image/*" class="form-control" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
              <label class="form-label">Banner Title</label>
              <textarea name="description" class="form-control" rows="3" placeholder="Main banner message..." required></textarea>
            </div>

            <!-- Sub-description -->
            <div class="mb-4">
              <label class="form-label">Sub Description</label>
              <textarea name="sub_description" class="form-control" rows="2" placeholder="Optional sub text..."></textarea>
            </div>

            <!-- Submit -->
            <button type="submit" name="submit" class="btn btn-primary px-4 py-2">
              <i class="mdi mdi-upload me-1"></i> Upload
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../partials/footer.php'; ?>
