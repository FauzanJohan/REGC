<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Schedule</title>
    <link rel="shortcut icon" type="image/x-icon" href="RealEstate Logo Icon.png">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styleproperty.css">
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

    <div class="table-container">
        <h1>Consultation Schedule</h1>

        <?php
        // Include the database connection file
        include("dbconnect.php");

        // Assuming you have the UserID stored in a session variable
        session_start();
        $userID = $_SESSION['users']['UserID'];

        $query = "SELECT consultations.ConsultationID, consultations.ConsultationDate, consultations.Notes,
                         properties.PropertyType, properties.Address,
                         admins.FirstName AS AdminFirstName, admins.LastName AS AdminLastName, admins.Phone AS AdminPhone
                  FROM consultations
                  LEFT JOIN properties ON consultations.PropertyID = properties.PropertyID
                  LEFT JOIN admins ON consultations.AdminID = admins.AdminID
                  WHERE consultations.UserID = $userID";

        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        echo '<table>';
        echo "<tr><th>Consultation ID</th><th>Consultation Date</th><th>Property Type</th><th>Address</th><th>Admin Name</th><th>Admin Phone</th><th>Notes</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ConsultationID'] . "</td>";
            echo "<td>" . $row['ConsultationDate'] . "</td>";
            echo "<td>" . $row['PropertyType'] . "</td>";
            echo "<td>" . $row['Address'] . "</td>";
            echo "<td>" . $row['AdminFirstName'] . " " . $row['AdminLastName'] . "</td>";
            echo "<td>" . $row['AdminPhone'] . "</td>";
            echo "<td>" . $row['Notes'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        // Close the database connection
        mysqli_close($conn);
        ?>

        <a class="consult-form" href="consultation.php">Add Appointment</a>
    </div>

    <footer>
        <p>&copy; 2024 Real Estate Governance and Consultation</p>
    </footer>
</body>

</html>
