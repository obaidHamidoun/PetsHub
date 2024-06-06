<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in
    $user_id = $_SESSION['user_id'];
    
    // Database connection details
    $servername = 'localhost';
    $username = 'root';
    $pass = '';
    $dbname = 'petshub';

    try {
        // Create connection
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute query to fetch user information
        $getUser = "SELECT * FROM users WHERE id = :user_id";
        $stmt = $connection->prepare($getUser);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch user data
        $resultOfuser = $stmt->fetch(PDO::FETCH_ASSOC);

        // Response array with user data
        $response = array(
            'loggedIn' => true,
            'userId' => $user_id,
            'userData' => $resultOfuser
        );
    } catch(PDOException $e) {
        // Error occurred while fetching user data
        $response = array('error' => 'Database error: ' . $e->getMessage());
    }
} else {
    // User is not logged in
    $response = array('loggedIn' => false);
    echo "<script>window.location.href = 'php/SignUp.php'</script>";
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
