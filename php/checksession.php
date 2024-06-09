<?php
session_start();

$response = array();

// Check if the user is logged in based on the presence of cookies
if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_email']) && isset($_COOKIE['user_type'])) {
    // User is logged in
    $user_id = $_COOKIE['user_id'];
    $user_email = $_COOKIE['user_email'];
    $user_type = $_COOKIE['user_type'];

    // Database connection details
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'petshub';

    try {
        // Create connection
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch user data including profile picture
        $getUser = "SELECT id, first_name, last_name, email, phone, profile_picture FROM users WHERE id = :user_id";
        $stmt = $connection->prepare($getUser);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultOfuser = $stmt->fetch(PDO::FETCH_ASSOC);

        // Encode the profile picture as base64
        $profile_picture = base64_encode($resultOfuser['profile_picture']);

        // Remove the profile_picture from the result array
        unset($resultOfuser['profile_picture']);

        // Include the base64 encoded profile picture in the result array
        $resultOfuser['profile_picture_base64'] = $profile_picture;

        // Response array with user data
        $response = array(
            'loggedIn' => true,
            'userId' => $user_id,
            'userData' => $resultOfuser
        );
        echo json_encode($response);
    } catch(PDOException $e) {
        // Error occurred while fetching user data
        $response = array('error' => 'Database error: ' . $e->getMessage());
        echo json_encode($response);
    }
} else {
    // User is not logged in
    echo "User is not logged in";
}
?>
