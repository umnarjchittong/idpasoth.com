<?php
// include('../core.php');
include('config.php');

$google_client->revokeToken();

// if (isset($_GET["p"]) && $_GET["p"] = "signout") {
    
    $_SESSION["access_token"] = NULL;
    $_SESSION["member"] = NULL;
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();

    header("location:../sign/");
// }

?>