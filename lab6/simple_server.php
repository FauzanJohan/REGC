<?php
function echoo($echo) {

    return "ECHO: ".$echo;
}

$server = new SoapServer(null, array('uri' => "urn://tyler/res"));
$server->addFunction('echoo');
$server->handle();
?>
