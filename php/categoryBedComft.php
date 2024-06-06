<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'petshub';

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_comfort = "SELECT * FROM products WHERE product_category = 'Bedding and Comfort' LIMIT 6";
    $stmt_comfort = $connection->prepare($sql_comfort);
    $stmt_comfort->execute();
    $comforts = $stmt_comfort->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comforts as $comfort) {
        $imageData = base64_encode($comfort['product_picture']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        echo "<div class='product'>
                    <div class='product-Pic' style='background:url({$imageSrc});background-size:cover;background-repeat:no-repeat;background-position:50% 50%'></div>
                    <div class='proNameDiv'><p>{$comfort['product_name']}</p></div>
                    <div class='ProPrice'><p>{$comfort['product_price']} MAD</p></div>
                    <div class='ProCat'><p>{$comfort['product_category']}</p></div>
                    <div class='buyCart'>
                        <button class='addToCart' proId='{$comfort['product_id']}'>Add To Cart</button>
                        <button class='BuyNow' proId='{$comfort['product_id']}'>Buy now</button>
                    </div>
                </div>";
    }
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
