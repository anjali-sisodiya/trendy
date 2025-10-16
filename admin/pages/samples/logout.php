<?php
include '../../../dbconfig.php';    
session_start();
unset($_SESSION['a_email']);
unset($_SESSION['is_admin_login']);
unset($_SESSION['admin_id']);
header("Location: login.php");



?>