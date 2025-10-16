<?php
session_start();
include 'dbconfig.php';
$sql = "SELECT * FROM user_details WHERE user_id=".$_SESSION['user_id'];
$result = $conn->query($sql);
if($result->num_rows == 0){
  header("Location: profile_add.php");
}else{
  header("Location: userprofile.php");
}
?>