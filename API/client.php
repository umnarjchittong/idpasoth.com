<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', 1);

// function get_wss($service_name, $service_parameter = NULL)
// {
//     require("../plugins/nusoap.php");
//     $client = new nusoap_client("https://faed.mju.ac.th/dev/ddm_v3/api/webserviceserver.php?wsdl", true);
//     $data = $client->call($service_name);
//     print_r($data);
// }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Site</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #d8ccb1;
            color: #414141;
        }
    </style>

</head>

<body>
    <h1>API - Web Service Client</h1>

    <?php
    // get_wss("First_WSS");
    ?>


    <?php
    require("../plugins/nusoap.php");
    $ns = "https://faed.mju.ac.th/dev/ddm_v3/api/service.php";
    $client = new nusoap_client($ns . "?wsdl");

    // $err = $client->getError();
    // if ($err) {
    //     echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    // }

    $result = $client->call("get_message_fiscal", array("2564", "คณบดี"));
    
    if ($client->fault) {
        echo '<h2>Fault: </h2>';
        echo '<pre>' . $client->faultcode . " " . $client->faultstring . '</pre>';
    } else {
        $err = $client->getError();
        if ($err) {
            echo '<h4>Error</h4><pre>' . $err . '</pre>';
        } else {
            echo '<h4>Result</h4><pre>';
            print_r($result);
            echo '</pre>';
        }
    }

    // * view method information
    // echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
    // echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
    // echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';    

    exit;
    ?>





    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>