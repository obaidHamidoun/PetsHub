<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        try {
            $connection = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $order_id = $_GET['id'];
            $order_status = $_POST['orderStatus'];

            $editOrder = "UPDATE orders SET order_status = :order_status WHERE order_id = :order_id";
            $stmt = $connection->prepare($editOrder);
            $stmt->bindParam(':order_status', $order_status);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();

            echo "<script>alert('Order status updated successfully');window.location.href = 'orders.php'</script>";

        } catch (PDOException $e) {
            echo "<script>alert('Error: {$e->getMessage()}');</script>";
        }
    }
}

$order_id = $_GET['id'];
try {
    $connection = new PDO("mysql:host=localhost;dbname=petshub", 'root', '');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $connection->prepare("SELECT * FROM orders WHERE order_id = :order_id");
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
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
        <h2>Edit Order</h2>
        <form id="orderForm" method="POST">
            <div class="form-group">
                <label for="orderStatus">Order Status</label>
                <select id="orderStatus" name="orderStatus">
                    <option value="Canceled" <?php if ($result['order_status'] == 'Canceled') echo 'selected'; ?>>Canceled</option>
                    <option value="Delivered" <?php if ($result['order_status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                    <option value="Missed" <?php if ($result['order_status'] == 'Missed') echo 'selected'; ?>>Missed</option>
                    <option value="Pending" <?php if ($result['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                </select>
            </div>
            <button type="submit" class="submit-btn" name="submit">Submit</button>
        </form>
    </div>

    <script>
        // JavaScript code
    </script>
</body>
</html>
