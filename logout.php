<?php
session_start();
session_unset();       // Clear session variables
session_destroy();     // Destroy session

// Optional: Prevent browser from caching pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Location: login.php");
exit();
