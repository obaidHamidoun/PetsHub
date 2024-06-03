<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//      $servername = 'localhost';
//      $username = 'root';
//      $password = "";
//      try{
//       $connection = new PDO("mysql:host=$servername;dbname=users",$username,$password);
//       $connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
      
//       echo "<h3>connected sucessfully</h3>";


//       $firstName = $_POST['fname'];
//       $lastName = $_POST['lname'];
//       $email = $_POST['email'];
//       $phone = $_POST['phone'];
//       $password = $_POST['password'];
  
//       $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      
//       $sql = "INSERT INTO users (first_name, last_name, email, phone, password) 
//               VALUES ('$firstName', '$lastName', '$email', '$phone', '$hashedPassword')";
      
//       if (mysqli_query($connection, $sql)) {
//           echo "User registered successfully";
//       } else {
//           // Error inserting user data
//           echo "Error: " . $sql . "<br>" . mysqli_error($connection);
//       }
      
//       // Close database connection
//       mysqli_close($conn);
      

//     }catch(PDOException $e){
//      echo "<h3>connection failed</h3> <br>" . $e->getMessage();
//     }



// }

?>