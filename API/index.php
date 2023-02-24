<?php
require("../plugins/nusoap.php");

require("../core.php");

// create a new soap server variable
$server = new soap_server();

// Define our namesapce
$namespace = "https://faed.mju.ac.th/dev/ddm_v3/api/WebServiceServer.php";
$server->wsdl->schemaTargetNamespace = $namespace;

// Configure our WSDL
$server->configureWSDL("Leads");



?>