<?php
session_start();

// Include your database connection code here
include("dbconnect.php");

// Check if the form is submitted for updating property
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_update'])) {
    $propertyID = mysqli_real_escape_string($conn, $_POST['propertyID']);

    // Retrieve updated information from the form
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $zipCode = mysqli_real_escape_string($conn, $_POST['zipCode']);
    $propertyType = mysqli_real_escape_string($conn, $_POST['propertyType']);
    $bedrooms = mysqli_real_escape_string($conn, $_POST['bedrooms']);
    $bathrooms = mysqli_real_escape_string($conn, $_POST['bathrooms']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Update property information in the database
    $updateQuery = "UPDATE properties
                    SET Address = ?, City = ?, State = ?, ZipCode = ?, 
                        PropertyType = ?, Bedrooms = ?, Bathrooms = ?, Price = ?
                    WHERE PropertyID = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "sssssiidi", $address, $city, $state, $zipCode, $propertyType, $bedrooms, $bathrooms, $price, $propertyID);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['update_message'] = "Property updated successfully.";
    } else {
        $_SESSION['update_error'] = "Error updating property: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    header("Location: property_admin.php");
    exit();
}

// Fetch property information based on PropertyID
if (isset($_GET['propertyID'])) {
    $propertyID = mysqli_real_escape_string($conn, $_GET['propertyID']);

    $selectQuery = "SELECT * FROM properties WHERE PropertyID = ?";
    $stmt = mysqli_prepare($conn, $selectQuery);
    mysqli_stmt_bind_param($stmt, "i", $propertyID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $property = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Check if property exists
    if (!$property) {
        $_SESSION['update_error'] = "Property not found.";
        header("Location: property_admin.php");
        exit();
    }
} else {
    $_SESSION['update_error'] = "Invalid property ID.";
    header("Location: property_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Property</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Update Property</h2>

    <!-- Display Property Information for Update -->
    <form method="post" action="">
        <input type="hidden" name="propertyID" value="<?php echo $property['PropertyID']; ?>">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo $property['Address']; ?>" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo $property['City']; ?>" required>

        <label for="state">State:</label>
        <input type="text" id="state" name="state" value="<?php echo $property['State']; ?>" required>

        <label for="zipCode">Zip Code:</label>
        <input type="text" id="zipCode" name="zipCode" value="<?php echo $property['ZipCode']; ?>" required>

        <label for="propertyType">Property Type:</label>
        <input type="text" id="propertyType" name="propertyType" value="<?php echo $property['PropertyType']; ?>" required>

        <label for="bedrooms">Bedrooms:</label>
        <input type="number" id="bedrooms" name="bedrooms" value="<?php echo $property['Bedrooms']; ?>" required>

        <label for="bathrooms">Bathrooms:</label>
        <input type="number" id="bathrooms" name="bathrooms" value="<?php echo $property['Bathrooms']; ?>" required>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo $property['Price']; ?>" required>

        <button type="submit" name="submit_update">Update Property</button>
    </form>
</div>

</body>
</html>
