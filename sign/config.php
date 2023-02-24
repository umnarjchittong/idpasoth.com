<?php
// link ref : https://code.tutsplus.com/tutorials/create-a-google-login-page-in-php--cms-33214
include('../core.php');
//config.php
// $credentials = '{"web":{"client_id":"576436121328-np2rstsu1kedegemjn7e0q55gn0v1o78.apps.googleusercontent.com","project_id":"soth-signin","auth_uri":"https://accounts.google.com/o/oauth2/auth","token_uri":"https://oauth2.googleapis.com/token","auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs","client_secret":"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","redirect_uris":["https://faed.mju.ac.th/soth/sign/auth_google.php"]}}';
// $credentials = json_decode($credentials, true);
//Include Google Client Library for PHP autoload file
require_once '../vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();
// $google_client->setApplicationName("SOTH GOOGLE OAuth");
//Set the OAuth 2.0 Client ID
$google_client->setClientId('576436121328-np2rstsu1kedegemjn7e0q55gn0v1o78.apps.googleusercontent.com');
//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');
//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://idpasoth.com/sign/index.php/');

// add scopes to Google API
$google_client->addScope('email');
$google_client->addScope('profile');

//start session on web page
// session_start();

?>