<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        try {
            $connection = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $product_name = $_POST['productName'];
            $product_price = $_POST['productPrice'];
            $product_description = $_POST['productDescription'];
            $product_category = $_POST['productCategory'];
            $edited_id = $_GET['id'];

            // Access uploaded file via $_FILES
            $fileTmpPath = $_FILES['product_Image']['tmp_name'];
            $fileSize = $_FILES['product_Image']['size'];
            $fileType = $_FILES['product_Image']['type'];

            $editProduct = "UPDATE products SET product_name = :product_name, product_price = :product_price, product_description = :product_description,
                product_category = :product_category";

            if ($fileSize > 0) {
                $fileContent = file_get_contents($fileTmpPath);
                $editProduct .= ", product_picture = :product_picture";
            }

            $editProduct .= " WHERE product_id = :product_id";
            $stmt = $connection->prepare($editProduct);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':product_price', $product_price);
            $stmt->bindParam(':product_description', $product_description);
            $stmt->bindParam(':product_category', $product_category);

            if ($fileSize > 0) {
                $stmt->bindParam(':product_picture', $fileContent, PDO::PARAM_LOB);
            }

            $stmt->bindParam(':product_id', $edited_id, PDO::PARAM_INT);
            $stmt->execute();

            echo "<script>alert('Product updated successfully');window.location.href = 'products.php'</script>";

        } catch (PDOException $e) {
            echo "<script>alert('Error: {$e->getMessage()}');</script>";
        }
    }
}

$product_id = $_GET['id'];
try {
    $connection = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $connection->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $imageData = base64_encode($result['product_picture']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        <h2>Edit Product</h2>
        <form id="productForm" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" id="productName" name="productName" value="<?php echo $result['product_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="productPrice" value="<?php echo $result['product_price']; ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="productDescription" rows="4" required><?php echo $result['product_description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="productCategory" required>
                    <option value="" disabled>Select a category</option>
                    <option value="Toys and Accessories" <?php if ($result['product_category'] == 'Toys and Accessories') echo 'selected'; ?>>Toys and Accessories</option>
                    <option value="Grooming Supplies" <?php if ($result['product_category'] == 'Grooming Supplies') echo 'selected'; ?>>Grooming Supplies</option>
                    <option value="Bedding and Comfort" <?php if ($result['product_category'] == 'Bedding and Comfort') echo 'selected'; ?>>Bedding and Comfort</option>
                    <option value="Food and Feeding" <?php if ($result['product_category'] == 'Food and Feeding') echo 'selected'; ?>>Food and Feeding</option>
                </select>
            </div>
            <div class="form-group">
                <label for="productImage">Product Image</label>
                <input type="file" id="productImage" name="product_Image" accept="image/*">
                <img id="imagePreview" src="<?php echo $imageSrc; ?>" alt="Image Preview" style="display: block;">
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
                    event.target.value = ''; // Clear the file input
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
</body>
</html>
