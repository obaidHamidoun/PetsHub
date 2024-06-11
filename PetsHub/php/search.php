<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'petshub';


$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

try {

    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "SELECT * FROM products WHERE product_name LIKE :searchTerm OR product_description LIKE :searchTerm";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $result) {

        $imageData = base64_encode($result['product_picture']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        $product_name = $result['product_name'];
        $product_picture = $result['product_picture'];
        $product_price = $result['product_price'];
        $product_category = $result['product_category'];
        $product_id = $result['product_id'];


        echo "<div class='product'>
                    <div class='product-Pic' style='background:url({$imageSrc});background-size:cover;backgroun-repeat:no-repeat;background-position:50% 50%'></div>
                       <div class='proNameDiv'><p>{$product_name}</p></div>
                       <div class='ProPrice'><p>{$product_price} MAD</p></div>
                       <div class='ProCat'><p>{$product_category}</p></div>
                       <div class='buyCart'>

                           <button class='BuyNow' proId='{$product_id}' onclick=window.location.href=`productBuyPage.php?id={$product_id}`>Buy now</button>
                       </div>
                       </div>";
    }
} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
}
?>


<!-- <button class='addToCart' proId='{$product_id}' >Add To Cart</button> -->