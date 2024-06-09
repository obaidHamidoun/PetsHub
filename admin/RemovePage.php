<?php

 try{
    $conn = new PDO("mysql:host=localhost;dbname=petshub",'root','');
    $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $user_id = $_GET['id'];
    $removeQuerry = "DELETE FROM users WHERE id = :user_id";
    $stmt = $conn->prepare($removeQuerry);
    $stmt->bindParam(':user_id' , $user_id);
    $stmt->execute();
    echo "<br><p class='errMessage'>user removed succesfully</p>";
    echo "<script>window.location.href= 'users.php'</script>";

    }catch(PDOException $e){
    echo "<script>alert('{$e->getMessage()}')</script>";
    }
   ?>

<script src="../js/checkuser.js"></script>
