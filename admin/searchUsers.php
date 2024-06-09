<?php
$servername = 'localhost';
$username = 'root';
$pass = "";

try {
    $connection = new PDO("mysql:host=$servername;dbname=petshub", $username, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['searchUser']) && !empty($_GET['searchUser'])) {
        $search = $_GET['searchUser'];
        $sql = "SELECT * FROM users WHERE first_name LIKE :search OR last_name LIKE :search OR email LIKE :search";
        $stmt = $connection->prepare($sql);
        $stmt->execute(['search' => "%$search%"]);
    } else {
        $sql = "SELECT * FROM users";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
    }

    $results = $stmt->fetchAll();

    if ($results) {
        echo "<div class='table-container'>
            <table class='UsersTable'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Profile Picture</th>
                        <th>Edit</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>";
        
        foreach($results as $result){
            echo "<tr>
                <td>{$result['id']}</td>
                <td>{$result['first_name']}</td>
                <td>{$result['last_name']}</td>
                <td>{$result['email']}</td>
                <td>{$result['phone']}</td>
                <td><img src='images/{$result['profile_picture']}' alt='Profile Picture'></td>
                <td><button class='edit'><a href='EditPage.php?id={$result['id']}'>Edit</a></button></td>
                <td><button class='remove'><a href='RemovePage.php?id={$result['id']}'>Remove</a></button></td>
            </tr>";
        }
        
        echo "</tbody></table></div>";
    } else {
        echo "<p>No results found</p>";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<script src="../js/checkuser.js"></script>