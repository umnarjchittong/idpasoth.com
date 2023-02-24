<!DOCTYPE html>
<html lang="en">
<?php
// ? sign-in with google, sign-in with password only (no citizen)
// ? forgot password Step#1 confirm email, citizen, bod Step#2 if pass sent temp pass Step#3 force change password after user temp pass
// ini_set('display_errors', 1);
// include('../core.php');
include('config.php');
$login_button = '';
$fnc = new database;

//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if (isset($_GET["code"])) {
    //It will Attempt to exchange a code for an valid authentication token.
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    $fnc->debug_console("get code");

    //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
    if (!isset($token['error'])) {
        //Set the access token used for requests
        $google_client->setAccessToken($token['access_token']);

        //Store "access_token" value in $_SESSION variable for future use.
        $_SESSION['access_token'] = $token['access_token'];

        //Create Object of Google Service OAuth 2 class
        $google_service = new Google_Service_Oauth2($google_client);

        //Get user profile data from google
        $data = $google_service->userinfo->get();

        if (!empty($data)) {
            $google_user = array("email" => $data['email'], "picture" => $data['picture'], "verified_email" => $data["verified_email"]);
        }
    }
    get_member_info($google_user);
}

//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if (!isset($_SESSION['access_token'])) {
    //Create a URL to obtain user authorization
    // $login_button = '<a href="' . $google_client->createAuthUrl() . '"><i class="fab fa-google fa-lg"></i></a>';
    if (isset($_GET['lineid']) && $_GET['lineid'] != '') {
        $_SESSION['lineid'] = $_GET['lineid'];
    } else {
        $_SESSION['lineid'] = "";
    }
    $login_button = '<a href="' . $google_client->createAuthUrl() . '"><img src="../images/sign-in-with-google-w200.png" class="img-responsive w-100" /></a>';
}
// $fnc->debug_console("login_button = " . $login_button);

if (isset($_GET["act"]) && $_GET["act"] == "signIn" && isset($_POST["btn-signIn"]) && isset($_POST["email"]) && isset($_POST["pwd"])) {
    // if (!strpos($_POST["email"], "'") && !strpos($_POST["email"], "\"") && !strpos($_POST["email"], "'") && !strpos($_POST["pwd"], "\"") && !strpos($_POST["pwd"], "#") && !strpos($_POST["pwd"], "%") && !strpos($_POST["pwd"], "$") && !strpos($_POST["pwd"], "&") && !strpos($_POST["pwd"], "*") && !strpos($_POST["pwd"], "/") && !strpos($_POST["pwd"], "\")) {
    if (!strpos($_POST["email"], "'") && !strpos($_POST["email"], "\"") && !strpos($_POST["pwd"], "'") && !strpos($_POST["pwd"], "\"")) {
        // check authentication by Password
        $sql = "SELECT * FROM `so_member` WHERE `so_email` LIKE '" . $_POST["email"] . "' AND `so_pwd` LIKE '" . $_POST["pwd"] . "' AND `so_status` <> 'delete'";
        // die($sql . "<br>");
        $member = $fnc->get_db_row($sql);
        // if (empty($member)) {
        //     echo '<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=../sign/?p=membernotfound&s0">';
        // }
        if (!empty($member)) {
            $fnc->debug_console("member info", $member);
            $sql = "SELECT * FROM `settings` ORDER BY `setting_id` Desc LIMIT 1";
            $setting = $fnc->get_db_row($sql);
            $_SESSION["member"] = array(
                "so_id" => $member["so_id"],
                "so_idpa_id" => $member["so_idpa_id"],
                "so_club" => $member["so_club"],
                "so_firstname" => $member["so_firstname"],
                "so_lastname" => $member["so_lastname"],
                "so_firstname_en" => $member["so_firstname_en"],
                "so_lastname_en" => $member["so_lastname_en"],
                "so_nickname" => $member["so_nickname"],
                "so_citizen_id" => $member["so_citizen_id"],
                "so_email" => $member["so_email"],
                "so_lineid" => $member["so_lineid"],
                "so_avatar" => "../" . $member["so_avatar"],
                "so_status" => $member["so_status"],
                "so_lastupdate" => $member["so_lastupdate"],
                "auth_lv" => $member["so_auth_lv"],
                "setting" => $setting
            );
            if (isset($_POST['lineid']) && $_POST['lineid'] != '') {
                if ($_SESSION["member"]["so_lineid"] != $_POST['lineid'])
                $sql = "UPDATE `so_member` SET `so_lineid`='" . $_POST['lineid'] . "' WHERE `so_citizen_id` = '" . $_SESSION["member"]["so_citizen_id"] . "'";
                $fnc->sql_execute($sql);
                $_SESSION["member"]["so_lineid"] = $_POST['lineid'];
            }
            // echo "goto member";
            die('<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=../member/?p=welcome&method=login">');
        } else {
            // echo "phase 2";
            // echo "user not found, goto sign/";
            die('<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=../sign/?p=membernotfound&s1">');
        }
    } else {
        // echo "are you H ?";
        echo "Something is Problem Please contact Admin.";
    }
    die("E100");
}

function get_member_info($google_user)
{
    global $fnc;
    // check authentication by Password
    $sql = "SELECT * FROM `so_member` WHERE `so_email` LIKE '" . $google_user["email"] . "' AND (`so_status` = 'enable' OR `so_status` = 'register')";
    $fnc->debug_console("sql: " . $sql);
    die();
    $member = $fnc->get_db_row($sql);
    if (!empty($member)) {
        $fnc->debug_console("member info", $member);
        $sql = "SELECT * FROM `settings` ORDER BY `setting_id` Desc LIMIT 1";
        $setting = $fnc->get_db_array($sql)[0];
        $_SESSION["member"] = array(
            "so_id" => $member["so_id"],
            "so_idpa_id" => $member["so_idpa_id"],
            "so_club" => $member["so_club"],
            "so_firstname" => $member["so_firstname"],
            "so_lastname" => $member["so_lastname"],
            "so_firstname_en" => $member["so_firstname_en"],
            "so_lastname_en" => $member["so_lastname_en"],
            "so_nickname" => $member["so_nickname"],
            "so_citizen_id" => $member["so_citizen_id"],
            "so_email" => $member["so_email"],
            "so_lineid" => $member["so_lineid"],
            "so_avatar" => str_replace("=//", "://", $google_user["picture"]),
            "so_status" => $member["so_status"],
            "so_lastupdate" => $member["so_lastupdate"],
            "auth_lv" => $member["so_auth_lv"],
            "setting" => $setting
        );
        if (!empty($member["so_avatar"]) && $member["so_avatar"] != "img/person.png") {
            $_SESSION["member"]["so_avatar"] = '../' . $member["so_avatar"];
        }
        // echo "goto member";
        // if (isset($_GET['lineid']) && $_GET['lineid'] != '') {
        //     $lineid = "&lineid=" . $_GET['lineid'];
        // } else {
        //     $lineid = "";
        // }
        if (isset($_SESSION['lineid']) && $_SESSION['lineid'] != '' && $_SESSION["member"]["so_lineid"] != $_SESSION['lineid']) {
            $sql = "UPDATE `so_member` SET `so_lineid`='" . $_SESSION['lineid'] . "' WHERE `so_citizen_id` = '" . $_SESSION["member"]["so_citizen_id"] . "'";
            $fnc->sql_execute($sql);
            $_SESSION["member"]["so_lineid"] = $_SESSION['lineid'];
        }
        // echo "goto member";
        die('<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=../member/?p=welcome&method=google">');
        // die();
    } else {
        // echo "phase 2";
        // echo "user not found, goto sign in again";
        // die();
        die('<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=../sign/?p=membernotfound&s=2">');
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->

    <!-- Favicons -->
    <link href="../images/favicon.png" rel="icon">

    <link rel="stylesheet" href="../css/style.css">
    <title>SOTH SignIn</title>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white box_shadow" style="border-radius: 1rem; background-color: #9b0000;">
                        <img src="../images/soth_banner.png" class="img-responsive w-100">
                        <div class="card-body px-5 py-2 text-center">

                            <div class="mb-md-2 mt-md-4 pb-2">
                                <?php if (isset($_GET["p"]) && ($_GET["p"] == "signfailure" || $_GET["p"] = "membernotfound")) { ?>
                                    <div class="mt-2 text-center text-capitalize mb-3 mt-2 text-warning"><i class="bi bi-exclamation-triangle-fill me-2"></i>ไม่พบข้อมูลสมาชิก โปรดตรวจสอบอีกครั้ง.</div>
                                <?php } ?>
                                <form action="../sign/?act=signIn" method="post">
                                    <h2 class="fw-bold mb-2 text-uppercase">SOTH Login</h2>
                                    <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" id="typeEmailX" name="email" class="form-control form-control-lg text-center" <?php if (isset($_GET["em"])) {
                                                                                                                                                echo ' value="' . $_GET["em"] . '"';
                                                                                                                                            } ?> required />
                                        <label class="form-label" for="typeEmailX">Email</label>
                                    </div>

                                    <div class="form-outline form-white mb-3">
                                        <input type="password" id="typePasswordX" name="pwd" class="form-control form-control-lg text-center" <?php if (isset($_GET["pw"])) {
                                                                                                                                                    echo ' value="' . $_GET["pw"] . '"';
                                                                                                                                                } ?> required />
                                        <label class="form-label" for="typePasswordX">Password</label>
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5" name="btn-signIn" type="submit">Login</button>

                                    <div class="d-flex justify-content-center text-center mt-3 pt-1">
                                        <!-- <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                        <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a> -->
                                        <?php if (isset($login_button) && $login_button != '') {
                                            echo $login_button;
                                        }
                                        if (isset($_GET['lineid']) && $_GET['lineid'] != '') {
                                            echo '<input type="hidden" name="lineid" value="' . $_GET['lineid'] . '">';
                                        }
                                        ?>
                                    </div>
                                </form>
                            </div>

                            <div>
                                <p class="small mb-2 pb-lg-2 mt-3"><a class="text-white-50" href="forgot_pwd.php" target="_blank">Forgot password?</a> <a class="text-white-50" href="https://m.me/umnarj" target="_blank">Contact admin.</a></p>
                                <p class="mb-0 mt-0">Don't have an account? <a href="../guest/register.php" class="text-white-50 fw-bold">Sign Up</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VVZW40KL0H"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-VVZW40KL0H');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>