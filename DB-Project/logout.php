<?php
session_start();
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session
header("Location: index.html"); // Redirect to the main landing page
exit();
?>