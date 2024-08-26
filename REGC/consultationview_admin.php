<?php
// Include the database connection file
include("dbconnect.php");

// Check if the user is logged in and is an admin (You need to implement user authentication)
// ...

// Get the Consultation ID from the URL
$consultationID = isset($_GET['id']) ? $_GET['id'] : die('Invalid Consultation ID');

// Fetch the specific consultation information with related details
$query = "SELECT consultations.*, 
                 properties.PropertyType, properties.Address, properties.City, properties.State, properties.ZipCode, 
                 users.FirstName AS UserFirstName, users.LastName AS UserLastName, users.Email AS UserEmail, users.Phone AS UserPhone, 
                 admins.FirstName AS AdminFirstName, admins.LastName AS AdminLastName, admins.Email AS AdminEmail, admins.Phone AS AdminPhone
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
    <title>View Consultation</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 70%;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>View Consultation</h1>

    <p><strong>Property Type:</strong> <?php echo $row['PropertyType']; ?></p>
    <p><strong>Address:</strong> <?php echo $row['Address']; ?></p>
    <p><strong>User Name:</strong> <?php echo $row['UserFirstName'] . ' ' . $row['UserLastName']; ?></p>
    <p><strong>User Email:</strong> <?php echo $row['UserEmail']; ?></p>
    <p><strong>User Phone:</strong> <?php echo $row['UserPhone']; ?></p>
    <p><strong>Agent Name:</strong> <?php echo $row['AdminFirstName'] . ' ' . $row['AdminLastName']; ?></p>
    <p><strong>Agent Email:</strong> <?php echo $row['AdminEmail']; ?></p>
    <p><strong>Agent Phone:</strong> <?php echo $row['AdminPhone']; ?></p>
    <p><strong>Consultation Date:</strong> <?php echo $row['ConsultationDate']; ?></p>
    <p><strong>Notes:</strong> <?php echo $row['Notes']; ?></p>

</div>

</body>
</html>
