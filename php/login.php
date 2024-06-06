<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = 'localhost';
    $username = 'root';
    $password = ""; // Replace with your database password
    $dbname = 'petshub';

    try {
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if the email exists in the database
        $checkemail = "SELECT * FROM users WHERE email = :email";
        $check = $connection->prepare($checkemail);
        $check->bindParam(':email', $email);
        $check->execute();
        $user = $check->fetch(PDO::FETCH_ASSOC);

        if (empty($user)) {
            echo json_encode(["msg" => "false"]); // User not found
            exit;
        }
      
  

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            echo json_encode(["msg" => "true"]);
        } else {
            echo json_encode(["msg" => "false" ]); // Incorrect password
        }
    } catch(PDOException $e) {
        // Handle database errors gracefully
        echo json_encode(["msg" => "error", "error" => $e->getMessage()]);
    }
} else {
    // Redirect to sign-up page if the request method is not POST
    header("Location: ../html/signUp.html");
    exit;
}
?>
