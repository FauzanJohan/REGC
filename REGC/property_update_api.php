<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization");

    $data = json_decode(file_get_contents("php://input"), true);
    echo '<p>Receiving data from product client to product update API: ';
    var_dump($data);
    echo '</p>';
    $PropertyID = $data["PropertyID"];
    $Address = $data["Address"];
    $City = $data["City"];

    require_once "dbconnect.php";

    $query = "UPDATE properties
                SET Address = '" . $Address . "', 
                    City = '" . $City . "'
                    WHERE PropertyID = " . $PropertyID;

    echo $query;
    $result = mysqli_query($conn, $query) or die("Update Query Failed");
    
    if ($result) {
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(array("message" => mysqli_affected_rows($conn) . " Property Updated Successfully", "status" => true));

            // Redirect to property_list.php
            echo "<script>window.location.href = 'http://localhost/ict651/ICT651Project/property_list.php';</script>";
            exit();
        } else {
            echo json_encode(array("message" => "Failed Property Not Updated ", "status" => false));
        }
    } else {
        echo json_encode(array("message" => "Failed Property Not Updated ", "status" => false));
    }
?>
