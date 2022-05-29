<?php 
session_start();
unset($_SESSION['admin']);
// setcookie('adminLogin', "", strtotime("-2 days"), "/");
// session_destroy();
header("Location:login");
exit;
 ?>