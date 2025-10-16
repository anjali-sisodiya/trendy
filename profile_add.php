<?php
session_start();
include "dbconfig.php";
include 'header.php';
include 'nav.php';

if(isset($_POST['profile_submit']))
{ 
   $fileTmpPath = $_FILES['img']['tmp_name'];
   $fileName = "files/".$_FILES['img']['name'];     
   move_uploaded_file($fileTmpPath,$fileName);
   $user_id = $_SESSION["user_id"];
   $fname = $_POST["fname"];
   $lname = $_POST["lname"];   
   $email = $_POST["email"];
   $gender = $_POST["gender"];
   $phone = $_POST["phn"];
   $state = $_POST["state"];
   $city = $_POST["city"];
   $pincode = $_POST["pincode"];
   $address = $_POST["address"];

   $sql1 = "SELECT * FROM user_details WHERE user_id=".$_SESSION['user_id'];
   $result1 = $conn->query($sql1); 

   if($result1->num_rows == 0){
       $sql = "INSERT INTO user_details(user_id,first_name,last_name,profile_image,email,gender,phone,city_id,state_id,pincode,address) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
       $stmt=$conn->prepare($sql);
       $stmt->bind_param('issssssiiis',$user_id,$fname,$lname,$fileName,$email,$gender,$phone,$city,$state,$pincode,$address);
       if($stmt->execute()){
           echo "<div class='alert alert-success mt-3'>Profile successfully saved!</div>";
       }
       $stmt->close();
   }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <form method="post" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-light" style="max-width: 500px; width: 100%;">
    <h3 class="mb-4 text-primary fw-bold text-center">Complete Your Profile</h3>
    <div class="mb-3">
      <label for="fname" class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
      <input type="text" id="fname" name="fname" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="lname" class="form-label fw-semibold">Last Name</label>
      <input type="text" id="lname" name="lname" class="form-control">
    </div>
    <div class="mb-3">
      <label for="img" class="form-label fw-semibold">Profile Image <span class="text-danger">*</span></label>
      <input type="file" id="img" name="img" class="form-control" accept="image/*" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
      <input type="email" id="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="gender" class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
      <select id="gender" name="gender" class="form-select" required>
        <option value="" selected disabled>Select gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="phn" class="form-label fw-semibold">Phone Number</label>
      <input type="tel" id="phn" name="phn" class="form-control" pattern="[0-9]{10}" placeholder="10 digit phone number">
    </div>
    <div class="mb-3">
      <label for="state" class="form-label fw-semibold">State</label>
      <?php
        $sql1 = "SELECT * FROM state ORDER BY state_title ASC";
        $result = $conn->query($sql1);
      ?>
      <select name="state" id="state" class="form-select">
        <option value="" selected disabled>Select state</option>
        <?php
          while($row=$result->fetch_assoc()){                      
            echo "<option value='".$row['state_id']."'>".$row['state_title']."</option>";
          }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="city" class="form-label fw-semibold">City</label>
      <select name="city" id="city" class="form-select">
        <option value="" selected disabled>Select city</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="pincode" class="form-label fw-semibold">Pincode <span class="text-danger">*</span></label>
      <input type="text" id="pincode" name="pincode" class="form-control" required pattern="[0-9]{6}" placeholder="6 digit pincode">
    </div>
    <div class="mb-3">
      <label for="address" class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
      <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
    </div>
    <button type="submit" name="profile_submit" class="btn btn-primary w-100">Save Profile</button>
  </form>
</div>

<script type="text/javascript">
  $('#state').on('change', function() {
    var state_id = this.value;
    $.ajax({
      url: "admin/packages/getcity.php",
      type: "POST",
      data: { state_id: state_id },
      success: function(data) {
        $("#city").html(data);
      }
    });
  });
</script>

<?php
include 'footer.php';
?>
