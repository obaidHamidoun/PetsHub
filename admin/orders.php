<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Table</title>
    <link rel="icon" href="images/adminIcon.png">
    <style>
           @font-face {
    font-family:'Black';
    src: url('../fonts/MPLUSRounded1c-Black.ttf');
}

@font-face {
    font-family:'Medium';
    src: url('../fonts/MPLUSRounded1c-Medium.ttf');
}

@font-face {
    font-family:'ExtraBold';
    src: url('../fonts/MPLUSRounded1c-ExtraBold.ttf');
}
body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: white;
            font-family: 'ExtraBold';
        }
        .table-container {
            max-width: 100%;
            overflow-x: auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            table-layout: auto;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #3D67FF;
        }
        th {
            background-color: #3D67FF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table-container img {
            max-width: 50px;
            height: auto;
        }
        .action-btn {
            background-color: #4A90E2;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .action-btn:hover {
            background-color: #357ABD;
        }
        button{
            cursor:pointer;            font-family: 'ExtraBold';
        }
        .edit{
            background-color: rgb(115, 232, 166);
            border-color: green ;
        }
        .remove{
            background-color: rgb(225, 116, 116);
            border-color: #800000 ;
        }
        a{
            text-decoration: none;color: black;
        }
        .headd{
            padding: 0.6vw;
        }
        .headd>button{
            background-color: #3D67FF;
            color: white;
            border: none;padding: 0.5vw;border-radius: 0.1vw;
            font-family: 'ExtraBold' ;
        }
        .searchForm {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .searchForm input[type="text"] {
            padding: 5px;
            font-size: 16px;
        }
        .searchForm input[type="submit"] {
            padding: 5px 10px;
            background-color: #3D67FF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'ExtraBold';
        }
        .searchForm input[type="submit"]:hover {
            background-color: #357ABD;
        }
        #searchResults {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="headd">
    <button onclick="window.location.href = 'index.php'">Back</button>
</div>

<form name="searchForm" class="searchForm">
    <input type="text" name="searchOrder" id="searchOrder" placeholder="Search by user or status">
</form>

<div class="table-container">
    <table class="OrdersTable">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>User ID</th>
                <th>Product ID</th>
                <th>User Location</th>
                <th>Edit</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $servername = 'localhost';
            $username = 'root';
            $pass = "";

            try {
                $connection = new PDO("mysql:host=$servername;dbname=petshub", $username, $pass);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT * FROM orders";
                $stmt = $connection->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($results as $result){
                    echo "<tr>
                        <td>{$result['order_id']}</td>
                        <td>{$result['order_date']}</td>
                        <td>{$result['order_status']}</td>
                        <td>{$result['user_id']}</td>
                        <td>{$result['product_id']}</td>
                        <td>{$result['user_location']}</td>
                        <td><button class='edit'><a href='editOrder.php?id={$result['order_id']}' >Edit</a></button></td>
                        <td><button class='remove'><a href='removeOrder.php?id={$result['order_id']}'>Remove</a></button></td>
                    </tr>";
                }

            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // jQuery functions for any additional functionality
});
</script>

<script>
document.getElementById('searchOrder').addEventListener('input', function() {
    const query = this.value.trim().toLowerCase();
    const rows = document.querySelectorAll('.OrdersTable tbody tr');
    
    rows.forEach(row => {
        const userId = row.cells[3].textContent.trim().toLowerCase();
        const status = row.cells[2].textContent.trim().toLowerCase();
        if (userId.includes(query) || status.includes(query)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<script src="../js/checkuser.js"></script>
    
</body>
</html>