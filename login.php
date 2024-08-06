<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333333;
        }
        .container label {
            display: block;
            margin-bottom: 5px;
            color: #333333;
        }
        .container input[type="text"],
        .container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }
        .container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .container .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" >

            <input type="submit" name="login" value="Login">
        </form>
    </div>
    <?php
    session_start();

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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $name = mysqli_real_escape_string($con, $_POST["name"]);
        $password = mysqli_real_escape_string($con, $_POST["password"]);
        
        
        $sql = "SELECT * FROM users WHERE user_name = '$name' AND password = '$password'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            
            $_SESSION['user'] = $name;
            header("Location: manage.php");  
            exit();
        } else {
            echo "<p class='error'>Invalid username or password</p>";
        }

        $result->free();
    }

    $con->close();
    ?>

</body>
</html>
