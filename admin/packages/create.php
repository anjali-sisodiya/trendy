<?php
session_start();
if (!isset($_SESSION['is_admin_login'])) {
    header("Location: ../pages/samples/login.php");
}
include "../../dbconfig.php";
include "../partials/header.php";
include "../partials/navbar.php";
include "../partials/sidebar.php";

$alertMessage = "";

if (isset($_POST['submit'])) {
    $fileTmpPath = $_FILES['img']['tmp_name'];
    $fileName = "../../images/packages/" . $_FILES['img']['name'];
    $save_fileName = "images/packages/" . $_FILES['img']['name'];

    if (move_uploaded_file($fileTmpPath, $fileName)) {
        $p_name = $_POST["p_name"];
        $p_description = $_POST["p_description"];
        $country = $_POST["country"];
        $state = $_POST["state"];
        $city = $_POST["city"];
        $days = $_POST["days"];
        $people = $_POST["people"];
        $price = $_POST["price"];

        $sql = "INSERT INTO tbl_package(pack_name, pack_image, pack_description, country, city_id, state_id, no_of_days, no_of_people, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssiiiii', $p_name, $save_fileName, $p_description, $country, $city, $state, $days, $people, $price);

        if ($stmt->execute()) {
            $alertMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Package created successfully!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
    } else {
        $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed to upload image.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
}
?>

<style>
  .custom-card {
    background: #ffffff;
    border: 1px solid #dee2e6;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    border-radius: 12px;
    overflow: hidden;
    margin-top: 20px;
  }

  .form-wrapper {
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 0 0 12px 12px;
  }

  .form-title {
    background-color: #007bff;
    color: white;
    padding: 20px;
    font-size: 1.25rem;
    font-weight: 600;
    border-bottom: 1px solid #ccc;
    margin-top: 15px; 
  }

  .form-label {
    font-weight: 600;
    color: #333;
  }
  .form-control {
  border: 1px solid #ced4da !important;
  border-radius: 6px;
  background-color: #fff;
  box-shadow: none;
  transition: 0.3s;
}

.form-control:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
}

</style>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="custom-card">
        <div class="form-title">
          <i class="mdi mdi-plus-box me-2"></i> Create Travel Package
        </div>
        <?php echo $alertMessage; ?>
        <div class="form-wrapper">
          <form method="post" enctype="multipart/form-data">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Package Image</label>
                <input type="file" name="img" class="form-control" required />
              </div>
              <div class="col-md-6">
                <label class="form-label">Package Name</label>
                <input type="text" name="p_name" class="form-control" placeholder="Enter package name" required />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="p_description" class="form-control" rows="2" placeholder="Package description" required></textarea>
            </div>

            <div class="row mb-3">
              <div class="col-md-4">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control" placeholder="Country" required />
              </div>
              <div class="col-md-4">
                <label class="form-label">State</label>
                <select name="state" id="state" class="form-control" required>
                  <option value="">Select state</option>
                  <?php
                    $sql1 = "SELECT * FROM state ORDER BY state_title ASC";
                    $result = $conn->query($sql1);
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='{$row['state_id']}'>{$row['state_title']}</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">City</label>
                <select name="city" id="city" class="form-control" required>
                  <option value="">Select city</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4">
                <label class="form-label">No. of Days</label>
                <input type="number" name="days" class="form-control" required />
              </div>
              <div class="col-md-4">
                <label class="form-label">No. of People</label>
                <input type="number" name="people" class="form-control" required />
              </div>
              <div class="col-md-4">
                <label class="form-label">Price (Rs.)</label>
                <input type="number" name="price" class="form-control" required />
              </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary px-4 py-2">
              <i class="mdi mdi-content-save me-1"></i> Save Package
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
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

<?php include "../partials/footer.php"; ?>
