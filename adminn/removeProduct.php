<?php

 try{
    $conn = new PDO("mysql:host=localhost;dbname=petshub",'root','');
    $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $product_id = $_GET['id'];
    $removeQuerry = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($removeQuerry);
    $stmt->bindParam(':product_id' , $product_id);
    $stmt->execute();
    echo "<br><p class='errMessage'>product removed succesfully</p>";
    echo "<script>window.location.href= 'products.php'</script>";

    }catch(PDOException $e){
    echo "<script>alert('{$e->getMessage()}')</script>";
    }
   ?>
