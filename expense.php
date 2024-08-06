<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }
        .form .form-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .form .form-group .field {
            width: 48%;
            margin-bottom: 10px;
        }
        .form input[type="text"], .form input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form .total input {
            background-color: #f4f4f4;
            width: 60%;
        }
        .form .button-container {
            display: flex;
            justify-content: flex-end;
        }
        .form .save {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none; 
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form .save:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    // Check if user is logged in (if necessary)
    /*if (!isset($_POST['submit'])) {
        header("Location: manage.php");
        exit();
    }
    */
    ?>
    <div class="container">
        <h2>Expenses</h2>
        <div class="form">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <div class="form-group">
                    <div class="field">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div class="field">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date">
                    </div>
                </div>
                <div class="form-group">
                    <div class="field">
                        <label for="quantity">Quantity:</label>
                        <input type="text" id="quantity" name="quantity">
                    </div>
                    <div class="field">
                        <label for="price">Unit Price:</label>
                        <input type="text" id="price" name="price">
                    </div>
                </div>
                <div class="total">
                    <label for="total">Total:</label>
                    <input type="text" id="total" name="total" readonly>
                </div>
                <div class="button-container">
                    <button type="submit" class="save">Save</button>
                </div>
            </form>
        </div>
    </div>
    <?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "root";
    $db_name = "data";
    $db_port = "8889";


    $con = new mysqli($db_server, $db_user, $db_pass, $db_name, $db_port);

    try{
        $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name,$db_port);
    }
    catch(mysqli_sql_exception){
        echo"Could not connect!<br>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
        if ($quantity && $price) {
            $total = $quantity * $price;
        } else {
            $total = 0;
        }
        
        if(empty($name)){
            echo"Please enter your Item Name!";
        }
        elseif(empty($quantity)){
            echo"Please enter your Quantity";
        }
        elseif(empty($price)){
            echo "Please enter your Price";
        }
        elseif(empty($date)){
            echo "Please enter your Date ";
        }
        
        else{
            $sql = "INSERT INTO expenses(name, quantity, date, unit_price)
                    VALUES('$name', '$quantity','$date','$price')";  
            mysqli_query($conn, $sql);
            echo"You are now Successful!";
        }
        mysqli_close($conn);
        
    }
    if (!isset($_POST['submit'])) {
        header("Location: manage.php");
        exit();
    }


    

    ?>
</body>
</html>
