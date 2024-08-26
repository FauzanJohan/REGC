<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['users'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data from the session
$user = $_SESSION['users'];

// Include the database connection file
require_once 'dbconnect.php';

// Fetch additional user details from the database
$userID = $user['UserID'];
$userDetailsSql = "SELECT FirstName, LastName, Email, Phone FROM users WHERE UserID = '$userID'";
$userDetailsResult = mysqli_query($conn, $userDetailsSql);

if (mysqli_num_rows($userDetailsResult) > 0) {
    $userDetails = mysqli_fetch_assoc($userDetailsResult);

    // Update the user array with additional details
    $user['FirstName'] = $userDetails['FirstName'];
    $user['LastName'] = $userDetails['LastName'];
    $user['Email'] = $userDetails['Email'];
    $user['Phone'] = $userDetails['Phone'];
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="RealEstate Logo Icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="property_list.php">Property List</a></li>
            <li><a href="consultationresult.php">Consultation</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="userprofile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="profile-container">
    <h1>User Profile</h1>

    <div class="profile-info">
    <h2><?php echo $user['FirstName'] . ' ' . $user['LastName']; ?></h2>
    <p>Email: <?php echo $user['Email']; ?></p>
    <p>Phone: <?php echo $user['Phone']; ?></p>
</div>
</div>

<footer>
    <p>&copy; 2024 Real Estate Governance and Consultation</p>
</footer>

</body>
</html>
