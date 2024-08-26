<?php
// Include your database connection code here
include("dbconnect.php");

// Start the session
session_start();

// Check if the user is logged in and is an admin (You need to implement user authentication)
// ...

// Initialize variables for form validation
$address = $city = $state = $zipCode = $propertyType = $bedrooms = $bathrooms = $price = '';

// Check if the form is submitted for adding a new property
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_property'])) {
    // Retrieve user inputs from the form
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $zipCode = mysqli_real_escape_string($conn, $_POST['zipCode']);
    $propertyType = mysqli_real_escape_string($conn, $_POST['propertyType']);
    $bedrooms = mysqli_real_escape_string($conn, $_POST['bedrooms']);
    $bathrooms = mysqli_real_escape_string($conn, $_POST['bathrooms']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Insert the new property into the database
    $insertQuery = "INSERT INTO properties (AdminID, Address, City, State, ZipCode, PropertyType, Bedrooms, Bathrooms, Price)
                    VALUES ('" . $_SESSION['admins']['AdminID'] . "', '$address', '$city', '$state', '$zipCode', '$propertyType', '$bedrooms', '$bathrooms', '$price')";

    $insertResult = mysqli_query($conn, $insertQuery);

    if (!$insertResult) {
        die("Insert failed: " . mysqli_error($conn));
    }

    // Redirect back to the property_admin.php page after adding a new property
    header("Location: property_admin.php");
    exit;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="home_admin.php">Home</a></li>
            <li><a href="property_admin.php">Property</a></li>
            <li><a href="consultation_admin.php">Consultation</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">

    <h2>Add Property</h2>

    <!-- Property Addition Form -->
    <form method="post" action="">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>

        <br>

        <label for="state">State:</label>
        <input type="text" id="state" name="state" required>

        <br>

        <label for="zipCode">Zip Code:</label>
        <input type="text" id="zipCode" name="zipCode" required>

        <br>

        <label for="propertyType">Property Type:</label>
        <input type="text" id="propertyType" name="propertyType" required>

        <br>

        <label for="bedrooms">Bedrooms:</label>
        <input type="number" id="bedrooms" name="bedrooms" required>

        <br>

        <label for="bathrooms">Bathrooms:</label>
        <input type="number" id="bathrooms" name="bathrooms" required>

        <br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>

        <br>

        <input type="submit" name="submit_property" value="Add Property">
    </form>

</div>

</body>
</html>
