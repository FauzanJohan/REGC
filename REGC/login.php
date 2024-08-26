<?php
session_start();
require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // You should perform proper validation and sanitization of user input
    // before using it in a SQL query to prevent SQL injection attacks.

    // Query for users
    $userSql = "SELECT UserID, email, firstName, lastName FROM users WHERE email = '$email' AND password = '$password'";
    $userResult = mysqli_query($conn, $userSql);

    // Query for admins
    $adminSql = "SELECT AdminID, email, firstName, lastName FROM admins WHERE email = '$email' AND password = '$password'";
    $adminResult = mysqli_query($conn, $adminSql);

if (mysqli_num_rows($userResult) > 0) {
    $user = mysqli_fetch_assoc($userResult);
    $_SESSION['users'] = $user;
    header("Location: home.php");
    exit();

} elseif (mysqli_num_rows($adminResult) > 0) {
    $admin = mysqli_fetch_assoc($adminResult);
    $_SESSION['admins'] = $admin;
    header("Location: home_admin.php");
    exit();
} else {
    // Login failed
    $error_message = "Incorrect email or password. Please try again.";
}

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            width: 300px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p.error-message {
            color: red;
        }

        .logo {
            max-width: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="RealEstate Logo.png" alt="RealEstate Logo" class="logo">
        <h2>Login</h2>

        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>

    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
        <a href="register.php">Register</a> 
</form>
    </div>
</body>
</html>
