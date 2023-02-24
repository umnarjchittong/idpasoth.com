<!doctype html>
<html lang="en">
<?php
include('../core.php');
$fnc = new web;
?>

<head>
  <title>SOTH Register</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

  <link rel="stylesheet" href="../css/style.css">
  <!-- Convert this to an external style sheet -->

</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">SOTH</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize">
          <!-- <li class="nav-item">
            <a class="nav-link" aria-current="page" href="../sign/">Login</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="../sign/">เข้าสู่ระบบ</a>
            <!-- <a class="nav-link" aria-current="page" href="../sign/forgot_pwd.php">ยืนยันตัวตน</a> -->
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <main class="flex-shrink-0">
    <div class="container">
      <?php


      if (isset($_GET["alert"]) && isset($_GET["p"])) {
        if ($_GET["alert"] == "info" && $_GET["p"] == "registered") {
          // * get regist data
          // send email notification
          $content_html = '<meta charset="UTF-8">
    <div style="margin:0em; padding: 2em; width:600px;">
        <img src="https://faed.mju.ac.th/soth/images/soth_banner.png" style="width:100%">
        <div style="margin-top:2em;">
            <h3>ยินดีต้อนรับท่านเป็นสมาชิกระบบ SOTH</h3>                    
            <p style="margin-top:2em;">หากท่านไม่ได้เป็นผู้ลงทะเบียน/สมัครสมาชิก โปรดตอบกลับอีเมลนี้โดยด่วน</p>
            <p>คลิกเข้าสู่ระบบ <a href="https://faed.mju.ac.th/soth/sign/" target="_blank">SOTH</a></p>
        </div>
        <div style="margin-top:5em;">
            <p>ทีมงานแอดมิน SOTH</p>
            <img src="https://faed.mju.ac.th/soth/images/soth_logo-120.png">
        </div>
    </div>';

          // $mailer = new Mailer;
          // $mailer->send_email($_POST["email"], $_POST["so_firstname_en"] . " " . $_POST["so_lastname_en"], "SOTH ลงทะเบียนใหม่", $content_html, "../guest/register.php?p=registered&alert=info&msg=ลงทะเบียนข้อมูล SO เรียบร้อย. โปรด Login เพื่อเข้าสู่ระบบ");
        }
        echo '<div class="alert alert-' . $_GET["alert"] . ' d-flex align-items-center" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-3"></i>
          <div class="container">
          ' . $_GET["msg"] . '
          <button type="button" class="btn-close text-end ms-5" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>';
      }

      $fnc->so_form_add_guest();


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

</body>

</html>