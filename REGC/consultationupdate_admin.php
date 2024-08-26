<?php
// Include the database connection file
include("dbconnect.php");

// Check if the user is logged in and is an admin (You need to implement user authentication)
// ...

// Check if the form is submitted for updating consultation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_consultation'])) {
    $consultationID = $_POST['consultationID'];
    $newConsultationDate = $_POST['newConsultationDate'];
    $newNotes = $_POST['newNotes'];

    // Update the consultation in the database
    $updateQuery = "UPDATE consultations SET ConsultationDate = '$newConsultationDate', Notes = '$newNotes' WHERE ConsultationID = $consultationID";
    $updateResult = mysqli_query($conn, $updateQuery);

    if (!$updateResult) {
        die("Update failed: " . mysqli_error($conn));
    }

    // Redirect back to the consultation_admin.php page after updating
    header("Location: consultation_admin.php");
    exit;
}

// Check if the Consultation ID is provided in the URL
$consultationID = isset($_GET['id']) ? $_GET['id'] : die('Invalid Consultation ID');

// Fetch the specific consultation information with related details
$query = "SELECT consultations.*, 
                 properties.PropertyType, properties.Address, properties.City, properties.State, properties.ZipCode, 
                 users.FirstName AS UserFirstName, users.LastName AS UserLastName, 
                 admins.FirstName AS AdminFirstName, admins.LastName AS AdminLastName
          FROM consultations
          LEFT JOIN properties ON consultations.PropertyID = properties.PropertyID
          LEFT JOIN users ON consultations.UserID = users.UserID
          LEFT JOIN admins ON consultations.AdminID = admins.AdminID
          WHERE consultations.ConsultationID = $consultationID";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Consultation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        form {
            width: 50%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Update Consultation</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="consultationID" value="<?php echo $row['ConsultationID']; ?>">

        <label for="newConsultationDate">New Consultation Date:</label>
        <input type="date" id="newConsultationDate" name="newConsultationDate" value="<?php echo $row['ConsultationDate']; ?>" required>

        <br>

        <label for="newNotes">New Notes:</label>
        <textarea id="newNotes" name="newNotes" rows="4" cols="50"><?php echo $row['Notes']; ?></textarea>

        <br>

        <input type="submit" name="update_consultation" value="Update Consultation">
    </form>
</div>

</body>
</html>
