<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Update Form</title>
    <link rel="shortcut icon" type="image/x-icon" href="RealEstate Logo Icon.png">
    <link rel="stylesheet" href="style.css">
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
            </ul>
        </nav>
    </header>

    <header>
        <h1>Product Update Form</h1>
    </header>

    <div id="property-info">
        <?php
        if (isset($_GET['PropertyID'])) {
            $PropertyID = $_GET['PropertyID'];
            $url = "http://localhost/ict651/ICT651Project/property_detail_api.php?PropertyID=" . $PropertyID;

            $client = curl_init($url);
            curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($client);
            $result = json_decode($response);

            echo "<p>ID : " . $result[0]->PropertyID . "</p>";
            echo "<p>Address : " . $result[0]->Address . "</p>";
            echo "<p>City : " . $result[0]->City . "</p>";
        ?>
            <form method="POST">
                <label for="Address">Address:</label><br>
                <input type="text" id="Address" name="Address" value="<?php echo $result[0]->Address ?>"><br>
                <label for="City">City:</label><br>
                <input type="text" id="City" name="City" value="<?php echo $result[0]->City ?>"><br>
                <input type="hidden" name="PropertyID" value="<?php echo $result[0]->PropertyID ?>"><br>
                <input type="submit" name="submit" value="Submit"><br><br>
                <a class="back-link" href="http://localhost/ict651/ICT651Project/property_list.php">Back</a>
            </form>
            <?php
            if (isset($_POST['submit'])) {
                $url = "http://localhost/ict651/ICT651Project/property_update_api.php";
                // Create a new cURL resource
                $ch = curl_init($url);

                // Setup request to send json via POST
                $data = array(
                    'PropertyID' => $_POST['PropertyID'],
                    'Address' => $_POST['Address'],
                    'City' => $_POST['City']
                );
                $payload = json_encode($data);

                // Attach encoded JSON string to the POST fields
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                // Set the content type to application/json
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                // Return response instead of outputting
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // Execute the POST request
                $result = curl_exec($ch);

                // Close cURL resource
                curl_close($ch);
                // var_dump ($result);
                echo '<br>';
            }
        } else {
            echo 'Invalid request.';
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2023 Your Company. All rights reserved.</p>
    </footer>
    <?php
    if (isset($_POST['submit'])) {
        echo "<script>window.location.href = 'http://localhost/ict651/ICT651Project/property_list.php';</script>";
    }
    ?>
</body>

</html>
