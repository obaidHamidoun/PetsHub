<?php

  $servername = 'localhost';
  $username = 'root';
  $pass = "";

  try {
    $connection = new PDO("mysql:host=$servername;dbname=petshub", $username, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $email = $_POST['email'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
      // Start a session and store the user's ID
      session_start();
      $_SESSION['user_id'] = $user['id']; // Store user ID in session

      // Redirect to home page
      header("Location: ../html/home.html");
      exit();
    } else {
      echo "Invalid email or password.";
    }

  } catch(PDOException $e) {
    // Handle database errors gracefully
    echo "Error: " . $e->getMessage(); // You can improve the error message for the user
  }
?>
