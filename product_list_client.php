<h1>Product List API Request</h1>

<?php

    $url = "http://localhost/ICTCOPY/product_api_list.php";
    
    //echo $url;

    $client = curl_init($url);
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
    $response = curl_exec($client);
    //var_dump($response);
    $result = json_decode($response);
    var_dump($result);
