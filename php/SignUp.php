<?php
  // Check if form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Print out $_POST array for debugging
    print_r($_POST);

    // Database connection details
    $servername = 'localhost';
    $username = 'root';
    $pass = "";

    try {
      $connection = new PDO("mysql:host=$servername;dbname=petshub", $username, $pass);
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Retrieve user input
      $firstName = $_POST['fname'];
      $lastName = $_POST['lname'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $password = $_POST['password'];

      // Password hashing
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Prepare SQL statement
      $sql = "INSERT INTO users (first_name, last_name, email, phone, password) 
               VALUES (:firstName, :lastName, :email, :phone, :hashedPassword)";

      $stmt = $connection->prepare($sql);

      // Bind parameters for security (prevents SQL injection)
      $stmt->bindParam(':firstName', $firstName);
      $stmt->bindParam(':lastName', $lastName);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':phone', $phone);
      $stmt->bindParam(':hashedPassword', $hashedPassword);

      // Execute the statement
      $stmt->execute();

      // Start a session and store the user's ID (assuming you fetch the ID after inserting)
      session_start();
      $_SESSION['user_id'] = $connection->lastInsertId(); // Store user ID in session
      $_SESSION['signup_success'] = true;

      // Redirect to home page
      header("Location: ../html/home.html");
      exit;

    } catch(PDOException $e) {
      // Handle database errors gracefully
      echo "Error: " . $e->getMessage(); // You can improve the error message for the user
    }
  } else {
    // Redirect back to the sign-up page if the form is not submitted
    header("Location: ../html/signUp.html");
    exit;
  }
?>
