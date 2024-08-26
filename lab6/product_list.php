<?php
require_once "C:/xampp7/htdocs/nusoap-0.9.5/lib/nusoap.php";

function getProd($category) {
    if ($category == "books") {
        return join(",", array(
            "The WordPress Anthology",
            "PHP Master: Write Cutting Edge Code",
            "Build Your Own Website the Right Way"));
    }
    else {
            return "No products listed under that category";
    }
    
}

$server = new soap_server();
$server->configureWSDL("Soap Demo","urn:soapdemo"); // Configure WSDL file
$server->soap_defencoding = 'utf-8'; 
$server->encode_utf8 = false;
$server->decode_utf8 = false;
$server->register(
    "getProd", // name of function
    array("category"=>"xsd:string"),  // inputs
    array("return"=>"xsd:string"),   // outputs
);
//$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)? $HTTP_RAW_POST_DATA : '';
$server->service(file_get_contents("php://input"));
?>
