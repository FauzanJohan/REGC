<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property List</title>
    <link rel="shortcut icon" type="image/x-icon" href="RealEstate Logo Icon.png">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdbXPcmyhunUNCayLaJvzFL5_s2keehJs"></script>
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
    <h1>Property List</h1>

    <?php
    $url = "http://localhost/ict651/ICT651Project/property_list_api.php";

    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);
    $result = json_decode($response);

    echo '<table>';
    echo "<tr><th>ID</th><th>Address</th><th>City</th><th>State</th><th>Zip Code</th><th>Actions</th></tr>";
    foreach ($result as $x => $val) {
        echo "<tr>";
        echo "<td>" . $result[$x]->PropertyID . "</td>";  
        echo "<td>" . $result[$x]->Address . "</td>"; 
        echo "<td>" . $result[$x]->City . "</td>"; 
        echo "<td>" . $result[$x]->State . "</td>"; 
        echo "<td>" . $result[$x]->ZipCode . "</td>"; 
        echo "<td>
                <a class='action-btn' href='http://localhost/ict651/ICT651Project/property_detail.php?PropertyID=" . $result[$x]->PropertyID . "'>Detail</a>
              </td>"; 
        echo "</tr>";
    }
    echo "</table>";
    ?>
</div>

<footer>
    <p>&copy; 2024 Real Estate Governance and Consultation</p>
</footer>
</body>
</html>
