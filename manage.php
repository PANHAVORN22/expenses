<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
        }
        .reserch {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .search-container input[type="search"] {
            padding: 10px;
            padding-left: 40px; /* Space for the icon */
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .search-container .fa-magnifying-glass {
            position: absolute;
            left: 10px;
            color: #888;
        }
        .add input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .add input[type="submit"]:hover {
            background-color: #45a049;
        }
        .table {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit button, .delete button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit button {
            background-color: #2196F3;
            color: white;
        }
        .edit button:hover {
            background-color: #1976D2;
        }
        .delete button {
            background-color: #f44336;
            color: white;
        }
        .delete button:hover {
            background-color: #e53935;
        }
        .logn_out{
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php
        session_start();

        // Check if user is logged in
        if (!isset($_SESSION['user'])) {
            header("Location: login.php");
            exit();
        }

        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "root";
        $db_name = "data";
        $db_port = "8889";

        $conn = new mysqli($db_server, $db_user, $db_pass, $db_name, $db_port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle the search query
        $search = isset($_POST['search']) ? $_POST['search'] : '';

        // Retrieve data from database with partial name match
        $sql = "SELECT id, name, quantity, unit_price, date, total FROM expenses WHERE name LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = '%' . $search . '%';
        $stmt->bind_param('s', $search_param);
        $stmt->execute();
        $result = $stmt->get_result();
    ?>
    <div class="container">
        <form action="expense.php" method="post">
            <div class="reserch">
                <div class="search-container">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="add">
                    <input type="submit" name="submit" value="Add">
                </div>
                <!-- Logout link -->
                <div class="logout">
                    <div class="logn_out">
                        <button>
                            <a href="logout.php">Logout</a>
                        </button>
                    </div>
                    
                </div>
            </div>  
        </form>
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['quantity']}</td>";
                                echo "<td>{$row['unit_price']}</td>";
                                echo "<td>{$row['date']}</td>";
                                echo "<td>{$row['total']}</td>";
                                echo "<td>
                                        <div class='edit'>
                                            <button>Edit</button>
                                        </div>
                                        <div class='delete'>
                                            <form action='delete.php' method='post' style='display:inline;'>
                                                <input type='hidden' name='id' value='{$row['id']}'>
                                                <button type='submit' name='delete'>Delete</button>
                                            </form>
                                        </div>
                                     </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
        $conn->close();
    ?>
</body>
</html>
