<?php
session_start();
include "dbconfig.php";

$submit = false;
$id = isset($_GET['p']) ? intval($_GET['p']) : 0;

if ($id > 0) {
    $sql1 = "SELECT * FROM tbl_package WHERE package_id = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $amount = $row['price'];
        $packName = $row['pack_name'];
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

if (isset($_POST['cartinfo'])) {
    if (!isset($_SESSION["user_id"])) {
        echo "Please login first.";
        exit();
    }

    $user_id = $_SESSION["user_id"];
    $phn = $_POST["phn"];
    $date = $_POST["date"];
    $price = $_POST["price"];
    $payment_status = 2;

    $fileTmpPath = $_FILES['document']['tmp_name'];
    $fileName = "files/" . basename($_FILES['document']['name']);

    if (is_uploaded_file($fileTmpPath) && move_uploaded_file($fileTmpPath, $fileName)) {
        $sql = "INSERT INTO cart(package_id, user_id, document, phone_no, payment_status, price, visit_date)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisiiis', $id, $user_id, $fileName, $phn, $payment_status, $price, $date);

        if ($stmt->execute()) {
            $submit = true;
        } else {
            echo "Insert Error: " . $stmt->error;
        }
    } else {
        echo "File upload failed.";
    }
}

include "header.php";
include "nav.php";

if ($submit == true) {
    ?>
    <script type="text/javascript">
        swal("Package Successfully Add!").then(() => {
            window.location.href = "user_cart.php";
        });
    </script>
    <?php
}
?>

<style>
  .booking-container {
  max-width: 500px;
  margin: 30px auto;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2),
              0 8px 24px rgba(0, 0, 0, 0.15);
  padding: 40px 45px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  transition: box-shadow 0.3s ease;
}

.booking-container:hover {
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3),
              0 10px 30px rgba(0, 0, 0, 0.25);
}

.booking-title {
  font-weight: 700;
  font-size: 2.6rem;
  text-align: center;
  color: #007bff; 
  margin-bottom: 35px;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  user-select: none;
}

form label {
  font-weight: 600;
  color: #333;
  margin-bottom: 6px;
  display: block;
}

.form-control {
  border-radius: 8px;
  border: 1.5px solid #ced4da;
  padding: 12px 15px;
  font-size: 1rem;
  transition: border-color 0.25s ease;
}

.form-control:focus {
  border-color: #007bff;
  box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
  outline: none;
}

.form-text {
  font-size: 0.85rem;
  color: #6c757d;
}

.mb-3 {
  margin-bottom: 20px;
}

.d-flex {
  display: flex !important;
}

.justify-content-between {
  justify-content: space-between !important;
}

.align-items-center {
  align-items: center !important;
}

.text-success {
  font-weight: 700;
  color: #28a745 !important;
}

.btn-primary, .btn-secondary {
  font-weight: 600;
  border-radius: 50px;
  padding: 12px 0;
  font-size: 1.1rem;
  box-shadow: 0 4px 8px rgba(0, 123, 255, 0.25);
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
  box-shadow: 0 6px 14px rgba(0, 86, 179, 0.4);
}

.btn-secondary {
  background-color: #6c757d;
  border-color: #6c757d;
  color: white;
  box-shadow: 0 4px 8px rgba(108, 117, 125, 0.25);
}

.btn-secondary:hover {
  background-color: #565e64;
  border-color: #565e64;
  box-shadow: 0 6px 14px rgba(86, 94, 100, 0.4);
}

/* Responsive tweaks */
@media (max-width: 600px) {
  .booking-container {
    margin: 30px 15px;
    padding: 30px 25px;
  }
  .booking-title {
    font-size: 2rem;
    margin-bottom: 25px;
  }
  .btn-primary, .btn-secondary {
    font-size: 1rem;
  }
}

</style>

<div class="booking-container">
  <h2 class="booking-title">Complete Your Booking</h2>

  <form method="post" enctype="multipart/form-data" action="">
    <div class="mb-3">
      <label for="document" class="form-label">Upload Document <span class="text-danger">*</span></label>
      <input type="file" name="document" id="document" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="phn" class="form-label">Contact Number <span class="text-danger">*</span></label>
      <input type="tel" name="phn" id="phn" class="form-control" placeholder="Enter your mobile number" pattern="[0-9]{10}" required>
      <div class="form-text">Enter a valid 10-digit phone number.</div>
    </div>

    <div class="mb-3">
      <label for="date" class="form-label">Select Date <span class="text-danger">*</span></label>
      <input type="date" name="date" id="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
    </div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Price: <span class="text-success">Rs. <?php echo htmlspecialchars($amount); ?></span></h5>
      <input type="hidden" name="price" value="<?php echo htmlspecialchars($amount); ?>">
    </div>

    <?php if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] == false) { ?>
      <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary w-100">Save</button>
    <?php } else { ?>
      <button type="submit" name="cartinfo" class="btn btn-primary w-100">Save</button>
    <?php } ?>
  </form>
</div>

<?php
include "footer.php";
?>