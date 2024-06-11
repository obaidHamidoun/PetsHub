<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['submit'])) {
        try {
            $connection = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $product_name = $_POST['productName'];
            $product_price = $_POST['productPrice'];
            $product_description = $_POST['productDescription'];
            $product_category = $_POST['productCategory'];

            // Access uploaded file via $_FILES
            $fileTmpPath = $_FILES['product_Image']['tmp_name'];
            $fileSize = $_FILES['product_Image']['size'];
            $fileType = $_FILES['product_Image']['type'];

            if ($fileSize > 0) {
                $fileContent = file_get_contents($fileTmpPath);

                $addProductQuery = "INSERT INTO products (product_name, product_price, product_description, product_category, product_picture)
                VALUES (:product_name, :product_price, :product_description, :product_category, :product_picture)";
                $stmt = $connection->prepare($addProductQuery);

                $stmt->bindParam(':product_name', $product_name);
                $stmt->bindParam(':product_price', $product_price);
                $stmt->bindParam(':product_description', $product_description);
                $stmt->bindParam(':product_category', $product_category);
                $stmt->bindParam(':product_picture', $fileContent, PDO::PARAM_LOB);

                $stmt->execute();

                echo "<script>alert('Product inserted successfully');window.location.href = 'products.php')</script>";
            } else {
                echo "<script>alert('Error: File is empty or too large');</script>";
            }
        } catch (PDOException $err) {
            echo "<script>alert('Error: " . $err->getMessage() . "');</script>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
            display: flex;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            font-family: 'EXtraBold';
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="file"] {
            padding: 3px;
        }
        .form-group img {
            margin-top: 10px;
            max-width: 100%;
            height: auto;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #3D67FF;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #3958c8;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Insert Product</h2>
        <form id="productForm" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" id="productName" name="productName" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="productPrice" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="productDescription" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="productCategory" required>
                    <option value="">Select a category</option>
                    <option value="Toys and Accessories">Toys and Accessories</option>
                    <option value="Grooming Supplies">Grooming Supplies</option>
                    <option value="Bedding and Comfort">Bedding and Comfort</option>
                    <option value="Food and Feeding">Food and Feeding</option>
                </select>
            </div>
            <div class="form-group">
                <label for="productImage">Product Image</label>
                <input type="file" id="productImage" name="product_Image" accept="image/*" required>
                <img id="imagePreview" src="" alt="Image Preview" style="display: none;">
            </div>
            <button type="submit" class="submit-btn" name="submit">Submit</button>
        </form>
    </div>
    <script>
        document.getElementById('productImage').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    alert('Please upload a valid image file.');
                    event.target.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.getElementById('imagePreview');
                    imgElement.src = e.target.result;
                    imgElement.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });


    </script>
<script src="../js/checkuser.js"></script>


</body>
</html>
