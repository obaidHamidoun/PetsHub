<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'petshub';

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_toys = "SELECT * FROM products WHERE product_category = 'Toys and Accessories' LIMIT 6";
    $stmt_toys = $connection->prepare($sql_toys);
    $stmt_toys->execute();
    $toys = $stmt_toys->fetchAll(PDO::FETCH_ASSOC);

    foreach ($toys as $toy) {
        $imageData = base64_encode($toy['product_picture']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        echo "<div class='product'>
                    <div class='product-Pic' style='background:url({$imageSrc});background-size:cover;background-repeat:no-repeat;background-position:50% 50%'></div>
                    <div class='proNameDiv'><p>{$toy['product_name']}</p></div>
                    <div class='ProPrice'><p>{$toy['product_price']} MAD</p></div>
                    <div class='ProCat'><p>{$toy['product_category']}</p></div>
                    <div class='buyCart'>
                        <button class='addToCart' proId='{$toy['product_id']}' >Add To Cart</button>
                        <button class='BuyNow' proId='{$toy['product_id']}' onclick=window.location.href=`productBuyPage.php?id={$toy['product_id']}`>Buy now</button>
                    </div>
                </div>";
    }
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
