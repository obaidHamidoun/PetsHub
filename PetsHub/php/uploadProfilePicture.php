<?php
try {
    $connection = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_FILES['profile_picture'])) {
        echo "Error: No file uploaded.";
        exit();
    }

    // Access uploaded file via $_FILES
    $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
    $fileSize = $_FILES['profile_picture']['size'];
    $fileType = $_FILES['profile_picture']['type'];

    // Check if the file is an image
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg'];
    if (!in_array($fileType, $allowedTypes)) {
        echo "Error: Only JPG, PNG, SVG , and GIF files are allowed.";
        exit();
    }

    if ($fileSize > 0) {
        $userId = $_COOKIE['user_id'];
        $fileContent = file_get_contents($fileTmpPath);

        $updatePfpQuery = "UPDATE users SET profile_picture = :profile_picture WHERE id = :id";
        $stmt = $connection->prepare($updatePfpQuery);

        $stmt->bindParam(':profile_picture', $fileContent, PDO::PARAM_LOB);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        echo "Profile picture updated successfully.";
    } else {
        echo "Error: File is empty or too large.";
    }
} catch (PDOException $err) {
    echo "Error: " . $err->getMessage();
}

?>
