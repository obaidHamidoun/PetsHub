<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $order_id = $_GET['id'];
    
    $removeQuery = "DELETE FROM orders WHERE order_id = :order_id"; 
    
    $stmt = $conn->prepare($removeQuery);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    
    echo "<script>window.location.href= 'orders.php'</script>";
} catch(PDOException $e) {
    echo "<script>alert('{$e->getMessage()}')</script>";
}
?>

<script src="../js/checkuser.js"></script>
