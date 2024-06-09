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

        // Retrieve user input
        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        // Check if email already exists
        $checkemail = "SELECT * FROM users WHERE email = :email";
        $check = $connection->prepare($checkemail);
        $check->bindParam(':email', $email);
        $check->execute();
        $checkresults = $check->fetch(PDO::FETCH_ASSOC);
        if (!empty($checkresults)) {
            echo "false";
            exit;
        }

        // Password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $sql = "INSERT INTO users (first_name, last_name, email, phone, password, user_type) 
                VALUES (:firstName, :lastName, :email, :phone, :hashedPassword, 'client')";

        $stmt = $connection->prepare($sql);

        // Bind parameters for security (prevents SQL injection)
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':hashedPassword', $hashedPassword);

        $stmt->execute();

        // Set cookies
        setcookie('user_id', $connection->lastInsertId(), time() + (86400 * 30), "/"); // 30 days
        setcookie('user_email', $email, time() + (86400 * 30), "/"); // 30 days
        setcookie('user_type', 'client', time() + (86400 * 30), "/"); // 30 days

        echo "true";
    } catch(PDOException $e) {
        // Handle database errors gracefully
        echo "Error: " . $e->getMessage(); // You can improve the error message for the user
    }
} else {
    header("Location: ../html/signUp.html");
    exit;
}
?>
