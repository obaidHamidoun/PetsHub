<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'petshub';

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_Food = "SELECT * FROM products WHERE product_category = 'Food and Feeding' LIMIT 6";
    $stmt_Food = $connection->prepare($sql_Food);
    $stmt_Food->execute();
    $foods = $stmt_Food->fetchAll(PDO::FETCH_ASSOC);

    foreach ($foods as $food) {
        $imageData = base64_encode($food['product_picture']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        echo "<div class='product'>
                    <div class='product-Pic' style='background:url({$imageSrc});background-size:cover;background-repeat:no-repeat;background-position:50% 50%'></div>
                    <div class='proNameDiv'><p>{$food['product_name']}</p></div>
                    <div class='ProPrice'><p>{$food['product_price']} MAD</p></div>
                    <div class='ProCat'><p>{$food['product_category']}</p></div>
                    <div class='buyCart'>
                        <button class='BuyNow' proId='{$food['product_id']}' onclick=window.location.href=`productBuyPage.php?id={$food['product_id']}`>Buy now</button>
                    </div>
                </div>";
    }
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
