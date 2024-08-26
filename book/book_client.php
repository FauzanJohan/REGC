<?php

$ISBN = "";
if (isset($_POST["submit"])) {
  $ISBN = $_POST["ISBN"];
}

$url = "http://localhost/ICT651/book/" . $ISBN;

// Try to make the curl request.
try {
  $client = curl_init($url);
  curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($client);

  // Check the HTTP status code.
  $info = curl_getinfo($client);
  $httpStatus = $info['http_code'];

  // If the HTTP status code is 200, then the request was successful.
  if ($httpStatus === 200) {
    // Decode the response as JSON.
    $result = json_decode($response);

    // Display the book information.
    echo "ISBN: " . $result->ISBN;
    echo "<br>Title: " . $result->title;
    echo "<br>Price: RM " . $result->price;
  } else {
    // Throw an exception if the request was not successful.
    throw new Exception("The request to the books service failed.");
  }
} catch (Exception $e) {
  // Handle the error here.
  echo "Error: " . $e->getMessage();
}

// Close the curl connection.
curl_close($client);

?>