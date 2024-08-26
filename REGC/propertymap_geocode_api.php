<?php
function get_geocode($address){
 
    // url encode the address
    $address = urlencode($address);
    
    // google map geocode api url
    $url ="https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyAdbXPcmyhunUNCayLaJvzFL5_s2keehJs";
 
    // get the json response from url
    $resp_json = file_get_contents($url);

    // decode the json response
    $resp = json_decode($resp_json, true);

    // response status will be 'OK', if able to geocode given address
    if ($resp['status'] == 'OK') {
        // define empty array
        $data_arr = array();
        // get the important data
        $data_arr['latitude'] = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : '';
        $data_arr['longitude'] = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : '';
        $data_arr['formatted_address'] = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : '';

        // verify if data is exist
        if (!empty($data_arr) && !empty($data_arr['latitude']) && !empty($data_arr['longitude'])) {
            return $data_arr;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

$pdo = new PDO("mysql:host=localhost;dbname=realestate", "root", "");
$stmt = $pdo->query("SELECT * FROM properties");

// Fetch data from the database
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Iterate through the results and append geocoding information
foreach ($result as &$row) {
    $geocode = get_geocode($row['Address']); // Assuming 'address' is the column name in your database
    if ($geocode) {
        $row['latitude'] = $geocode['latitude'];
        $row['longitude'] = $geocode['longitude'];
        $row['formatted_address'] = $geocode['formatted_address'];
    }
}

// Encode the result as JSON
echo json_encode($result);
?>