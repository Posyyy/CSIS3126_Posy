<?php
session_start();
session_destroy(); // Destroy all session data

// Redirect to home.php or index.html
header("Location: index.html"); // Change to index.html if preferred
exit();
?>
