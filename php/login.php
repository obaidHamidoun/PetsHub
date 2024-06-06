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
            echo json_encode(["msg" => "user does not exist"]);
            exit;
        }
      
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type']; // Assuming 'user_type' is the column for user type in your database

            // Redirect based on user type
            if ($user['user_type'] === 'client') {
                echo json_encode(["msg" => "client", "redirect" => "../html/home.html"]);
            } elseif ($user['user_type'] === 'admin') {
                echo json_encode(["msg" => "admin", "redirect" => "../admin/index.php"]);
            }
        } else {
            echo json_encode(["msg" => "false" ]);
        }
    } catch(PDOException $e) {
        echo json_encode(["msg" => "error", "error" => $e->getMessage()]);
    }
} else {
    header("Location: ../html/signUp.html");
    exit;
}
?>
