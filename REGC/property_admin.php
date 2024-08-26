<?php
session_start();

// Include your database connection code here
include("dbconnect.php");

// Check if there's an update message
if (isset($_SESSION['update_message'])) {
    echo $_SESSION['update_message'];
    unset($_SESSION['update_message']); // Clear the message to avoid displaying it again
}

// Check if there's an update error
if (isset($_SESSION['update_error'])) {
    echo $_SESSION['update_error'];
    unset($_SESSION['update_error']); // Clear the error to avoid displaying it again
}

// Handle property addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_property'])) {
    header("Location: propertyadd_admin.php");
    exit();
}

// Check if the form is submitted for updating property
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_property'])) {
    $propertyID = $_POST['update_property'];

    // Redirect to propertyupdate_admin.php with the PropertyID
    header("Location: propertyupdate_admin.php?propertyID=" . $propertyID);
    exit();
}

// Handle property deletion
if (isset($_POST['delete_property'])) {
    $propertyID = mysqli_real_escape_string($conn, $_POST['delete_property']);

    $deleteQuery = "DELETE FROM properties WHERE PropertyID = ?";

    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $propertyID);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['delete_message'] = "Property deleted successfully.";
    } else {
        $_SESSION['delete_error'] = "Error deleting property: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
$propertyID = isset($_GET['property']) ? mysqli_real_escape_string($conn, $_GET['property']) : '';

// Fetch properties with associated user information for display
$sql = "SELECT p.*, u.UserID
        FROM properties p
        LEFT JOIN users u ON p.UserID = u.UserID
        WHERE p.AdminID = '" . $_SESSION['admins']['AdminID'] . "'";
$result = mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Property Management</title>
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

<h2>Admin Property Management</h2>

<!-- Property Addition Button -->
<form method="post" action="">
    <button type="submit" name="add_property">Add Property</button>
</form>

<!-- Display Properties -->
<h3>Properties:</h3>

<?php
// Display delete message if available
if (isset($_SESSION['delete_message'])) {
    echo "<p>{$_SESSION['delete_message']}</p>";
    unset($_SESSION['delete_message']);
}
?>

<table border="1">
    <tr>
        <th>Property ID</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Zip Code</th>
        <th>Property Type</th>
        <th>Bedrooms</th>
        <th>Bathrooms</th>
        <th>Price</th>
        <th>User ID</th>
        <th>Actions</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['PropertyID'] . "</td>";
        echo "<td>" . $row['Address'] . "</td>";
        echo "<td>" . $row['City'] . "</td>";
        echo "<td>" . $row['State'] . "</td>";
        echo "<td>" . $row['ZipCode'] . "</td>";
        echo "<td>" . $row['PropertyType'] . "</td>";
        echo "<td>" . $row['Bedrooms'] . "</td>";
        echo "<td>" . $row['Bathrooms'] . "</td>";
        echo "<td>" . $row['Price'] . "</td>";
        echo "<td>" . ($row['UserID'] ?? 'NULL') . "</td>"; // Display 'NULL' if UserID is null
        echo "<td>";
        echo "<form method='post' action='property_admin.php'>";
        echo "<input type='hidden' name='update_property' value='" . $row['PropertyID'] . "'>";
        echo "<button type='submit'>Update</button>";
        echo "</form>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='delete_property' value='" . $row['PropertyID'] . "'>";
        echo "<button type='submit' onclick='return confirmDelete()'>Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

<!-- JavaScript for delete confirmation -->
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this property?");
    }
</script>

</body>
</div>
</html>

