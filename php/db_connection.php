<?php
$servername = 'localhost';
$username = 'root';
$password = "";


     try{
      $connection = new PDO("mysql:host=$servername;dbname=users",$username,$password);
      $connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
      
      echo "<h3>connected sucessfully</h3>";

    }catch(PDOException $e){
     echo "<h3>connection failed</h3> <br>" . $e->getMessage();
    }

?>
