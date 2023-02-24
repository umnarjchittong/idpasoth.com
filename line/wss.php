<?php
// header('Content-Type: text/javascript; charset=utf8');

require __DIR__ . '/vendor/autoload.php';

//Create a new soap server
$server = new soap_server();
//Configure our WSDL
$server->configureWSDL("LineBot@IDPA SOTH - Line Office Automation");

$server->register('HelloWorld', array(), array('return' => 'xsd:string'));
$server->register('getData', array('num' => 'xsd:string'), array('return' => 'xsd:string'));
$server->register('user_register_lineId', array('citizenId' => 'xsd:string', 'lineId' => 'xsd:string'), array('return' => 'xsd:string'));
$server->register('check_user_register_lineId', array('lineId' => 'xsd:string'), array('return' => 'xsd:string'));
$server->register('test_check_user_register_lineId', array('lineId' => 'xsd:string'), array('return' => 'xsd:string'));
$server->register('check_viewscore_available', array(), array('return' => 'xsd:string'));
$server->register('check_matchresult_available', array(), array('return' => 'xsd:string'));
$server->register('get_my_duty', array('userId' => 'xsd:string'), array('return' => 'xsd:string'));



function HelloWorld()
{
    return "Hello, World!";
}

function getData($num)
{
    return "i am tom - " . $num;
}

function getSQL($num)
{
    $sql = "SELECT * FROM admin_member WHERE admin_member_id = " . $num;
    return $sql;
}

function user_register_lineId($citizenId, $lineId)
{
    require("../core.php");
    $fnc = new core_function();
    $result = $fnc->user_register_lineId($citizenId, $lineId);
    // $result = "OK";
    return json_encode($result);
}

function check_user_register_lineId($lineId)
{
    require("../core.php");
    $fnc = new database();
    $sql = "SELECT `so_citizen_id` FROM `so_member` WHERE `so_lineid` = '" . $lineId . "'";
    $row = $fnc->get_db_row($sql);
    // return $sql;
    if (!empty($row["so_citizen_id"])) {
        return ($row["so_citizen_id"]);
    } else {
        return "";
    }
}

function check_viewscore_available()
{
    require("line-bot.php");
    $fnc = new database();
    $result = $fnc->get_db_row("SELECT `setting_view_result` FROM `settings` ORDER BY `setting_id` Desc Limit 1");
    if ($result["setting_view_result"] == "true") {
        return "1";
    } else {
        return "";
    }
}

function check_matchresult_available()
{
    require("line-bot.php");
    $fnc = new database();
    $result = $fnc->get_db_row("SELECT `setting_match_result` FROM `settings` ORDER BY `setting_id` Desc Limit 1");
    if ($result["setting_match_result"] == "true") {
        return "1";
    } else {
        return "";
    }
}

function get_my_duty($userId){
    $sql = "SELECT `match_name`,`match_level`,`match_begin`,`on_duty_position` FROM `v_on_duty` WHERE `on_duty_status` = 'enable' AND `match_status` = 'enable' AND `so_lineid` = '" . $userId . "' ORDER BY match_begin Desc";
}

function GetUserCitizenId()
{
    require_once("line-bot.php");
    $fnc = new core_function();
}

function GetUserInfo($citizenId)
{
}

function test_check_user_register_lineId($lineId)
{
    require("../core.php");
    $fnc = new database();
    $sql = "SELECT `so_citizen_id` FROM `so_member` WHERE `so_lineid` = '" . $lineId . "'";
    $row = $fnc->get_db_row($sql);
    // return $sql;
    if (!empty($row["so_citizen_id"])) {
        return ($row["so_citizen_id"]);
    } else {
        return $sql;
    }
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
// pass our posted data (or nothing) to the soap service
$server->service(file_get_contents("php://input"));
exit();
