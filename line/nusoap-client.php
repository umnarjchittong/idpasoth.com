<?php
require __DIR__ . '/vendor/autoload.php';
$client = new nusoap_client("https://idpasoth.com/line/wss.php?wsdl", true);

// $result = $client->call("check_user_register_lineId", array("citizenId" => "3500700238956"), array("lineId" => "123456"));
// $result = $client->call("check_user_register_lineId", array("lineId" => $userId));
// $result = json_decode($client->call("check_user_register_lineId", array("lineId" => $userId)), true)["so_citizen_id"];
$result = $client->call("check_viewscore_available", array());
// $result = $client->call("user_register_lineId", array("citizenId" => "3500700238956"), array("lineId" => "123456"));
// $result = $client->call("getData", array("num" => 90));
// $result = $client->call("HelloWorld");

if ($client->fault) {
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '</pre>';
} else {
	// Check for errors
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		// Display the result
		echo '<h2>Result</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
}

echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
