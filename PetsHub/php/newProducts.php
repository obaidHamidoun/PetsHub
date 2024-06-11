<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'petshub';

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $latestProductsQuery = "SELECT * FROM products ORDER BY product_id DESC LIMIT 6";
    $latestStmt = $connection->prepare($latestProductsQuery);
    $latestStmt->execute();
    $latestProducts = $latestStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($latestProducts as $last){

        $imageData = base64_encode($last['product_picture']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        $product_name = $last['product_name'];
        $product_picture = $last['product_picture'];
        $product_price = $last['product_price'];
        $product_category = $last['product_category'];
        $product_id = $last['product_id'];

        echo " <div class='product'>
        <div class='product-Pic' style='background:url({$imageSrc});background-size:cover;backgroun-repeat:no-repeat;background-position:50% 50%'></div>
        <div class='proNameDiv'><p>{$product_name}</p></div>
        <div class='ProPrice'><p>{$product_price} MAD</p></div>
        <div class='ProCat'><p>{$product_category}</p></div>
        <div class='buyCart'>
            <button class='BuyNow' proId='{$product_id}' onclick=window.location.href=`productBuyPage.php?id={$product_id}`>Buy now</button>
        </div></div>";
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

