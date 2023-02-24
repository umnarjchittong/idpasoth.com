<!DOCTYPE html>
<html lang="en">
<?php
if (isset($_GET["act"]) && $_GET["act"] == "signIn" && isset($_POST["btn-signIn"]) && isset($_POST["email"]) && isset($_POST["pwd"])) {
    // if (!strpos($_POST["email"], "'") && !strpos($_POST["email"], "\"") && !strpos($_POST["email"], "'") && !strpos($_POST["pwd"], "\"") && !strpos($_POST["pwd"], "#") && !strpos($_POST["pwd"], "%") && !strpos($_POST["pwd"], "$") && !strpos($_POST["pwd"], "&") && !strpos($_POST["pwd"], "*") && !strpos($_POST["pwd"], "/") && !strpos($_POST["pwd"], "\")) {
    if (!strpos($_POST["email"], "'") && !strpos($_POST["email"], "\"") && !strpos($_POST["pwd"], "'") && !strpos($_POST["pwd"], "\"")) {
        include('../core.php');
        $fnc = new database;
        // check authentication by Password
        $sql = "SELECT * FROM `so-member` WHERE `so_email` LIKE '" . $_POST["email"] . "' AND `so_pwd` LIKE '" . $_POST["pwd"] . "' AND (`so_status` = 'enable' OR `so_status` = 'register')";
        // die($sql . "<br>");
        $member = $fnc->get_db_row($sql);
        if (empty($member)) {
            // echo "empty 1" . "<br>";
            // check authentication by Citizen
            $sql = "SELECT * FROM `so-member` WHERE `so_email` LIKE '" . $_POST["email"] . "' AND `so_citizen_id` LIKE '" . $_POST["pwd"] . "' AND (`so_status` = 'enable' OR `so_status` = 'register')";
            // echo $sql . "<br>";
            $member = $fnc->get_db_row($sql);
            if (empty($member)) {
                // meta goto sign failure
                // echo "meta goto sign failure";
                echo '<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=../sign/?p=signfailure">';
            } else {
                // echo "get pwd";
            }
        }
        if (!empty($member)) {
            $fnc->debug_console("member info", $member);
            $sql = "SELECT * FROM `settings` WHERE `setting_id` = 1";
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
                "so_status" => $member["so_status"],
                "so_lastupdate" => $member["so_lastupdate"],
                "auth_lv" => $member["so_auth_lv"],
                "setting" => $setting
            );
            // echo "goto member";
            echo '<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=../member/?p=welcome">';
        } else {
            // echo "phase 2";
            // echo "user not found, goto sign/";
            echo '<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=../sign/?p=membernotfound">';
        }
    } else {
        echo "are you hacker ?";
    }
    die();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>SOTH</title>

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
                        <div class="card-body px-5 py-4 text-center">

                            <div class="mb-md-2 mt-md-4 pb-2">
                                <?php if (isset($_GET["p"]) && ($_GET["p"] == "signfailure" || $_GET["p"] = "membernotfound")) { ?>
                                    <div class="mt-2 text-center text-capitalize mb-3 mt-2 text-warning"><i class="bi bi-exclamation-triangle-fill me-2"></i>ไม่พบข้อมูลสมาชิก โปรดตรวจสอบอีกครั้ง.</div>
                                <?php } ?>
                                <form action="../sign/?act=signIn" method="post">
                                    <h2 class="fw-bold mb-2 text-uppercase">SOTH Login</h2>
                                    <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" id="typeEmailX" name="email" class="form-control form-control-lg text-center" required />
                                        <label class="form-label" for="typeEmailX">Email</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" name="pwd" class="form-control form-control-lg text-center" required />
                                        <label class="form-label" for="typePasswordX">Password / หมายเลขประจำตัว ปชช.</label>
                                    </div>

                                    <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="https://m.me/umnarj" target="_blank">Forgot password? Contact admin.</a></p>

                                    <button class="btn btn-outline-light btn-lg px-5" name="btn-signIn" type="submit">Login</button>

                                    <!-- <div class="d-flex justify-content-center text-center mt-4 pt-1"> -->
                                        <!-- <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                        <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a> -->
                                        <!-- <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a> -->
                                    <!-- </div> -->
                                </form>
                            </div>

                            <div>
                                <p class="mb-0 mt-0">Don't have an account? <a href="../guest/register.php" class="text-white-50 fw-bold">Sign Up</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>