<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['id'];
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $edit = "UPDATE users SET first_name = :firstname, last_name = :lastname, email = :email, phone = :phone WHERE id = :id";
        $stmt = $conn->prepare($edit);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
      
        echo "<script>window.location.href = 'users.php'</script>";
    } catch(PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
} else {
    $user_id = $_GET['id'];
    try {
        $conn = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="icon" href="../images/index/whiteIcon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/signup.css">
    <style>
        .signINLink{
            margin-top: 2vw;
        }
        .signUpButton{
            margin-top: 2vw;
        }
        .headd{
            padding: 0.6vw;
        }
        .headd>button{
            float: left;
            background-color: var(--main);
            color: white;
            border: none;padding: 0.5vw;border-radius: 0.1vw;
            font-family: 'ExtraBold' ;
        }

    </style>
</head>
<body>
<div class="headd">
    <button onclick="window.location.href = 'users.php'">Back</button>
</div>
<h1 class="signUpTit">Edit Users</h1>

<section class="formOfSignUp">
    <form class="signupForm" id="signupForm" action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $user_id; ?>">
        
        <label for="fname">First name</label><br>
        <small class="ferror error" id="content"></small>
        <input type="text" name="fname" id="fname" value="<?php echo $results['first_name']; ?>">

        <label for="lname">Last name</label><br>
        <small class="lerror error" id="content"></small>
        <input type="text" name="lname" id="lname" value="<?php echo $results['last_name']; ?>">

        <label for="email">Email</label><br>
        <small class="Eerror error" id="content"></small>
        <input type="email" name="email" id="email" value="<?php echo $results['email']; ?>">

        <label for="phone">Phone Number</label><br>
        <small class="pherror error" id="content"></small>
        <input type="text" name="phone" id="phone" value="<?php echo $results['phone']; ?>">

        <div class="signUpDiv">
            <button type="submit" name="editButton" class="signUpButton">Edit</button>
        </div>
    </form>
</section>

<script>
        // Function to update the content with a smooth transition
        function updateContent() {
            var contentElement = document.getElementById('content');
            contentElement.style.opacity = 0;
            setTimeout(function() {
                contentElement.style.opacity = 1;
            }, 300);
        }
        setTimeout(updateContent, 2000);

const form = document.querySelector('.signupForm');
const fnameInput = document.getElementById('fname');
const lnameInput = document.getElementById('lname');
const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');

fnameInput.addEventListener('input', validateFirstName);
lnameInput.addEventListener('input', validateLastName);
emailInput.addEventListener('input', validateEmail);
phoneInput.addEventListener('input', validatePhone);

function throwerror(inputname, errname, text) {
    inputname.style.backgroundColor = '#f253537a';
    inputname.style.color = 'red';
    document.querySelector('.' + errname).innerText = text;
}

function valide(inputname, errdisppear) {
    inputname.style.backgroundColor = '#2db72d1c';
    inputname.style.color = 'var(--main)';
    document.querySelector('.' + errdisppear).innerText = '';
}

function validateFirstName() {
    if (fnameInput.value.trim().length === 0) {
        throwerror(fnameInput, 'ferror', 'First Name cannot be empty.');
    } else if (fnameInput.value.trim().length < 3) {
        throwerror(fnameInput, 'ferror', 'First Name is too short.');
    } else if (fnameInput.value.trim().length >= 15) {
        throwerror(fnameInput, 'ferror', 'First Name is too long.');
    }
    else if (/[^a-zA-Z]/.test(fnameInput.value.trim())) {
        throwerror(fnameInput, 'ferror', 'First Name must contain letters only.');
    } else {
        valide(fnameInput, 'ferror');
    }
}

function validateLastName() {
    if (lnameInput.value.trim().length === 0) {
        throwerror(lnameInput, 'lerror', 'Last Name cannot be empty.');
    } else if (lnameInput.value.trim().length < 3) {
        throwerror(lnameInput, 'lerror', 'Last Name is too short.');
    } else if (lnameInput.value.trim().length >= 20) {
        throwerror(lnameInput, 'lerror', 'Last Name is too long.');
    } else if (/[^a-zA-Z]/.test(lnameInput.value.trim())) {
        throwerror(lnameInput, 'lerror', 'Last Name must contain letters only.');
    } else {
        valide(lnameInput, 'lerror');
    }
}

function validateEmail() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const emailValue = emailInput.value.trim();

    if (emailInput.value.trim().length === 0) {
        throwerror(emailInput, 'Eerror', 'Email cannot be empty.');
    } else if (emailInput.value.trim().length < 5) {
        throwerror(emailInput, 'Eerror', 'Email is too short.');
    } else if (!emailRegex.test(emailValue.toLowerCase())) {
        throwerror(emailInput, 'Eerror', 'Invalid email address.');
    } else {
        valide(emailInput, 'Eerror');
    }
}

function validatePhone() {
    const phoneRegex = /^\+?[\d]{10,}$/;
    if (phoneInput.value.trim().length === 0) {
        throwerror(phoneInput, 'pherror', 'Phone number cannot be empty.');
    } else if (phoneInput.value.trim().length < 10) {
        throwerror(phoneInput, 'pherror', 'Phone number is too short.');
    } else if (!phoneRegex.test(phoneInput.value.trim())) {
        throwerror(phoneInput, 'pherror', 'Invalid phone number. Must contain only digits.');
    } else if (phoneInput.value.trim().length > 15) {
        throwerror(phoneInput, 'pherror', 'Phone number is too long.');
    } else {
        valide(phoneInput, 'pherror');
    }
}

function validateForm() {
    validateFirstName();
    validateLastName();
    validateEmail();
    validatePhone();

    const errorMessages = form.querySelectorAll('.error');
    let isValid = true;
    errorMessages.forEach(message => {
        if (message.textContent !== '') {
            isValid = false;
        }
    });

    return isValid;
}

form.addEventListener('submit', function (event) {
    if (!validateForm()) {
        event.preventDefault();
    }
});
</script>

</body>
</html>
