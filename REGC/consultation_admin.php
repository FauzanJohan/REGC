<?php
// Include the database connection file
include("dbconnect.php");

// Check if the user is logged in and is an admin (You need to implement user authentication)
// ...

// Check if the form is submitted for consultation deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $consultationID = $_POST['id'];

    // Delete the consultation from the database
    $deleteQuery = "DELETE FROM consultations WHERE ConsultationID = $consultationID";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if (!$deleteResult) {
        die("Delete failed: " . mysqli_error($conn));
    }

    // Redirect back to the consultation_admin.php page after deletion
    header("Location: consultation_admin.php");
    exit;
}

// Fetch all consultations from the database with related information
$query = "SELECT consultations.*, 
                 properties.PropertyType, properties.Address, properties.City, properties.State, properties.ZipCode, 
                 users.FirstName AS UserFirstName, users.LastName AS UserLastName, 
                 admins.FirstName AS AdminFirstName, admins.LastName AS AdminLastName
          FROM consultations
          LEFT JOIN properties ON consultations.PropertyID = properties.PropertyID
          LEFT JOIN users ON consultations.UserID = users.UserID
          LEFT JOIN admins ON consultations.AdminID = admins.AdminID";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Admin</title>
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

<h1>Consultation Admin</h1>

<!-- Consultation Addition Button -->
<form method="post" action="consultationadd_admin.php">
    <button type="submit" name="add_property">Add Property</button>
</form>

<table border="1">
    <tr>
        <th>User Name</th>
        <th>Consultation Date</th>
        <th>Notes</th>
        <th>Action</th>
    </tr>

    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['UserFirstName']} {$row['UserLastName']}</td>";
        echo "<td>{$row['ConsultationDate']}</td>";
        echo "<td>{$row['Notes']}</td>";
        echo "<td>
                <a href='consultationupdate_admin.php?id={$row['ConsultationID']}'>Update</a> | 
                <form method='post' action='consultation_admin.php' onsubmit='return confirmDelete()'>
                    <input type='hidden' name='action' value='delete'>
                    <input type='hidden' name='id' value='{$row['ConsultationID']}'>
                    <button type='submit'>Delete</button>
                </form>
              </td>";
        echo "</tr>";
    }
    ?>
</table>

<!-- JavaScript for delete confirmation -->
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this consultation?");
    }
</script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
