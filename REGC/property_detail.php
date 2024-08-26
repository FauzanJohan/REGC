<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="RealEstate Logo Icon.png">
    <title>Product Detail</title>
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

    <header>
        <h1>Product Detail</h1>
    </header>

    <div id="property-info">
        <?php
        $PropertyID = $_GET['PropertyID'];

        $url = "http://localhost/ict651/ICT651Project/property_detail_api.php?PropertyID=" . $PropertyID;

        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($client);
        $result = json_decode($response);

        // Check if the response is valid
        if ($result !== null && is_array($result) && isset($result[0]->PropertyID, $result[0]->Address, $result[0]->City, $result[0]->State, $result[0]->ZipCode, $result[0]->PropertyType, $result[0]->Bedrooms, $result[0]->Bathrooms, $result[0]->Price)) {
            echo '<table class="property-table">';
            echo "<thead>";
            echo "<tr><th>ID</th><th>Address</th><th>City</th><th>State</th><th>Zip Code</th><th>Property Type</th><th>Bedrooms</th><th>Bathrooms</th><th>Price</th><th>Actions</th></tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach ($result as $x => $val) {
                echo "<tr>";
                echo "<td>" . $result[$x]->PropertyID . "</td>";
                echo "<td>" . $result[$x]->Address . "</td>"; 
                echo "<td>" . $result[$x]->City . "</td>"; 
                echo "<td>" . $result[$x]->State . "</td>"; 
                echo "<td>" . $result[$x]->ZipCode . "</td>"; 
                echo "<td>" . $result[$x]->PropertyType . "</td>";
                echo "<td>" . $result[$x]->Bedrooms . "</td>";
                echo "<td>" . $result[$x]->Bathrooms . "</td>";
                echo "<td>" . $result[$x]->Price . "</td>";
                echo "<td>
        <a class='action-btn' href='propertymap_view.php' onclick='centerMapToAddress(\"" . urlencode($result[$x]->Address) . "\");'>View on Map</a>
      </td>";

                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";

            echo '<br>';
            echo '<a class="back" href="http://localhost/ict651/ICT651Project/property_list.php">Back</a>';
        } else {
            echo '<p class="error-message">Invalid or empty response. Property details not found.</p>';
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2023 Your Company. All rights reserved.</p>
    </footer>

</body>

</html>
