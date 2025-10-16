<?php
session_start();
if (!isset($_SESSION['is_admin_login'])) {
    header("Location: ../pages/samples/login.php");
    exit;
}
include "../../dbconfig.php";
include "../partials/header.php";
include "../partials/navbar.php";
include "../partials/sidebar.php";

$id = $_GET['p'];
$sql = "SELECT * FROM cart c 
        JOIN tbl_package tp ON c.package_id = tp.package_id 
        JOIN user_details ud ON c.user_id = ud.user_id 
        WHERE c.cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
  body {
    background: #f7f9fc;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .container {
  margin-top: 60px;
}

  .card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
    transition: box-shadow 0.3s ease;
  }
  .card:hover {
    box-shadow: 0 8px 24px rgb(0 0 0 / 0.15);
  }
  .package-image,
  .profile-image {
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  .profile-image {
    border-radius: 50%;
    max-width: 160px;
    max-height: 160px;
  }
  .label-text {
    font-weight: 600;
    color: #555;
  }
  .value-text {
    font-weight: 500;
    color: #222;
  }
</style>

<div class="container py-5">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card mb-5 p-4 bg-white">
            <div class="row align-items-center">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <img src="<?php echo "../../" . htmlspecialchars($row["pack_image"]); ?>" alt="Package Image" class="package-image img-fluid" style="max-height: 280px; width: 100%; max-width: 320px;">
                </div>
                <div class="col-md-8">
                    <h2 class="mb-3" style="color: #007bff;"><?php echo htmlspecialchars($row["pack_name"]); ?></h2>
                    <p class="mb-4" style="font-size: 1.1rem; color: #444;"><?php echo htmlspecialchars($row["pack_description"]); ?></p>

                    <div class="row mb-3">
                        <div class="col-6">
                            <p><span class="label-text">Country:</span> <span class="value-text"><?php echo htmlspecialchars($row["country"]); ?></span></p>
                        </div>
                        <div class="col-6">
                            <p><span class="label-text">No. of Days:</span> <span class="value-text"><?php echo htmlspecialchars($row["no_of_days"]); ?></span></p>
                        </div>
                        <div class="col-6">
                            <p><span class="label-text">No. of People:</span> <span class="value-text"><?php echo htmlspecialchars($row["no_of_people"]); ?></span></p>
                        </div>
                        <div class="col-6">
                            <p><span class="label-text">Price:</span> <span class="value-text"><?php echo htmlspecialchars($row["price"]); ?></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row align-items-center mt-4">
                <div class="col-md-3 text-center">
                    <img src="<?php echo "../../" . htmlspecialchars($row["profile_image"]); ?>" alt="User Profile" class="profile-image img-fluid mb-3">
                    <h4 class="mb-0"><?php echo htmlspecialchars($row["first_name"] . " " . $row["last_name"]); ?></h4>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p><span class="label-text">Email:</span> <span class="value-text"><?php echo htmlspecialchars($row["email"]); ?></span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><span class="label-text">Gender:</span> <span class="value-text"><?php echo htmlspecialchars($row["gender"]); ?></span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><span class="label-text">Contact No.:</span> <span class="value-text"><?php echo htmlspecialchars($row["phone"]); ?></span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><span class="label-text">Pincode:</span> <span class="value-text"><?php echo htmlspecialchars($row["pincode"]); ?></span></p>
                        </div>
                        <div class="col-md-12">
                            <p><span class="label-text">Address:</span> <span class="value-text"><?php echo htmlspecialchars($row["address"]); ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php
include '../partials/footer.php';
?>
