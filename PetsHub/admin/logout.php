<?php
// Clear cookies
setcookie("user_id", "", time() - 3600, "/");
setcookie("user_email", "", time() - 3600, "/");
setcookie("user_type", "", time() - 3600, "/");

header("Location: ../html/home.html");
exit();
?>
