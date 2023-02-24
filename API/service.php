<?php
ini_set('display_errors', 0);
require("../plugins/nusoap.php");

require_once("../core.php");

$server = new soap_server(); // create a new soap server variable

$ns = "https://faed.mju.ac.th/dev/ddm_v3/api/service.php"; // Define our namesapce
$server->configureWSDL("DDM: Dean's Direct Messages", $ns); // Configure our WSDL Title
$server->wsdl->schemaTargetNamespace = $ns; // set our namespace

// Register our method
// * all server register name the same function name right here
// todo $server->register(//method name, //parameter list: array('name' => 'xsd:string'), //return value(s): array('return' => 'xsd:string'), //namespace, //soapaction: false (default), style: rpc or document, //use: encoded or literal, //description: documentation for this method, //encoding style (optional)
$server->register("hello", array(), array('return' => 'xsd:string'), $ns, $ns . "#hello", 'rpc', 'encoded', 'Says hello to the caller');
$server->register("get_message_fiscal", array('fiscal' => 'xsd:string', 'assigned' => 'xsd:string', 'debug' => 'xsd:boolean'), array('return' => 'xsd:string'));

// ? input xsd type : integer, string, boolean
// ? input tns type : customize array

// * Create a complex types
/*$server->wsdl->addComplexType(
    'MyComplexType',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'ID' => array(
            'name' => 'ID', 'type' => 'xsd:int'
        ),
        'YourName' => array(
            'name' => 'YourName', 'type' => 'xsd:string'
        )
    )
);

// * Register our method using the complex type
$server->register(
    // method name:
    'HelloComplexWorld',
    // parameter list:
    array('name' => 'tns:MyComplexType'),
    // return value(s):
    array('return' => 'tns:MyComplexType'),
    // namespace:
    $namespace,
    // soapaction: (use default)
    false,
    // style: rpc or document
    'rpc',
    // use: encoded or literal
    'encoded',
    // description: documentation for the method
    'Complex Hello World Method'
);*/

// * function name same the register name right here
function hello()
{
    return "hello-world";
}

// function HelloComplexWorld($mycomplextype)
// {
//     return $mycomplextype;
// }

function get_message_fiscal($fiscal = null, $assigned = null, $debug = false)
{
    $fnc_db = new database(); // include core.php using class database
    $sql = "SELECT COUNT(message_id) as cnt_id FROM message WHERE "; // create starter sql
    if (!$fiscal) { // check $fiscal value
        $fiscal = $fnc_db->get_fiscal_year(); // get current fiscal
    }
    $message = array("fiscal" => $fiscal); // assign fiscal to array    
    if ($assigned) { // check $assigned value
        $sql_assigned = " AND message_assigned = '" . $assigned . "'"; // gen sql for assigned
        $message["assigned"] = $assigned; // assign assigned to array
    }    
    $message["all"] = $fnc_db->get_db_col($sql . "message_fiscal_year = '" . $fiscal . "'" . $sql_assigned);
    $message["active"] = $fnc_db->get_db_col($sql . "message_status != 'deleted' AND message_fiscal_year = '" . $fiscal . "'" . $sql_assigned);
    $message["new"] = $fnc_db->get_db_col($sql . "message_status = 'new' AND message_fiscal_year = '" . $fiscal . "'" . $sql_assigned);
    $message["read"] = $fnc_db->get_db_col($sql . "message_status = 'read' AND message_fiscal_year = '" . $fiscal . "'" . $sql_assigned);
    $message["completed"] = $fnc_db->get_db_col($sql . "message_status = 'completed' AND message_fiscal_year = '" . $fiscal . "'" . $sql_assigned);
    $message["deleted"] = $fnc_db->get_db_col($sql . "message_status = 'deleted' AND message_fiscal_year = '" . $fiscal . "'" . $sql_assigned);
    if ($debug === true) {
        $message["sql"] = $sql . "message_fiscal_year = '" . $fiscal . "'" . $sql_assigned;
    }
    return json_encode($message, JSON_UNESCAPED_UNICODE);
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : ''; // Get our posted data if the service is being consumed otherwise leave this data blank
$server->service(file_get_contents("php://input")); // pass our posted data (or nothing) to the soap service
exit;