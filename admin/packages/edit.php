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
    $p_name = $_POST["p_name"];
    $p_description = $_POST["p_description"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $days = $_POST["days"];
    $people = $_POST["people"];
    $price = $_POST["price"];

    // Check if new image uploaded
    if (!empty($_FILES['img']['name'])) {
        $fileTmpPath = $_FILES['img']['tmp_name'];
        $fileName = basename($_FILES['img']['name']);
        $uploadDir = "../../images/packages/";
        $destPath = $uploadDir . $fileName;
        $save_fileName = "images/packages/" . $fileName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            $message = "<div class='alert alert-danger mt-3'>❌ Failed to upload image.</div>";
        }
    } else {
        // No new image uploaded: keep existing image from DB
        $stmt_img = $conn->prepare("SELECT pack_image FROM tbl_package WHERE package_id = ?");
        $stmt_img->bind_param('i', $id);
        $stmt_img->execute();
        $result_img = $stmt_img->get_result();
        $row_img = $result_img->fetch_assoc();
        $save_fileName = $row_img['pack_image'];
    }

    if (empty($message)) {
        $sql1 = "UPDATE tbl_package SET pack_name=?, pack_image=?, pack_description=?, state_id=?, city_id=?, country=?, no_of_days=?, no_of_people=?, price=? WHERE package_id=?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('sssiisiiii', $p_name, $save_fileName, $p_description, $state, $city, $country, $days, $people, $price, $id);

        if ($stmt1->execute()) {
            $message = '<div class="alert alert-success text-center mt-3">✅ Updated successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger text-center mt-3">❌ Oops... something went wrong! Please try again.</div>';
        }
    }
}

// Fetch package info (with state and city names) AFTER update to show fresh data
$sql = "SELECT tp.*, s.state_title, c.name 
        FROM tbl_package tp 
        JOIN state s ON tp.state_id = s.state_id 
        JOIN city c ON tp.city_id = c.id 
        WHERE package_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<style>
  body {
    background-color: #f0f2f5;
  }

  .form-section {
  background-color: #ffffff;
  border-radius: 12px;
  padding: 30px;
  margin-top: 80px;  /* increase this */
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
}


  .form-section:hover {
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
  }

  .form-control {
    border: 1px solid #ced4da !important;
    border-radius: 6px;
  }

  .form-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #007bff;
    margin-bottom: 20px;
  }

  .edit-img-preview {
    max-height: 120px;
    border-radius: 8px;
    margin-top: 10px;
  }
</style>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="form-section">
        <div class="form-title">Edit Travel Package</div>

        <?php if (!empty($message)) echo $message; ?>

        <form method="post" enctype="multipart/form-data">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Package Image</label>
              <input type="file" name="img" class="form-control" accept="image/*">
              <img src="<?php echo "../../" . htmlspecialchars($row["pack_image"]); ?>" class="edit-img-preview" alt="Package Image" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Package Name</label>
              <input type="text" name="p_name" class="form-control" value="<?php echo htmlspecialchars($row["pack_name"]); ?>" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="p_description" class="form-control" value="<?php echo htmlspecialchars($row["pack_description"]); ?>" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Country</label>
              <input type="text" name="country" class="form-control" value="<?php echo htmlspecialchars($row["country"]); ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">State</label>
              <select name="state" id="state" class="form-control" required>
                <option value="">Select state</option>
                <?php
                $sql1 = "SELECT * FROM state ORDER BY state_title ASC";
                $result1 = $conn->query($sql1);
                while ($row1 = $result1->fetch_assoc()) {
                  $selected = ($row1['state_id'] == $row['state_id']) ? 'selected' : '';
                  echo "<option value='{$row1['state_id']}' $selected>" . htmlspecialchars($row1['state_title']) . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">City</label>
              <select name="city" id="city" class="form-control" required>
                <option value="<?php echo $row['city_id']; ?>"><?php echo htmlspecialchars($row['city_name']); ?></option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">No. of Days</label>
              <input type="number" name="days" class="form-control" value="<?php echo htmlspecialchars($row["no_of_days"]); ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">No. of People</label>
              <input type="number" name="people" class="form-control" value="<?php echo htmlspecialchars($row["no_of_people"]); ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Price (Rs.)</label>
              <input type="number" name="price" class="form-control" value="<?php echo htmlspecialchars($row["price"]); ?>" required>
            </div>
          </div>

          <div class="text-center">
            <input type="submit" name="update" value="Update Package" class="btn btn-primary px-5 py-2">
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $('#state').on('change', function () {
    var state_id = this.value;
    $.ajax({
      url: "getcity.php",
      type: "POST",
      data: { state_id: state_id },
      success: function (data) {
        $("#city").html(data);
      }
    });
  });
</script>

<?php include '../partials/footer.php'; ?>
