<!doctype html>
<html lang="en">
<?php
include('../core.php');
$fnc = new web;
if ((!$_SESSION["member"])) {
    die('<meta http-equiv="refresh" content="0;url=../sign/signout.php?p=no-right">');
    //   die();
} else {
    // if ($_SESSION["member"]["auth_lv"] >= 9) {
    //   $fnc->system_debug = $_SESSION["member"]["setting"]["setting_debug_show"];
    //   $fnc->system_alert = $_SESSION["member"]["setting"]["setting_alert"];
    //   $fnc->system_meta_redirect = $_SESSION["member"]["setting"]["setting_meta_redirect"];
    //   // $fnc->database_sample = $_SESSION["member"]["setting"]["setting_db_name"];
    // }
    $fnc->debug_console("member info", $_SESSION["member"]);
    if ($_SESSION["member"]["auth_lv"] < 5) {
        die('<meta http-equiv="refresh" content="0;url=../member/?' . $fnc->get_url_parameter() . '">');
    }
}


?>

<head>
    <title>SOTH - Admin Home</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link href="../images/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
    <!-- Convert this to an external style sheet -->

</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../admin/">SOTH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../member/">หน้าแรก</a>
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
                                    <li><a class="dropdown-item" href="../admin/shooter.php?p=shooter" target="shooter">ประวัติ นกฬ.</a></li>
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
                                    <li><a class="dropdown-item" href="../admin/?p=member">จัดการสมาชิก</a></li>
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
                                    <li><a class="dropdown-item" href="../admin/setting.php">การตั้งค่า</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../member/?p=jobs">การทำหน้าที่ SO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../member/?p=match">แมทซ์ทั้งหมด</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../member/?p=profile">โปรไฟล์ของฉัน</a>
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
        <div class="container col-md-10">
            <?php

            if (isset($_GET["p"]) && $_GET["p"] != "") {
                switch ($_GET["p"]) {
                    case "cso":
                        $fnc->so_admin_menu();
                        $fnc->so_list("CSO");
                        break;
                    case "so":
                        if (isset($_GET["act"]) && $_GET["act"] == "soedit" && isset($_GET["soid"])) {
                            $fnc->so_form_update_admin($_GET["soid"]);
                        } elseif (isset($_GET["act"]) && $_GET["act"] == "soadd") {
                            $fnc->so_form_add();
                        } else {
                            $fnc->so_admin_menu();
                            $fnc->so_list("SO");
                        }
                        break;
                    case "member":
                        $fnc->so_admin_menu();
                        $fnc->so_list();
                        break;
                    case "soinfo":
                        if (isset($_GET["soid"])) {
                            if ($_SESSION["member"]["auth_lv"] >= 8) {
                                $fnc->so_admin_menu();
                            }
                            $fnc->so_info($_GET["soid"]);
                            echo '<div class="mt-5">';
                            $fnc->so_on_duty($_GET["soid"]);
                            echo '</div>';
                        }
                        break;
                    case "shooter":
                        if ((isset($_GET["fname"]) && isset($_GET["lname"])) || isset($_GET["shooterId"])) {
                            $fnc->shooter_info();
                        } else {
                            $fnc->so_admin_menu();
                            $fnc->shooter_list();
                        }
                        break;
                    case "sanction":
                        $fnc->match_sanction_list();
                        break;
                    case "match":
                        if (isset($_GET["act"]) && $_GET["act"] == "matchedit" && isset($_GET["mid"])) {
                            $fnc->match_form_edit($_GET["mid"]);
                        } elseif (isset($_GET["act"]) && $_GET["act"] == "matchadd") {
                            $fnc->match_form_add();
                        } elseif (isset($_GET["act"]) && $_GET["act"] == "attachment") {
                            if ($_SESSION["member"]["auth_lv"] >= 9) {
                                $fnc->match_admin_menu();
                            }
                            $fnc->match_info($_GET["mid"]);
                            $fnc->match_form_attachment($_GET["mid"]);
                        } else {
                            if ($_SESSION["member"]["auth_lv"] >= 9) {
                                $fnc->match_admin_menu();
                            }
                            $fnc->match_list();
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
                    case "matchinfo":
                        if (isset($_GET["mid"])) {
                            if ($_SESSION["member"]["auth_lv"] >= 9) {
                                $fnc->match_admin_menu();
                            }
                            $fnc->match_detail($_GET["mid"]);
                        }
                        break;
                    case "duty":
                        if (isset($_GET["mid"])) {
                            if (isset($_GET["act"]) && $_GET["act"] == "dutyedit" && isset($_GET["odid"])) {
                                // duty_form_edit($_GET["mid"], $_GET["odid"]);
                                $fnc->duty_form_edit($_GET["mid"], $_GET["odid"]);
                            } else {
                                // duty_form_set($_GET["mid"]);
                                $fnc->duty_form_set($_GET["mid"]);
                            }
                        }
                        break;
                }
            } else {
                echo '<div class="col-8 mt-5"><img src="../images/soth_banner.png" class="img-fluid"></div>';
                echo '<h3 class="mt-3">ยินดีต้อนรับ ' . $_SESSION["member"]["so_firstname"] . ' ' . $_SESSION["member"]["so_lastname"] . ' เข้าสู่ระบบ SOTH V' . $_SESSION["member"]["setting"]["setting_version"] . '</h3>';
            }


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

</body>

</html>