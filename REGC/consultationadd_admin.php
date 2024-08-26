<?php
// Include your database connection code here
include("dbconnect.php");

// Start the session
session_start();

// Check if the user is logged in and is an admin (You need to implement user authentication)
// ...

// Initialize variables for form validation
$consultationDate = $notes = '';

// Check if the form is submitted for adding a new consultation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_consultation'])) {
    // Retrieve user inputs from the form
    $consultationDate = mysqli_real_escape_string($conn, $_POST['consultation_date']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    // Retrieve admin ID from the session
    $adminID = $_SESSION['admins']['AdminID'];

    // Insert the new consultation into the database
    $insertQuery = "INSERT INTO consultations (AdminID, ConsultationDate, Notes)
                    VALUES ('$adminID', '$consultationDate', '$notes')";

    $insertResult = mysqli_query($conn, $insertQuery);

    if (!$insertResult) {
        die("Insert failed: " . mysqli_error($conn));
    }

    // Redirect back to the consultation_admin.php page after adding a new consultation
    header("Location: consultation_admin.php");
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
    <title>Add Consultation</title>
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

    <h2>Add Consultation</h2>

    <!-- Consultation Addition Form -->
    <form method="post" action="">
        <label for="consultation_date">Consultation Date:</label>
        <input type="date" id="consultation_date" name="consultation_date" required>

        <br>

        <label for="notes">Notes:</label>
        <textarea id="notes" name="notes" rows="4" required></textarea>

        <br>

        <input type="submit" name="submit_consultation" value="Add Consultation">
    </form>

</div>

</body>
</html>
