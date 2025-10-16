<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['user_id']);
unset($_SESSION['is_login']);
header('location:index.php');
?>
