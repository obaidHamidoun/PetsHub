<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>confirmation</title>
    <title>PetsHub</title>
    <link rel="icon" href="../images/index/whiteIcon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/signUp.css">
    <script>

</script>

    <style>
        body{
            padding: 6vw;
        }
        :root{
        --main : #FFA63D
        }
        .confirmOrderButton{
         background-color:var(--main);
         color:white;padding: 2vw;
         border:none;border-radius: 10vw;
        }
        small{
            font-family: 'ExtraBold';
        }
        select{
            width: 100%;
    border: var(--main) 1px solid;
    padding: 0.5vw;
    border-radius: 7px;
    transition: all 0.4s;
    margin-bottom: 0.5vw;
    color: var(--main);
    animation: inputmar 0.5s ease forwards;
    cursor: pointer;
        }
    </style>


</head>
<body>


<div id="notification-container"></div>

<h1 class="signUpTit">order confirmation</h1><br>
<section class="orderConfirmationForm">
    <form class="confirmationForm" id="confirmationForm" method="post">

        <label for="city">City :</label><br>
        <select type="text" name="city" id="city">
        <option value="">Select a city</option>
    <option value="Agadir">Agadir</option>
    <option value="Al Hoceima">Al Hoceima</option>
    <option value="Asilah">Asilah</option>
    <option value="Azemmour">Azemmour</option>
    <option value="Azrou">Azrou</option>
    <option value="Beni Mellal">Beni Mellal</option>
    <option value="Berkane">Berkane</option>
    <option value="Boujdour">Boujdour</option>
    <option value="Casablanca">Casablanca</option>
    <option value="Chefchaouen">Chefchaouen</option>
    <option value="Dakhla">Dakhla</option>
    <option value="El Jadida">El Jadida</option>
    <option value="Erfoud">Erfoud</option>
    <option value="Essaouira">Essaouira</option>
    <option value="Fes">Fes</option>
    <option value="Ifrane">Ifrane</option>
    <option value="Kenitra">Kenitra</option>
    <option value="Khemisset">Khemisset</option>
    <option value="Khouribga">Khouribga</option>
    <option value="Ksar El Kebir">Ksar El Kebir</option>
    <option value="Laayoune">Laayoune</option>
    <option value="Larache">Larache</option>
    <option value="Marrakech">Marrakech</option>
    <option value="Meknes">Meknes</option>
    <option value="Mohammedia">Mohammedia</option>
    <option value="Nador">Nador</option>
    <option value="Ouarzazate">Ouarzazate</option>
    <option value="Oujda">Oujda</option>
    <option value="Rabat">Rabat</option>
    <option value="Safi">Safi</option>
    <option value="Salé">Salé</option>
    <option value="Tangier">Tangier</option>
    <option value="Taroudant">Taroudant</option>
    <option value="Taza">Taza</option>
    <option value="Tetouan">Tetouan</option>
    <option value="Tiznit">Tiznit</option>
    <option value="Zagora">Zagora</option>
        </select><br>
    
        <label for="street">Street :</label><br>
        <input type="text" name="street" id="street" required>
    
        <label for="postalCode">Postal Code :</label><br>
        <input type="number" name="postalCode" id="postalCode" required>
    
        <label for="houseNumber">House info :</label><br>
        <input type="text" name="houseNumber" id="houseNumber" required>
    
        <div class="confirmOrderDiv">
            <button type="submit" name="confirmOrderButton" class="confirmOrderButton">Confirm Order</button><br>
        </div>
        
    </form>

    <small>Note: only Payment on delivery available at this moment</small><br>
    <small>You will recieve an email with more info and update about the delivery</small>
    <small>Delivery period can be up to 7 days</small>
</section>



<?php

$user_id = $_GET['user_id'];
$product_id = $_GET['product_id'];

if(isset($_POST['confirmOrderButton'])){

$city = $_POST['city'];
$street = $_POST['street'];
$postalCode = $_POST['postalCode'];
$houseNumber = $_POST['houseNumber'];


$date = date('Y-m-d');
$time = date('H:i:s');

$user_location = "City: $city, Street: $street, Postal Code: $postalCode, House Number: $houseNumber";

$servername = "localhost"; 
$username = 'root';
$password = '';
$dbname = "petshub";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, order_date, order_status, user_location) VALUES (:user_id, :product_id, :order_date, :order_status, :user_location)");

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':order_date', $date);
    $stmt->bindValue(':order_status', 'Pending');
    $stmt->bindParam(':user_location', $user_location);

    $stmt->execute();

    echo "<script>alert('your order has been recieved', 'success')</script>";
    echo "<script>window.location.href='home.html'</script>";
} catch(PDOException $e) {
    echo "<script>console.log(Error: {$e->getMessage()})</script>";
}
}

?>





<script>
    function validateForm() {
        var city = document.getElementById("city").value;
        var street = document.getElementById("street").value;
        var postalCode = document.getElementById("postalCode").value;
        var houseNumber = document.getElementById("houseNumber").value;


        var specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;


        if (city === "" || street === "" || postalCode === "" || houseNumber === "") {
            alert("All fields are required");
            return false; 
        }

        if (specialChars.test(city) || specialChars.test(street) || specialChars.test(postalCode) || specialChars.test(houseNumber)) {
            alert("Special characters are not allowed");
            return false;
        }

        return true; 
    }


</script>
    
</body>
</html>