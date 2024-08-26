<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page (adjust the URL accordingly)
header("Location: login.php");
exit();
?>
