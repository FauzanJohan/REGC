<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);
echo '<p>Receiving data from product client to product create API: ';
var_dump($data);
echo '</p>';
if (isset($data)) {
   $ConsultationDate = $data["ConsultationDate"];
   $Notes = $data["Notes"];
   $UserID = $data["UserID"];
   $AdminID = $data["AdminID"];
   $PropertyID = $data["PropertyID"];

    require_once "dbconnect.php";

    $query = "INSERT INTO consultations (ConsultationDate, Note, PropertyID, AdminID, UserID) 
                           VALUES ('".$ConsultationDate."', '".$Notes."', '".$UserID."', '".$AdminID."', '".$PropertyID."')";

    $result=mysqli_query($conn, $query) or die("Update Query Failed");
    if ($result)
    {
        if (mysqli_affected_rows($conn) > 0) 
        {
            http_response_code(200);
            echo json_encode(array("message" => mysqli_affected_rows($conn)." Consultation Inserted Successfully", "status" => true));
        } else 
        {
            http_response_code(400);
            echo json_encode(array("message" => "Failed Consultation Not Inserted ", "status" => false));
        } 
    } else {
        echo "bad return";
    }
}
?>
