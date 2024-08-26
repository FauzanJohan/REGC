<?php
require_once "C:/xampp7/htdocs/nusoap-0.9.5/lib/nusoap.php";
$client = new nusoap_client("http://localhost/lab6/ICT651/product_list.php?wsdl");

//replace the url according to your own project directory the web server

if(isset($_GET['category']))
{
    $category = $_GET['category'];
        
    $response = $client->call('getProd',array("category"=>$category));

    if(empty($response))
        echo "Price of that product is not available";
    else {
        echo $response;
    }
}
