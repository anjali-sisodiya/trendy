<?php
session_start();
include '../../../dbconfig.php';

$error = "";

if (isset($_POST['login'])) {
    $email1 = trim($_POST['email']);
    $password1 = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role_id = 1");
    $stmt->bind_param("s", $email1);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($row['password'] === md5($password1)) {
            $_SESSION['a_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['is_admin_login'] = true;

            header("Location: ../../index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not found or you don't have admin access.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login</title>
  <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css" />
  <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css" />
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <link rel="shortcut icon" href="../../assets/images/favicon.ico" />
  <style>
    .auth .auth-form-light {
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
    .brand-logo img {
      width: 150px;
      margin-bottom: 20px;
    }
    .custom-input {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 12px 15px;
      font-size: 15px;
      background-color: #fff;
    }
    .custom-input:focus {
      border-color: #4B49AC;
      box-shadow: 0 0 0 0.2rem rgba(75, 73, 172, 0.25);
    }
    .custom-btn {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      font-weight: 500;
      background: #4B49AC;
      border: none;
      border-radius: 5px;
      color: white;
      transition: background 0.3s ease;
    }
    .custom-btn:hover {
      background: #3a3897;
    }
    .error-message {
      color: red;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-md-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo text-center">
                <img src="../../assets/images/logo.svg" alt="logo" />
              </div>
              <h4 class="text-center">Welcome Back!</h4>
              <h6 class="text-center mb-4">Sign in to continue</h6>

             
              <?php if (!empty($error)) : ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
              <?php endif; ?>

              <form class="pt-3" method="post" action="">
                <div class="form-group">
                  <label>Email</label>
                  <input
                    type="email"
                    name="email"
                    class="form-control custom-input"
                    placeholder="Enter your email"
                    required
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                  />
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input
                    type="password"
                    name="password"
                    class="form-control custom-input"
                    placeholder="Enter your password"
                    required
                  />
                </div>
                <div class="mt-3">
                  <button type="submit" name="login" class="btn btn-primary custom-btn">
                    Login
                  </button>
                </div>
              </form>

             
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../../assets/js/off-canvas.js"></script>
  <script src="../../assets/js/hoverable-collapse.js"></script>
  <script src="../../assets/js/misc.js"></script>
</body>
</html>
