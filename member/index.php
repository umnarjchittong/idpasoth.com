<!doctype html>
<html lang="en">
<?php
include('../core.php');
$fnc = new web;
if ((!$_SESSION["member"])) {
    die('<meta http-equiv="refresh" content="0;url=../sign/signout.php?p=no-right">');
    die();
} else {
    // if ($_SESSION["member"]["auth_lv"] >= 9) {
    // $fnc->system_debug = $_SESSION["member"]["setting"]["setting_debug_show"];
    //     $fnc->system_alert = $_SESSION["member"]["setting"]["setting_alert"];
    //     $fnc->system_meta_redirect = $_SESSION["member"]["setting"]["setting_meta_redirect"];
    //     // $fnc->database_sample = $_SESSION["member"]["setting"]["setting_db_name"];
    // }
    $fnc->debug_console("member info", $_SESSION["member"]);
}

function gen_announce_board()
{
    echo '<h3 class="mt-3">My Info</h3>';
    echo '<div class="card col-12 col-md-10 col-lg-8 box_shadow">
    
    
    
  </div>';
}
?>

<head>
    <title>SOTH - Member Home</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link href="../images/favicon.png" rel="icon">
    <!-- <link href="../images/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
    <!-- Convert this to an external style sheet -->

</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SOTH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize">
                    <li class="nav-item">
                        <a class="nav-link<?php if (!isset($_GET["p"])) {
                                                echo ' active" aria-current="page';
                                            } ?>" href="../member/">หน้าแรก</a>
                    </li>
                    <?php if ($_SESSION["member"]["auth_lv"] >= 5) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">สำหรับเจ้าหน้าที่</a>
                            <ul class="dropdown-menu box_shadow">
                                <!-- <li><a class="dropdown-item" href="../admin/?p=sanction" target="_top">Match ที่ขอจัด</a></li> -->
                                <?php if ($_SESSION["member"]["auth_lv"] >= 5 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- MD -</a></li>
                                    <li><a class="dropdown-item" href="../member/?p=match&act=newmatch" target="_top">ลงทะเบียน Match</a></li>
                                    <li><a class="dropdown-item" href="../member/?p=match&act=sanction">Match ที่ขอจัดไว้</a></li>
                                    <li><a class="dropdown-item" href="../member/?p=match&act=approved">Match ที่อนุมัติแล้ว</a></li>
                                    <li><a class="dropdown-item" href="../admin/shooter.php?p=shooter" target="_blank">ประวัติ นกฬ.</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 6 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- STAT -</a></li>
                                    <li><a class="dropdown-item" href="../score/" target="_blank">ผลการแข่ง</a></li>
                                    <li><a class="dropdown-item" href="../admin/shooter.php?p=approve" target="_blank">ตรวจสอบ นกฬ.</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 7 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- ADMIN -</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=sanction" target="_top">Match ที่ขอจัด</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=match">จัดการ Match</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=cso">จัดการ CSO</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=so">จัดการ SO</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=member">จัดการสมาชิกทั้งหมด</a></li>
                                    <li><a class="dropdown-item" href="../admin/report.php?p=rpt&v=Trainnee&order=FULL%20NAME&sort=a">SO ที่ผ่านฝึกงาน</a></li>
                                    <li><a class="dropdown-item" href="../admin/report.php?p=rpt">รายงานระบบ</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 8 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <!-- <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- EDITOR -</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=so">จัดการ SO</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=match">จัดการ Match</a></li> -->
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- DEVELOPER -</a></li>
                                    <li><a class="dropdown-item" href="../admin/setting.php">ตั้งค่า</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET["p"]) && $_GET["p"] == "jobs") {
                                                echo ' active" aria-current="page';
                                            } ?>" href="../member/?p=jobs">การทำหน้าที่ SO</a>
                    </li>
                    <?php if ($_SESSION["member"]["auth_lv"] >= 5) { ?>
                        <li class="nav-item">
                            <a class="nav-link<?php if (isset($_GET["p"]) && $_GET["p"] == "match") {
                                                    echo ' active" aria-current="page';
                                                } ?>" href="../member/?p=match">การแข่งขันทั้งหมด</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET["p"]) && $_GET["p"] == "profile") {
                                                echo ' active" aria-current="page';
                                            } ?>" href="../member/?p=profile">โปรไฟล์ของฉัน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../member/?p=download">ดาวน์โหลด</a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link" href="../sign/signout.php?p=signout">ออกจากระบบ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-shrink-0">
        <div class="container">
            <?php
            if (!empty($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] == 0 && $_SESSION["member"]["so_status"] == "register" && isset($_GET["p"]) && $_GET["p"] == "welcome") {
                die('<meta http-equiv="refresh" content="0;url=?p=profile">');
            } else {
                if (isset($_GET["p"]) && $_GET["p"] != "") {
                    switch ($_GET["p"]) {
                        case "profile":
                            $fnc->so_form_update($_SESSION["member"]["so_id"]);
                            break;
                        case "download":
                            // $fnc->so_form_update($_SESSION["member"]["so_id"]);
                            echo '<h4 class="mt-5 mb-4">ดาวน์โหลดเอกสาร</h4>';
                            $fnc->gen_download_list();
                            break;
                        case "jobs":
                            $fnc->so_on_duty($_SESSION["member"]["so_id"]);
                            break;
                        case "match":
                            if (isset($_GET["act"]) && $_GET["act"] == "newmatch") {
                                $fnc->match_form_add_sanction();
                            } elseif (isset($_GET["act"]) && $_GET["act"] == "sanction") {
                                $fnc->match_sanction_list($_SESSION["member"]["so_citizen_id"]);
                            } elseif (isset($_GET["act"]) && $_GET["act"] == "approved") {
                                $fnc->match_approved_list($_SESSION["member"]["so_citizen_id"]);
                            } elseif (isset($_GET["act"]) && $_GET["act"] == "matchsanctionedit" && isset($_GET["mid"])) {
                                $fnc->match_form_edit_sanction($_GET["mid"]);
                            } else {
                                $fnc->match_list();
                            }
                            break;
                        case "matchinfo":
                            if (isset($_GET["mid"])) {                                
                                $fnc->match_detail($_GET["mid"]);
                            } else {
                                echo "eror: no match id variable";
                            }
                            break;
                        case "matchsanctioninfo":
                            if (isset($_GET["mid"])) {
                                $fnc->match_md_menu();
                                $fnc->match_sanction_detail($_GET["mid"]);
                            } else {
                                echo "eror: no match id variable";
                            }
                            break;
                        case "welcome":
                            if ($_SESSION["member"]["so_status"] == "forcepwd") {
                                // echo '<meta http-equiv="refresh" content="0;url=?p=profile&alert=danger&msg=โปรดเปลี่ยนรหัสผ่านใหม่ทันที">';
                                die('<meta http-equiv="refresh" content="0;url=?p=profile&alert=danger&msg=โปรดเปลี่ยนรหัสผ่านใหม่ทันที">');
                            }
                            echo '<div class="col-12 col-md-11 col-lg-8 mx-auto">';
                            echo '<h3 class="mt-3">My Info</h3>';
                            $fnc->gen_member_card($_SESSION["member"]["so_id"]);
                            echo '</div>';
                            break;
                        case "soinfo":
                            if (isset($_GET["soid"])) {
                                $fnc->so_info($_GET["soid"]);
                                echo '<div class="mt-5">';
                                $fnc->so_on_duty($_GET["soid"]);
                                echo '</div>';
                            }
                            break;
                        case "qrcode":
                            echo '<div class="col-12 col-md-10 col-lg-8 mx-auto box_shadow">';
                            $match_info = $fnc->match_info($_SESSION["member"]["setting"]["setting_match_active"]);
                            echo '</div>
                                ';

                            $fnc->gen_qrcode_page();

                            break;
                    }
                } else {
                    echo '<div class="col-12 col-md-11 col-lg-8 mx-auto mt-4">';
                    // echo '<h3 class="mt-3">My Info</h3>';
                    $fnc->gen_member_card($_SESSION["member"]["so_id"]);


                    echo '<h3 class="mt-5">แมทซ์ล่าสุด</h3>';
                    echo '<div class="colbox_shadow">';
                    $match_info = $fnc->match_info($_SESSION["member"]["setting"]["setting_match_active"]);
                    echo '</div>
                                ';

                    $fnc->gen_qrcode_page();

                    echo '</div>                    
                    ';
                }
            }

            ?>

            <?php

            // if (isset($_GET["p"]) && $_GET["p"] == "profile") {
            //     so_form_update_avatar($_SESSION["member"]["so_id"]);
            // } elseif (isset($_GET["p"]) && $_GET["p"] == "jobs") {
            //     $fnc->so_on_duty($_SESSION["member"]["so_id"]);
            // } elseif (isset($_GET["p"]) && $_GET["p"] == "match") {
            //     // match_list();
            //     $fnc->match_list();
            // } elseif (isset($_GET["p"]) && $_GET["p"] == "matchinfo" && $_GET["mid"]) {
            //     $fnc->match_detail($_GET["mid"]);
            // } else {

            //     echo '<h1 class="mt-5">My Info</h1>';

            //     $fnc->gen_member_card($_SESSION["member"]["so_id"]);

            // }
            ?>

        </div>
    </main>

    
    
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <?php
    include('../sweet_alert.php');
    ?>

<?//php require __DIR__ . '/../policy/cookies-consent.php'; ?>

</body>

</html>