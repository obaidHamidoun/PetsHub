<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $user_id = $_GET['id'];

    // Delete related orders first
    $deleteOrdersQuery = "DELETE FROM orders WHERE user_id = :user_id";
    $stmtOrders = $conn->prepare($deleteOrdersQuery);
    $stmtOrders->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmtOrders->execute();

    // Now delete the user
    $deleteUserQuery = "DELETE FROM users WHERE id = :user_id";
    $stmtUser = $conn->prepare($deleteUserQuery);
    $stmtUser->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmtUser->execute();

    echo "<br><p class='errMessage'>User removed successfully</p>";
    echo "<script>window.location.href = 'users.php'</script>";

} catch(PDOException $e) {
    echo "<script>alert('{$e->getMessage()}')</script>";
}
?>
