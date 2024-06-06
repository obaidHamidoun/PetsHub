<?php
session_start();

// if (!isset($_SESSION['username'])) {
//     header("Location: ../html/index.html");
//     exit();
// }

?>

<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'petshub';

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT COUNT(*) AS user_count FROM users";
    $productnum = "SELECT COUNT(*) AS product_count FROM products";
    $toysCount = "SELECT COUNT(*) AS toys_count FROM products WHERE product_category = 'Toys and Accessories'";
    $groomingCount = "SELECT COUNT(*) AS grooming_count FROM products WHERE product_category = 'Grooming Supplies'";
    $beddingCount = "SELECT COUNT(*) AS bedding_count FROM products WHERE product_category = 'Bedding and Comfort'";
    $foodCount = "SELECT COUNT(*) AS food_count FROM products WHERE product_category = 'Food and Feeding'";

    $stmt = $connection->prepare($sql);
    $stm = $connection->prepare($productnum);
    $toysStmt = $connection->prepare($toysCount);
    $groomingStmt = $connection->prepare($groomingCount);
    $beddingStmt = $connection->prepare($beddingCount);
    $foodStmt = $connection->prepare($foodCount);

    $stmt->execute();
    $stm->execute();
    $toysStmt->execute();
    $groomingStmt->execute();
    $beddingStmt->execute();
    $foodStmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $numOfpro = $stm->fetch(PDO::FETCH_ASSOC);
    $toysResult = $toysStmt->fetch(PDO::FETCH_ASSOC);
    $groomingResult = $groomingStmt->fetch(PDO::FETCH_ASSOC);
    $beddingResult = $beddingStmt->fetch(PDO::FETCH_ASSOC);
    $foodResult = $foodStmt->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetsHub Admin Dashboard</title>
    <link rel="icon" href="images/adminIcon.png">
    <style>
        @font-face {
            font-family: 'Black';
            src: url('../fonts/MPLUSRounded1c-Black.ttf');
        }
        @font-face {
            font-family: 'Medium';
            src: url('../fonts/MPLUSRounded1c-Medium.ttf');
        }
        @font-face {
            font-family: 'ExtraBold';
            src: url('../fonts/MPLUSRounded1c-ExtraBold.ttf');
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
            flex-direction: column;
            font-family: 'ExtraBold';
        }
        .sidebar {
            width: 250px;
            background-color: #3D67FF;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            height: 100%;
            position: fixed;
            transition: transform 0.3s ease;
        }
        .sidebar.hidden {
            transform: translateX(-250px);
        }
        .logo {
            margin-bottom: 20px;
        }
        .logo img {
            width: 100px;
        }
        .menu {
            list-style: none;
            padding: 0;
            width: 100%;
        }
        .menu li {
            width: 100%;
        }
        .menu li a {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }
        .menu li a:hover, .menu li a.active {
            background-color: #1649ff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #F4F4F4;
            flex-grow: 1;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
        }
        .content.shifted {
            margin-left: 0;
        }
        .dashboard-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .dashboard-stats .stat {
            background-color: #3D67FF;
            color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            flex-grow: 1;
            min-width: 150px;
        }
        .topbar {
            display: none;
            width: 100%;
            background-color: #3D67FF;
            color: white;
            padding: 10px 20px;
            box-sizing: border-box;
            align-items: center;
            justify-content: space-between;
            flex-direction: column;
        }
        .menu-icon {
            font-size: 24px;
            cursor: pointer;
        }
        .topbar .menu {
            display: flex;
            flex-direction: column;
            width: 100%;
            align-items: center;
        }
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .content {
                margin-left: 0;
            }
            .topbar {
                display: flex;
            }
        }
        #home > h1 {
            color: #3D67FF;
        }
        .AddContainer {
            display: flex;
            flex-direction: column;
            padding: 2vw;
            gap: 2Vw;
        }
        .AddContainer>button {
            padding: 2vw;
            font-size: 2vw;
            background-color: #3D67FF;
            border: none;
            border-radius: 1vw;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <img src="../images/index/whiteIcon.png" alt="PetsHub Logo">
        </div>
        <ul class="menu">
            <li><a href="#" class="active" onclick="showSection(event, 'home')">Home</a></li>
            <li><a href="#" onclick="window.location.href = 'users.php'">Users</a></li>
            <li><a href="#" onclick="window.location.href = 'products.php'">Products</a></li>
            <li><a href="#" onclick="showSection(event, 'pets')">Pets</a></li>
            <li><a href="#" onclick="showSection(event, 'settings')">Settings</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </div>
    <div class="topbar" id="topbar">
        <div class="logo">
            <img src="../images/index/whiteIcon.png" alt="PetsHub Logo">
        </div>
        <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
        <ul class="menu" id="topbarMenu">
            <li><a href="#" class="active" onclick="showSection(event, 'home')">Home</a></li>
            <li><a href="#" onclick="window.location.href = 'users.php'">Users</a></li>
            <li><a href="#" onclick="window.location.href = 'products.php'">Products</a></li>
            <li><a href="#" onclick="showSection(event, 'pets')">Pets</a></li>
            <li><a href="#" onclick="showSection(event, 'settings')">Settings</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </div>
    <div class="content" id="content">
        <div id="home" class="section">
            <h1>PetsHub Admin Dashboard</h1>
            <div class="dashboard-stats">
                <div class="stat">
                    <h2>Total Products</h2>
                    <?php echo "<h1>{$numOfpro['product_count']}</h1>" ?>
                </div>
                <div class="stat">
                    <h2>Total Users</h2>
                    <?php echo "<h1>{$result['user_count']}</h1>" ?>
                </div>
                <div class="stat">
                    <h2>Toys and Accessories</h2>
                    <?php echo "<h1>{$toysResult['toys_count']}</h1>" ?>
                </div>
                <div class="stat">
                    <h2>Grooming Supplies</h2>
                    <?php echo "<h1>{$groomingResult['grooming_count']}</h1>" ?>
                </div>
                <div class="stat">
                    <h2>Bedding and Comfort</h2>
                    <?php echo "<h1>{$beddingResult['bedding_count']}</h1>" ?>
                </div>
                <div class="stat">
                    <h2>Food and Feeding</h2>
                    <?php echo "<h1>{$foodResult['food_count']}</h1>" ?>
                </div>
            </div>
        </div>
        <div id="users" class="section" style="display:none;">
            <h1>Users</h1>
            <p>Manage your users here.</p>
        </div>
        <div id="products" class="section" style="display:none;">
            <h1>Products</h1>
            <p>Manage your products here.</p>
        </div>
        <div id="pets" class="section" style="display:none;">
            <h1>Pets</h1>
            <p>Manage your pets here.</p>
        </div>
        <div id="settings" class="section" style="display:none;">
            <h1>Settings</h1>
            <p>Adjust your settings here.</p>
                  
            <div class="AddContainer">
                <button class="Add" onclick="window.location.href='addproduct.php'">Add Product</button>          
                <button class="Add">Add Pet</button>               
                <button class="Add">Sells</button>
            </div>    
        </div>
    </div>
    <script>
        function showSection(event, section) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(sec => sec.style.display = 'none');
            document.getElementById(section).style.display = 'block';
            const menuItems = document.querySelectorAll('.menu li a');
            menuItems.forEach(item => item.classList.remove('active'));
            event.target.classList.add('active');
        }
        function toggleMenu() {
            const menu = document.getElementById('topbarMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
    </script>



</body>
</html>
