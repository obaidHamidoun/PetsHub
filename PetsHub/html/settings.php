<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'petshub';

try {
    // Create connection to the database
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get user ID from cookie
    $userId = $_COOKIE['user_id'];

    // Fetch current user data
    $sql_fetch = "SELECT * FROM users WHERE id = :id";
    $stmt_fetch = $connection->prepare($sql_fetch);
    $stmt_fetch->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt_fetch->execute();
    $user = $stmt_fetch->fetch(PDO::FETCH_ASSOC);

    // Handle general info form submission
    if (isset($_POST['update_info'])) {
        $first_name = htmlspecialchars($_POST['first_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);

        // Update user data
        $sql_update = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone WHERE id = :id";
        $stmt_update = $connection->prepare($sql_update);
        $stmt_update->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt_update->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt_update->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_update->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt_update->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt_update->execute();

        echo "<script>alert('Profile information updated successfully!');</script>";
    }

    // Handle profile picture update form submission
    if (isset($_POST['update_picture']) && !empty($_FILES['profile_picture']['tmp_name'])) {
        $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);
        $sql_update_pic = "UPDATE users SET profile_picture = :profile_picture WHERE id = :id";
        $stmt_update_pic = $connection->prepare($sql_update_pic);
        $stmt_update_pic->bindParam(':profile_picture', $profile_picture, PDO::PARAM_LOB);
        $stmt_update_pic->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt_update_pic->execute();

        echo "<script>alert('Profile picture updated successfully!');</script>";
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
@font-face {
    font-family:'Black';
    src: url('../fonts/MPLUSRounded1c-Black.ttf');
}

@font-face {
    font-family:'Medium';
    src: url('../fonts/MPLUSRounded1c-Medium.ttf');
}

@font-face {
    font-family:'ExtraBold';
    src: url('../fonts/MPLUSRounded1c-ExtraBold.ttf');
}
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            font-family:'ExtraBold';
            color:#3D67FF;
        }
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }
        .btn-back , .btn-secondary{
            margin-bottom: 20px;
            display: block;
            width: 100%;
            text-align: left;
            background:#3D67FF;
        }

        .btn-secondary{
            text-align:center;
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <a href="home.html" class="btn btn-secondary btn-back">&larr; Back to Home</a>

        <h1 class="text-center">Edit Profile</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
            </div>
            <!-- Separate Submission Button for General Info -->
            <button type="submit" name="update_info" class="btn btn-primary mb-4">Update Information</button>

            <div class="mb-3 text-center">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($user['profile_picture']) ?>" alt="Profile Picture" class="profile-picture mt-3">
                <?php endif; ?>
            </div>
            <!-- Separate Submission Button for Profile Picture -->
            <button type="submit" name="update_picture" class="btn btn-secondary">Update Profile Picture</button>
        </form>
    </div>
</body>
</html>
