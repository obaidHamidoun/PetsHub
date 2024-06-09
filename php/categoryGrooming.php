<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'petshub';

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_groom = "SELECT * FROM products WHERE product_category = 'Grooming Supplies' LIMIT 6";
    $sql_groom = $connection->prepare($sql_groom);
    $sql_groom->execute();
    $grooms = $sql_groom->fetchAll(PDO::FETCH_ASSOC);

    foreach ($grooms as $groom) {
        $imageData = base64_encode($groom['product_picture']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        echo "<div class='product'>
                    <div class='product-Pic' style='background:url({$imageSrc});background-size:cover;background-repeat:no-repeat;background-position:50% 50%'></div>
                    <div class='proNameDiv'><p>{$groom['product_name']}</p></div>
                    <div class='ProPrice'><p>{$groom['product_price']} MAD</p></div>
                    <div class='ProCat'><p>{$groom['product_category']}</p></div>
                    <div class='buyCart'>
                        <button class='addToCart' proId='{$groom['product_id']}' >Add To Cart</button>
                        <button class='BuyNow' proId='{$groom['product_id']}'>Buy now</button>
                    </div>
                </div>";
    }
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
