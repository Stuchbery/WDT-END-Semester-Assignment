<?php 
session_start();
session_unset();
session_destroy();  //clears all session variables
header("Location: http://localhost/testWorldPic/login.php" );  //returns to login.php page
?>