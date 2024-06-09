<?php
// Clear cookies
setcookie("user_id", "", time() - 3600, "/");
setcookie("user_email", "", time() - 3600, "/");
setcookie("user_type", "", time() - 3600, "/");

// Redirect to home page
header("Location: ../html/home.html");
exit();
?>
