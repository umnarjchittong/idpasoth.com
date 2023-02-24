<!doctype html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';
// echo  __DIR__ . '/vendor/autoload.php';

require_once("line-bot.php");
$fnc = new core_function();
?>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="/vender/twbs/bootstrap/dist/css/bootstrap.min.css">

  </head>
  <body>
      <h2 class="text-primary">TEST</h2>
      <?php

// $fnc->user_register_lineId("3500700238956","U39d75c332530aeae3be2661a182e8539");

?>

<?php 
// $client = new nusoap_client("https://idpasoth.com/line/wss.php?wsdl", true);
$wss = new nusoap_client("https://idpasoth.com/line/wss.php?wsdl", true);

$replyId = "U94b9c26beec046b69f2e5c3de8838bd0";

// $result = $wss->call("check_user_register_lineId", array("lineId" => $replyId));

echo "<p>Result: " . $replyId . "</p>";

echo "<p>Hworld: " . $wss->call("HelloWorld") . "</p>";

function test_check_user_register_lineId($lineId)
{
    // require("core-engine.php");
    // $fnc = new database();
    // $sql = "SELECT `so_citizen_id` FROM `so_member` WHERE `so_lineid` = '" . $lineId . "'";
    // $row = $fnc->get_db_row($sql);
    // return $sql;
    // if (!empty($row["so_citizen_id"])) {
    //     return ($row["so_citizen_id"]);
    //     // return json_encode($citizenId);

    // } else {
    //     return $sql;
    // }
}

echo "<p>test: " . $wss->call("test_check_user_register_lineId", array("lineId" => $replyId)) . "</p>";

?>
      
    <!-- Bootstrap JavaScript Libraries -->
    <script src="/vender/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
  </body>
</html>