<?php
session_start();
include "dbconfig.php";
include 'header.php';
include 'nav.php';

$sql = "SELECT * FROM user_details ud 
        JOIN state s ON ud.state_id = s.state_id 
        JOIN city c ON ud.city_id = c.id 
        WHERE user_id = ".$_SESSION['user_id'];
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
?>

<!-- ✨ Profile CSS -->
<style>
  body {
    background-color: #f1f3f6;
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    padding: 0;
  }

  .profile-wrapper {
  max-width: 960px;
  margin: 15px auto;
  background-color: #f0f4f8; 
  padding: 50px 60px;
  border-radius: 18px;
  box-shadow:
    0 4px 15px rgba(0, 0, 0, 0.1),
    0 10px 40px rgba(0, 0, 0, 0.18);
  display: flex;
  flex-wrap: wrap;
  gap: 40px;
  border: 1px solid #dde3f0;
  transition: box-shadow 0.3s ease;
}



  .profile-left {
    flex: 1 1 220px;
    text-align: center;
    padding-right: 30px;
    border-right: 1px solid #e9ecef;
  }

  .profile-left img {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #dee2e6;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.07);
  }

  .profile-name {
    margin-top: 20px;
    font-size: 24px;
    font-weight: 700;
    color: #2c3e50;
  }

  .profile-email {
    font-size: 14px;
    color: #6c757d;
    font-weight: 500;
  }

  .profile-right {
    flex: 2 1 400px;
  }

  .info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px 40px;
  }

  .info-box {
    background-color: #f9fbfd;
    padding: 16px 20px;
    border-radius: 10px;
    border: 1px solid #dee2e6;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);
  }

  .info-label {
    font-size: 12px;
    text-transform: uppercase;
    font-weight: 600;
    color: #8898aa;
    margin-bottom: 6px;
  }

  .info-value {
    font-size: 16px;
    color: #212529;
    font-weight: 500;
  }

  .edit-btn {
    margin-top: 35px;
    display: inline-block;
    background-color: #007bff;
    color: white;
    font-weight: 500;
    padding: 10px 25px;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s;
  }

  .edit-btn:hover {
    background-color: #0056b3;
  }

  @media (max-width: 768px) {
    .profile-wrapper {
      flex-direction: column;
      padding: 30px 25px;
    }

    .profile-left {
      border-right: none;
      padding-right: 0;
      padding-bottom: 20px;
      border-bottom: 1px solid #e3e6ef;
    }

    .info-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<!-- ✨ Profile HTML -->
<div class="profile-wrapper">
  <div class="profile-left">
    <img src="<?php echo htmlspecialchars($row['profile_image']); ?>" alt="Profile Picture">
    <div class="profile-name"><?php echo htmlspecialchars($row["first_name"] . " " . $row["last_name"]); ?></div>
    <div class="profile-email"><?php echo htmlspecialchars($row["email"]); ?></div>
  </div>

  <div class="profile-right">
    <div class="info-grid">
      <div class="info-box">
        <div class="info-label">Phone</div>
        <div class="info-value"><?php echo htmlspecialchars($row["phone"]); ?></div>
      </div>
      <div class="info-box">
        <div class="info-label">Gender</div>
        <div class="info-value"><?php echo htmlspecialchars($row["gender"]); ?></div>
      </div>
      <div class="info-box">
        <div class="info-label">State</div>
        <div class="info-value"><?php echo htmlspecialchars($row["state_title"]); ?></div>
      </div>
      <div class="info-box">
        <div class="info-label">City</div>
        <div class="info-value"><?php echo htmlspecialchars($row["name"]); ?></div>
      </div>
      <div class="info-box">
        <div class="info-label">Pincode</div>
        <div class="info-value"><?php echo htmlspecialchars($row["pincode"]); ?></div>
      </div>
      <div class="info-box" style="grid-column: span 2;">
        <div class="info-label">Address</div>
        <div class="info-value"><?php echo htmlspecialchars($row["address"]); ?></div>
      </div>
    </div>

    <a href="user_profile_edit.php" class="edit-btn">✏️ Edit Profile</a>
  </div>
</div>

<?php
}
include 'footer.php';
?>
