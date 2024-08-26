<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "dbconnect.php";

$query = "SELECT ConsultationID, UserID, AdminID, ConsultationDate, Notes FROM consultations";

$result = mysqli_query($conn, $query) or die("Select Query Failed.");

$count = mysqli_num_rows($result);

if ($count > 0) {
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response = array("data" => $row);  // Add a key to include all data
    http_response_code(200);
    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No Property Found.", "status" => false));
}

?>
