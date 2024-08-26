<?php
// Include the database connection file
include("dbconnect.php");

// Check if the user is logged in and get the UserID from the session
session_start();
if (!isset($_SESSION['users'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Get UserID from the session
$userID = $_SESSION['users']['UserID'];

if (isset($_POST['submit'])) {
    // Capture input data from the form
    $consultationDate = $_POST['ConsultationDate'];
    $notes = $_POST['Notes'];
    $propertyID = $_POST['PropertyID']; // Assuming you have this input in your form
    $adminID = 2; // Default AdminID
    // UserID retrieved from the session

    // Create and execute SQL query to insert into consultations table
    $insertQuery = "INSERT INTO consultations (UserID, AdminID, PropertyID, ConsultationDate, Notes)
                    VALUES ($userID, $adminID, $propertyID, '$consultationDate', '$notes')";

    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        // Insert successful
        echo "Consultation added successfully.";

        // Redirect to consultationresult.php
        header("Location: http://localhost/ict651/ICT651Project/consultationresult.php");
        exit();
    } else {
        // Insert failed
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch property data to display in the form
$propertyQuery = "SELECT PropertyID, PropertyType, Address FROM properties";
$propertyResult = mysqli_query($conn, $propertyQuery);

if (!$propertyResult) {
    die("Query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="RealEstate Logo Icon.png">
    <title>Consultation Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styleconsultation.css">
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

    <div class="container">
        <h2>Consultation Form</h2>

        <form method="POST">
            <label for="PropertyID">Type of Property:</label>
            <select id="PropertyID" name="PropertyID" required>
                <?php
                while ($row = mysqli_fetch_assoc($propertyResult)) {
                    echo "<option value='{$row['PropertyID']}'>{$row['PropertyType']} - {$row['Address']}</option>";
                }
                ?>
            </select>

            <label for="ConsultationDate">Consultation Date:</label>
            <input type="date" id="ConsultationDate" name="ConsultationDate" required>

            <label for="Notes">Notes:</label>
            <textarea id="Notes" name="Notes" rows="4" required></textarea>

            <button type="submit" name="submit">Submit</button>
            <a class="back-link" href="http://localhost/ict651/ICT651Project/home.php">Back</a>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Real Estate Governance and Consultation</p>
    </footer>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
