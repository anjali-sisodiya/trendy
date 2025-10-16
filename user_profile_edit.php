<?php
session_start();
include "dbconfig.php";
include 'header.php';
include 'nav.php'; 

$sql = "SELECT * FROM user_details WHERE user_id=" . $_SESSION['user_id'];
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $email = trim($_POST["email"]);
    $gender = trim($_POST["gender"]);
    $phone = trim($_POST["phn"]);
    $pincode = trim($_POST["pincode"]);
    $address = trim($_POST["address"]);
    
    $fileChanged = !empty($_FILES['img']['tmp_name']);
    $fileName = $row['profile_image'];

    if ($fileChanged) {
        $fileTmpPath = $_FILES['img']['tmp_name'];
        $fileName = "files/" . uniqid() . "_" . $_FILES['img']['name'];
        move_uploaded_file($fileTmpPath, $fileName);
    }

    if (
        $fname !== $row['first_name'] ||
        $lname !== $row['last_name'] ||
        $email !== $row['email'] ||
        $gender !== $row['gender'] ||
        $phone !== $row['phone'] ||
        $pincode !== $row['pincode'] ||
        $address !== $row['address'] ||
        ($fileChanged && $fileName !== $row['profile_image'])
    ) {
        $sql1 = "UPDATE user_details SET first_name=?, last_name=?, profile_image=?, email=?, gender=?, phone=?, pincode=?, address=? WHERE user_id=" . $_SESSION['user_id'];
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('ssssssis', $fname, $lname, $fileName, $email, $gender, $phone, $pincode, $address);

        if ($stmt1->execute()) {
            echo '<script>
                swal({
                    title: "Your profile has been updated successfully!",
                    icon: "success"
                });
            </script>';
            $row['first_name'] = $fname;
            $row['last_name'] = $lname;
            $row['profile_image'] = $fileName;
            $row['email'] = $email;
            $row['gender'] = $gender;
            $row['phone'] = $phone;
            $row['pincode'] = $pincode;
            $row['address'] = $address;
        } else {
            echo "Oops... there was something wrong! Please try again.";
        }
    } else {
        echo '<script>
            swal({
                title: "No changes made!",
                icon: "info"
            });
        </script>';
    }
}
?>

<style>
  .update-container {
  max-width: 600px;
  margin: 40px auto;
  padding: 30px 25px;
  background: #fff;
  border-radius: 10px;
  /* shadow all around (top, left, right, bottom) */
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
}


  .userimg_updatepage {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    margin-top: 10px;
    border: 2px solid #4CAF50;
  }
  .form-label {
    font-weight: 600;
  }
  .updatebtn {
    width: 100%;
    padding: 12px;
    font-size: 1.1rem;
    font-weight: 600;
  }
</style>

<div class="update-container">
  <h2 class="mb-4 text-center text-success">Update Your Profile</h2>

  <form method="post" enctype="multipart/form-data" novalidate>
    <div class="mb-3">
      <label for="fname" class="form-label">First name</label>
      <input type="text" id="fname" name="fname" class="form-control" required value="<?php echo htmlspecialchars($row["first_name"]); ?>">
    </div>

    <div class="mb-3">
      <label for="lname" class="form-label">Last name</label>
      <input type="text" id="lname" name="lname" class="form-control" value="<?php echo htmlspecialchars($row["last_name"]); ?>">
    </div>

    <div class="mb-3">
      <label for="img" class="form-label">Profile Image</label>
      <input type="file" id="img" name="img" class="form-control" accept="image/*">
      <img src="<?php echo htmlspecialchars($row["profile_image"]); ?>" alt="Profile Image" class="userimg_updatepage">
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($row["email"]); ?>">
    </div>

    <div class="mb-3">
      <label for="gender" class="form-label">Gender</label>
      <select id="gender" name="gender" class="form-select" required>
        <option value="" disabled <?php echo empty($row['gender']) ? 'selected' : '' ?>>Select Gender</option>
        <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
        <option value="Other" <?php echo ($row['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="phn" class="form-label">Phone Number</label>
      <input type="tel" id="phn" name="phn" class="form-control" pattern="[0-9]{10}" placeholder="10 digit phone number" value="<?php echo htmlspecialchars($row["phone"]); ?>">
    </div>

    <div class="mb-3">
      <label for="pincode" class="form-label">Pincode</label>
      <input type="text" id="pincode" name="pincode" class="form-control" pattern="[0-9]{6}" placeholder="6 digit pincode" value="<?php echo htmlspecialchars($row["pincode"]); ?>">
    </div>

    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <textarea id="address" name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($row["address"]); ?></textarea>
    </div>

    <button type="submit" name="update" class="btn btn-success updatebtn">Update Profile</button>
  </form>
</div>

<?php include 'footer.php'; ?>
