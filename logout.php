<?php
session_start();

session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

//pergi ke login
header("Location: login.php");
exit();
?>
