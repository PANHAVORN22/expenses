<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        .container input[type="email"],
        .container input[type="password"],
        .container input[type="file"] {
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
<?php

if(isset($_POST["sign_up"])){
$email = $_POST["email"];
$password = $_POST["password"];
$name = $_POST["name"];
$errors =[];

if(empty($email)){
        $errors[] = "That email wasn't valid<br>";
    }
    if(empty($password)){
        $errors[] =  "password is required.<br>";
    }
    if(empty($name)){
        $errors[] =  "Username is required.<br>";
    }
    


}
?>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" >

            <label for="password">Password</label>
            <input type="password" id="password" name="password" >

            <label for="name">Name</label>
            <input type="text" id="name" name="name" >

            <label for="file">Upload a File</label>
            <input type="file" id="file" name="file">

            <input type="submit" name="sign_up" value="Sign Up">
            <?php
                    if(isset($errors)){
                        foreach($errors as $error){
                            echo "$error";
                        }

                        
                    }
                    
                ?>
        </form>

    </div>
    <?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "root";
    $db_name = "data";
    $db_conn = ""; 
    $db_port = "8889";
    try{
        $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name,$db_port);
    }
    catch(mysqli_sql_exception){
        echo"Could not connect!<br>";
    }
    if($_POST){
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $name = filter_input(INPUT_POST,"name", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        if(empty($name)){
            echo"Please enter your Name";
        }
        elseif(empty($password)){
            echo"Please enter your Password";
        }
        elseif(empty($email)){
            echo "Please enter your Email";
        }
        else{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (email, user_name, password)
                    VALUES('$email','$name', '$hash')";  
            mysqli_query($conn, $sql);
            echo"You are now registered!";
        }
        mysqli_close($conn);
    }

?>
</body>
    
</html>
