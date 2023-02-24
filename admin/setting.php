<!doctype html>
<html lang="en">
<?php
include('../core.php');
if (empty($_SESSION["member"])) {
  die('<meta http-equiv="refresh" content="0;url=../sign/signout.php?p=no-right">');
//   die();
} else {
  $fnc = new web;
  if ($_SESSION["member"]["auth_lv"] >= 9) {
    // $fnc->system_debug = $_SESSION["member"]["setting"]["setting_debug_show"];
    // $fnc->system_alert = $_SESSION["member"]["setting"]["setting_alert"];
    // $fnc->system_meta_redirect = $_SESSION["member"]["setting"]["setting_meta_redirect"];
    // $fnc->database_sample = $_SESSION["member"]["setting"]["setting_db_name"];
  }
  $fnc->debug_console("member info", $_SESSION["member"]);
}

if (isset($_GET["p"]) && $_GET["p"] == "email") {
  $mailer = new Mailer;
  $mailer->send_email("umnarjchittong@gmail.com", "umnarj");
}





?>

<head>
  <title>SOTH - Admin Setting</title>
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
                <?php } ?>
                <?php if ($_SESSION["member"]["auth_lv"] >= 6 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                  <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- STAT -</a></li>
                  <li><a class="dropdown-item" href="../score/" target="_blank">ผลการแข่ง</a></li>
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
                  <li><a class="dropdown-item" href="../admin/setting.php">การตั้งค่า</a></li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>          
          <li class="nav-item">
            <a class="nav-link" href="../member/?p=jobs">Jobs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../member/?p=match">Match</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../member/?p=profile">โปรไฟล์</a>
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

      ?>
      <h2 class="mt-5">Email Testing</h2>
      <a href="?p=email" target="_top">Test email to <?= $_SESSION["member"]["so_email"] ?></a>
      <hr class="mb-4">
      <?php
      ?>

      <h4 class="text-dark text-uppercase mt-4"><strong>System Settings</strong></h4>
      <!-- <div class="container mt-4"> -->
      <?php $fnc->setting_form_update(); ?>

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