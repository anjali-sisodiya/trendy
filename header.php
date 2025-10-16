
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
 <link rel="stylesheet" type="text/css" href="css/style.css"/> 

 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> 
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<body>

<nav class="nav bg-primary">
	<div class="container">
			<div class="row">
			<div ></div>
			<div class="col-md-4">
				<a class="nav-link active text-white contactno" aria-current="page" href="#"><i class="fa-solid fa-phone icon"></i> Any Questions? Call Us: 1-223-355-2214</a>
			</div>
			<div class="col-md-8 d-flex justify-content-end">

  <?php
  //Registration

  if(isset($_POST['submit']))
  {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $password = md5($pass);
    $role_id = $_POST['role_id'];

  $sql = "INSERT INTO users(first_name, last_name, email, password,role_id) VALUES(?,?,?,?,?)";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param('ssssi',$fname,$lname,$email,$password,$role_id);
  if($stmt->execute()){
    ?>
      <script type="text/javascript">
     swal({
  title: "You are succesfully registered!",
  icon: "success",
});

    </script>
    <?php
      }
  }

    //Login
  if(!isset($_SESSION['is_login'])){
    $_SESSION['is_login'] = false;
  }
   
    if (isset($_POST['login'])) {
    $email1 = trim($_POST['email']);
    $password1 = $_POST['password'];
    $uniq_id = $_POST['h_uniq_id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role_id = 2");
    $stmt->bind_param("s", $email1);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Check password
        if ($row['password'] === md5($password1)) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['is_login'] = true;

            if ($uniq_id == $_SESSION['uniq_id']) {
                echo "<script>
                    swal({
                        title: 'You are successfully logged in!',
                        icon: 'success'
                    });
                </script>";
            }
        } else {
            echo "<script>
                swal({
                    title: 'Incorrect password!',
                    icon: 'error'
                });
            </script>";
        }
    } else {
        echo "<script>
            swal({
                title: 'Email not found or you do not have user access!',
                icon: 'error'
            });
        </script>";
    }
}

  $_SESSION['uniq_id'] = uniqid();

  if($_SESSION['is_login']==false){
   ?>

				<a class="nav-link active text-white contactno" aria-current="page" data-bs-toggle="modal" data-bs-target="#exampleModal1" href="#"><i class="fa-solid fa-user"></i> Register Now</a>
    

				<a class="nav-link active text-white contactno" aria-current="page" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#"><i class="fa-solid fa-right-to-bracket"></i> Login</a>	

        <?php
      }else{
        ?>	

        <a class="nav-link active text-white contactno" aria-current="page" href="logout.php"><i class="fa-solid fa-right-to-bracket"></i> Logout</a>	

        <div class="dropdown">
  <button class="dropbtn"><i class="fa-solid fa-caret-down"></i> Account</button>
  <div class="dropdown-content">
    <a class="nav-link active text-dark contactno" aria-current="page" href="redirecturl.php"><i class="fa-solid fa-user"></i> Userprofile</a>
    <a class="nav-link active text-dark contactno" aria-current="page" href="user_cart.php"><i class="fa-solid fa-history"></i> cart history</a>
    
  </div>
</div>

        <?php
      }
        ?>	
			</div>
		</div>
	  </div>
</nav>

<!-- /////////////////////////// Registration ////////////////////////////////// -->
<div class="modal fade formtitle" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">SIGN UP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">First name</label>
            <input type="text" name="fname" class="form-control form" required>
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Last name</label>
            <input type="text" name="lname" class="form-control form">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Email Id</label>
            <input type="email" name="email" class="form-control form" required>
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Password</label>
            <input type="password" name="password" class="form-control form" required>
          </div>
           <input type="hidden" name="role_id" value="2" class="form-control form" required>

          <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-primary form formbtn">SIGN UP</button>
      </div>
        </form>
      </div>
      
    </div>
  </div>
</div>


<!-- //////////////////////////// Login ////////////////////////////////////////// -->
<div class="modal fade formtitle" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Email</label>
            <input type="email" name="email" class="form-control form" placeholder="Email Id" required>
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Password</label>
            <input type="password" name="password" class="form-control form" placeholder="Enter your Password" required>
          </div>
          <input type="hidden" name="h_uniq_id" value="<?php echo $_SESSION['uniq_id']?>">
          <div class="modal-footer">
        <button type="submit" name="login" class="btn btn-primary form formbtn">Login</button>
      </div>
        </form>
      </div>
      
    </div>
  </div>
</div>


