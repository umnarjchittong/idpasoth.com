<!DOCTYPE html>
<html lang="en">
<?php
// ini_set('display_errors', 1);
include('../core.php');
$fnc = new database;

function gen_password_complexity($chr_len = 8)
{
    $complex_str = "";
    for ($i = 1; $i <= $chr_len; $i++) {
        $rnd_char_type = (rand(1, 4));
        switch ($rnd_char_type) {
            case "1":
                $complex_str .= chr(rand(65, 90)); // Uppercase characters of European languages (A through Z)
                break;
            case "2":
                $complex_str .= chr(rand(97, 112)); // Lowercase characters of European languages (a through z, sharp-s)
                break;
            case "3":
                $complex_str .= chr(rand(48, 57)); // Base 10 digits (0 through 9)
                break;
            case "4":
                $complex_str .= chr(rand(35, 38)); // Nonalphanumeric characters
                break;
        }
    }
    return $complex_str;;
}

if (isset($_GET["p"]) && $_GET["p"] == "forgot" && isset($_GET["act"]) && $_GET["act"] == "recovery" && isset($_POST["btn-recovery"])) {
    // echo "<br>i'm in";
    if (isset($_POST["email"])) {
        // echo "find citizen";

        // $sql = "SELECT * FROM `so_member` WHERE `so_email` LIKE '" . $_POST["email"] . "' AND `so_citizen_id` LIKE '" . $_POST["cid"] . "' AND `so_dob` = '" . $_POST["bod"] . "' AND `so_status` <> 'delete'";
        $sql = "SELECT * FROM `so_member` WHERE `so_email` LIKE '" . $_POST["email"] . "' AND `so_status` <> 'delete'";
        $member = $fnc->get_db_row($sql);
        // echo "<br>sql=" . $sql;
        // print_r($member);
        if (!empty($member)) {
            // $fnc->debug_console("member info", $member);
            // $sql = "SELECT * FROM `settings` WHERE `setting_id` = 1";
            // $setting = $fnc->get_db_array($sql)[0];
            // $_SESSION["member"] = array(
            //     "so_id" => $member["so_id"],
            //     "so_idpa_id" => $member["so_idpa_id"],
            //     "so_club" => $member["so_club"],
            //     "so_firstname" => $member["so_firstname"],
            //     "so_lastname" => $member["so_lastname"],
            //     "so_firstname_en" => $member["so_firstname_en"],
            //     "so_lastname_en" => $member["so_lastname_en"],
            //     "so_nickname" => $member["so_nickname"],
            //     "so_citizen_id" => $member["so_citizen_id"],
            //     "so_email" => $member["so_email"],
            //     "so_avatar" => "../" . $member["so_avatar"],
            //     "so_status" => $member["so_status"],
            //     "so_lastupdate" => $member["so_lastupdate"],
            //     "auth_lv" => $member["so_auth_lv"],
            //     "setting" => $setting
            // );
            // echo "goto email";
            // echo "<hr><h2>";

            $new_pwd = $fnc->gen_password_complexity();
            $sql = "UPDATE `so_member` SET `so_pwd`='" . $new_pwd . "',`so_status`='forcepwd' WHERE `so_email` LIKE '" . $_POST["email"] . "' AND `so_citizen_id` LIKE '" . $_POST["cid"] . "'";
            $fnc->sql_execute($sql);
            // echo "</h2><hr>";

            $content_html = '<meta charset="UTF-8">
            <div style="margin:0em; padding: 2em; width:600px;">
                <img src="https://idpasoth.com/sign/images/soth_banner.png" style="width:100%">
                <div style="margin-top:2em;">
                    <h3>แอดมินขอแจ้งรหัสผ่านใหม่ สำหรับเข้าระบบ</h3>
                    <h2 style="color:#2B7ADB;">' . $new_pwd . '</h2>
                    <p>โปรดใช้รหัสนี้ เพื่อเข้าสู่ระบบ และทำการเปลี่ยนรหัสผ่านใหม่ทันที.</p>
                    <p>คลิกเข้าสู่ระบบ <a href="https://idpasoth.com/sign/sign/?em=' . $_POST["email"] . '&pw=' . $new_pwd . '" target="_blank"><strong>SOTH</strong></a></p>
                </div>
                <div style="margin-top:5em;">
                    <p>ทีมงานแอดมิน SOTH</p>
                    <img src="https://idpasoth.com/sign/images/soth_logo-120.png">
                </div>
            </div>';

            $mailer = new Mailer;
            $mailer->send_email($_POST["email"], $member["so_firstname_en"] . " " . $member["so_lastname_en"], "SOTH ลืมรหัสผ่าน", $content_html, "../sign/forgot_pwd.php?p=forgot&act=complete");
            // echo '<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=forgot_pwd.php?p=forgot&act=complete">';
        } else {
            // echo "phase 2";
            echo "user not found, goto sign/";
            // echo '<meta http-equiv="refresh" content="' . $fnc->system_meta_redirect . ';url=forgot_pwd.php?p=forgot&act=membernotfound&step=1">';
        }
    } elseif (isset($_POST["email"]) && $_POST["email"] != "" && !strpos($_POST["email"], "'") && !strpos($_POST["email"], "\"")) {
        // check authentication by Password
        $sql = "SELECT `so_id`,`so_idpa_id`,`so_status` FROM `so_member` WHERE `so_email` LIKE '" . $_POST["email"] . "' AND `so_status` <> 'delete'";
        // die($sql . "<br>");
        $row = $fnc->get_db_row($sql);
        if (empty($row)) {
            echo '<meta http-equiv="refresh" content="' . ($fnc->system_meta_redirect + 5) . ';url=forgot_pwd.php?p=forgot&act=membernotfound&step=2">';
            die();
        } else {
            $recovery = array("so_id" => $row["so_id"], "so_email" => $_POST["email"], "so_status" => $row["so_status"]);
            // echo "<br>i'm founded";
            // print_r($recovery);
        }
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
    
    <link rel="stylesheet" href="../css/style.css">
    <title>SOTH - Forgot Password</title>

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
                    <div class="card bg-dark text-white box_shadow" style="border-radius: 0rem 0rem 1rem 1rem; background-color: #9b0000;">
                        <img src="../images/soth_banner.png" class="img-responsive w-100">
                        <div class="card-body px-5 py-2 text-center">

                            <div class="mb-md-2 mt-md-4 pb-2 text-center">
                                <?php if (isset($_GET["p"]) && $_GET["p"] == "forgot" && isset($_GET["act"]) && $_GET["act"] == "membernotfound") {
                                    echo '<div class="mt-2 text-center text-capitalize mb-3 mt-2 text-warning"><i class="bi bi-exclamation-triangle-fill me-2"></i>ไม่พบข้อมูลสมาชิก โปรดตรวจสอบอีกครั้ง</div>';
                                } 

                                if (isset($_GET["p"]) && $_GET["p"] == "forgot" && isset($_GET["act"]) && $_GET["act"] == "complete") { ?>
                                <h2 class="fw-bold mt-3 mb-2 text-uppercase">Recovery Completed</h2>
                                    <p class="text-warning mt-5 mb-4 h5">ระบบจัดส่งข้อมูลไปยังอีเมลของท่านแล้ว.</p>
                                    <p class="text-white-50 mt-2 mb-4">* หากไม่ได้จดหมาย ลองดูใน junk mail</p>

                                <?php } else { ?>

                                <form action="?p=forgot&act=recovery" method="post">
                                    <h2 class="fw-bold mb-2 text-uppercase">การกู้คืนบัญชี</h2>
                                    <p class="text-white-50 mb-4">โปรดระบุข้อมูลของท่าน</p>

                                    <?php if (!empty($recovery)) { ?>
                                        <div class="form-outline form-white mb-3">
                                            <input type="text" id="cid" name="cid" class="form-control form-control-lg text-center" minlength="13" maxlength="13" required />
                                            <label class="form-label" for="cid">หมายเลขประจำตัว ปชช.</label>
                                        </div>

                                        <div class="form-outline form-white mb-3">
                                            <input type="date" id="bod" name="bod" class="form-control form-control-lg text-center" required />
                                            <label class="form-label" for="bod">เดือน-วัน-ปี เกิด</label>
                                        </div>
                                    <?php
                                        echo '<input type="hidden" name="email" value="' . $recovery["so_email"] . '">';
                                        echo '<input type="hidden" name="soid" value="' . $recovery["so_id"] . '">';
                                    } else { ?>

                                        <div class="form-outline form-white mb-3">
                                            <input type="email" id="email" name="email" class="form-control form-control-lg text-center" required />
                                            <label class="form-label" for="email">Email ที่ใช้ลงทะเบียน</label>
                                        </div>

                                    <?php } ?>

                                    <input type="hidden" name="fst" value="pwdRecovery">
                                    <button class="btn btn-outline-light btn-lg px-5" name="btn-recovery" type="submit">ตรวจสอบข้อมูล</button>

                                </form>
                                <?php } ?>
                            </div>

                            <div>
                                <a class="text-white-50" href="https://m.me/umnarj" target="_blank">ติดต่อแอดมิน</a>
                                <p class="mb-0 mt-0">ยังไม่เคยสมัคร? <a href="../guest/register.php" class="text-white-50 fw-bold">ลงทะเบียน</a></p>
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