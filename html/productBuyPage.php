<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'petshub';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetsHub</title>
    <link rel="icon" href="../images/index/whiteIcon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/shop.css">

    <style>

        @media (max-width:800px){
            body{
            background:url('../svg/buyPage/buy page Mobile.svg') !important;
            background-repeat: no-repeat !important;background-size: contain !important;
            background-position:0% 100% !important;
        }
        .BuyProduct{
            display: flex;flex-direction: column !important;
            height: auto !important;
        }
        .productPic{
            width:50vw !important;
            height: 40vw !important;
            
        }  
        .productInfo{
            width: 100% !important;
            height: 40vw !important;

        }
        }

        body{
            background:url('../svg/buyPage/buy page.svg') ;
            background-repeat: no-repeat;background-size: contain;
            background-position:100% 100%;
            
        }

        
        .BuyProduct{
            display: flex;
            padding: 4vw;
            gap: 1vw;
            font-family: 'ExtraBold' !important;
            color: white;    
        }

.productPic{
    width:50%;
    height: 30vw;
    border:2px var(--main) solid;
    border-radius: 2vw;

}  
.productInfo{
    width: 50%;
    border-radius: 2vw;
    padding: 2vw;
    display: flex;flex-direction: column;
    justify-content: flex-end;
    background: #ffffff66;
    overflow-wrap: break-word;
    color: var(--main);
    backdrop-filter: blur(4px);
}
.cartBUY{
    width: 50% !important;
}
.buyPr{
    background: var(--main);
    color: white
}
.addc{
    background: none;
    color: var(--main);
    border: 3px var(--main) solid;
}
.ProductName , .ProductPrice{
    font-size: 3.5vw;
}
.ProductDesc{
    font-size: 1.1vw;
    padding: 1vw;
}
.ProductCategory{
    font-size: 1.4vw;
}
.product{
    box-shadow: 0 0 9px 2px #e7e6e6;
}
.desc{
    font-size: 1.5vw;
}

</style>

</head>
<body>


    <div id="loading-screen">
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
        <dotlottie-player src="https://lottie.host/3ba0221d-89e6-4669-a13c-225a73069cf7/ACDmsI1oFx.json" background="transparent" speed="1" style="width: 10vw; height: 10vw;" loop autoplay></dotlottie-player>
      </div>
      
      <div id="notification-container"></div>

      <nav>
        <div class="headerOfNav">
            <div class="closeButton"></div>
        </div>


        <div class="UserPfp" onclick=""></div>


        <p class="UserName">Username</p>
        <div class="pages">
            <div class="page" onclick="window.location.href = 'home.html'">
                <div class="PageIcon HomePage" ></div>
                <p>Home</p>
            </div>
            <div class="page ShopPageDiv" onclick="window.location.href = 'shop.html'">
                <div class="PageIcon ShopPage"></div>
                <p>Shop</p>
            </div>
            <div class="page">
                <div class="PageIcon CartPage"></div>
                <p>Cart</p>
            </div>
            <div class="page">
                <div class="PageIcon DayCarePage"></div>
                <p>Daycare</p>
            </div>
            <div class="page LogoutButton">
                <div class="PageIcon SettingsPage"></div>
                <p>Log out</p>
            </div>
        </div>
    </nav>


<div class="searchPage">
    <div class="closeDiv">
        <div class="closeSearchButton"></div>
    </div>
    <div class="searchInput">
        <input type="text" class="searchProductInput" name="searchProductInput" placeholder="Search for a product">
        <button type="submit" for="searchProductInput" class="searchButton"></button>
    </div>

    <section class="newProducts" style="margin-top: 5vw;">    
        <div class="products new searched"></div>
    </section>

</div>




    <header>
    <div class="headerContainer">
        <div class="MainLogo shopLogo" onclick="window.location.href = 'home.html'"></div>
            <div class="ContainerOfMenuAndSearch">
                <div class="searchIcon"></div>
                <div class="menuButton"></div>
            </div>

    </div>
    </header>

    <section class="BuyProduct">




    <?php
    
try {
    $product_id = $_GET['id'];
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_product = "SELECT * FROM products WHERE product_id = $product_id";
    $stmt_product = $connection->prepare($sql_product);
    $stmt_product->execute();
    $products = $stmt_product->fetchAll(PDO::FETCH_ASSOC);
 

    foreach($products as $product){

        $imageData = base64_encode($product['product_picture']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        echo "
        <div class='productPic' style='background:url({$imageSrc});background-size:cover'></div>
        <div class='productInfo'>
        <h1 class='ProductName'>{$product['product_name']}</h1>
        <small class='ProductCategory'>{$product['product_category']}</small>
        <div class='ProdDescDiv'><br>
        <p class='ProductDesc'><span class='desc'>Description:</span><br>{$product['product_description']}</p>
        </div>
        <h1 class='ProductPrice'>{$product['product_price']}MAD</h1>
        <div class='buyCart cartBUY'>
                        <button class='BuyNow buyPr'>Order now</button>
                        <button class='addToCart addc' >Add To Cart</button></div></div>";
    }

}catch(PDOException $e){
        echo "<script>console.log({$e->getMessage()})</script>";
    }
    ?>
    


    </section>


<main>
    <section class="newProducts">
        <h2 class="newProTitle title">Other Products</h2>
        <!--new products-->
        <div class="products new onlyNewProducts">
           
        </div>
    </section>
</main>








<form id="uploadForm" enctype="multipart/form-data" style="display: none;">
    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required>
    <input type="submit" value="Upload">
</form>

<script src="../js/shop.js"></script>



    <script>
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
      section.scrollIntoView({ behavior: 'smooth' });
    }
  }

  window.addEventListener('load', function() {
    var loadingScreen = document.getElementById('loading-screen');
    var mainContent = document.getElementById('main-content');
  

    loadingScreen.style.display = 'none';
    mainContent.style.display = 'block';
  });


  let xml = new XMLHttpRequest();
    xml.open("GET", "../php/newProducts.php", true);
    xml.setRequestHeader("Content-Type", "application/json");
    xml.send();
    xml.onload = function(){
    document.querySelector('.onlyNewProducts').innerHTML += xml.responseText;
}
  
let ntoysAccesoriesXML = new XMLHttpRequest();
    ntoysAccesoriesXML.open("GET", "../php/categoryToysAcce.php", true);
    ntoysAccesoriesXML.setRequestHeader("Content-Type", "application/json");
    ntoysAccesoriesXML.send();
    ntoysAccesoriesXML.onload = function(){
    document.querySelector('.toys-acces').innerHTML += ntoysAccesoriesXML.responseText;
}
  

let groomXML = new XMLHttpRequest();
    groomXML.open("GET", "../php/categoryGrooming.php", true);
    groomXML.setRequestHeader("Content-Type", "application/json");
    groomXML.send();
    groomXML.onload = function(){
    document.querySelector('.groomingSUp').innerHTML += groomXML.responseText;
}

let BedAndComfortXML = new XMLHttpRequest();
    BedAndComfortXML.open("GET", "../php/categoryBedComft.php", true);
    BedAndComfortXML.setRequestHeader("Content-Type", "application/json");
    BedAndComfortXML.send();
    BedAndComfortXML.onload = function(){
    document.querySelector('.bedcomfrt').innerHTML += BedAndComfortXML.responseText;
}

let FoodFeeding = new XMLHttpRequest();
    FoodFeeding.open("GET", "../php/categoryFoodFeeding.php", true);
    FoodFeeding.setRequestHeader("Content-Type", "application/json");
    FoodFeeding.send();
    FoodFeeding.onload = function(){
    document.querySelector('.FoodFeeding').innerHTML += FoodFeeding.responseText;
}



fetch('../php/checkSession.php')
    .then(response => response.json())
    .then(data => {
        if (data.loggedIn) {
            // User is logged in
            const userId = data.userId;
            const userData = data.userData;

            console.log('User ID:', userId);
            console.log('User data:', userData);
            document.querySelector('.UserName').innerHTML =  userData.first_name + ' ' + userData.last_name;

        } else {
            console.log('User is not logged in');

        }
    })
    .catch(error => {
        console.error('Error checking session:', error);
    });



document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.searchProductInput');
    const searchResultsDiv = document.querySelector('.searched');

    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.trim();

        if (searchTerm !== '') {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `../php/search.php?searchTerm=${encodeURIComponent(searchTerm)}`, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    searchResultsDiv.innerHTML = xhr.responseText;
                } else {
                    console.error('Error fetching search results:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error('Error fetching search results:', xhr.statusText);
            };
            xhr.send();
        } else {
            searchResultsDiv.innerHTML = '';
        }
    });
});



// Notification function
function showNotification(message, type) {
    const container = document.getElementById('notification-container');

    const notification = document.createElement('div');
    notification.classList.add('notification', type);
    notification.innerText = message;

    container.appendChild(notification);

    // Set the fade-out animation and removal timings
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            container.removeChild(notification);
        }, 500); // Adjust this to match the transition duration for a smooth fade-out
    }, 6000); // Notification will start to disappear after 6 seconds
}

// Attach event listener to all "Add to Cart" buttons
document.querySelectorAll('.addToCart').forEach(button => {
    button.addEventListener('click', () => {
        showNotification('The product has been added to your cart!', 'success');
        alert('cat')
    });
});




</script>
<script src="../js/checkuser.js"></script>
</body>
</html>