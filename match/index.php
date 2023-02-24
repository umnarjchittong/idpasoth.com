<!doctype html>
<html lang="en">
<?php
include('../core.php');
$fnc = new web;
if (isset($_GET["mid"]) && !empty($_GET["mid"])) {
    $mid = $_GET["mid"];
} else {
    $mid = $fnc->get_db_col("SELECT `setting_match_active` FROM `settings` ORDER BY `setting_id` Desc LIMIT 1");
    // if ($fnc->get_db_col("SELECT `setting_view_result` FROM `settings` ORDER BY `setting_id` Desc LIMIT 1") == 'false') {
    //     die("no match info");
    // }
}
?>

<head>
    <title>SOTH - Match Information</title>
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

<body class="d-flex flex-column h-100 bg-dark">
    
    <div class="cookie-disclaimer d-none">
        <div class="cookie-close accept-cookie"><i class="fa fa-times"></i></div>
        <div class="container">
            <p>เว็บไซต์ของคณะฯ มีการใช้งานคุ๊กกี้ (Cookies) โดยเราใช้คุกกี้เพียงเพื่อปรับปรุงการใช้งานให้เหมาะสม วิเคราะห์การเข้าใช้เว็บไซต์ และเพิ่มประสบการร์ใช้งานของท่าน
                <br>ถ้าท่านยังใช้งานต่อไปโดยไม่ปฏิเสธคุกกี้ คณะฯ จะเก็บคุกกี้เพื่อวัตถุประสงค์ข้างต้น ทั้งนี้ ท่านสามารถศึกษารายละเอียดที่เกี่ยวกับการใช้คุกกี้ของคณะฯ ได้ที่นี่ <a href="https://arch.mju.ac.th/policy/cookies/">นโยบายการใช้คุ๊กกี้</a>
            </p>
            <button type="button" class="btn btn-success accept-cookie d-none">ยอมรับการใช้งานคุ๊กกี้</button>
        </div>
    </div>

    

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-secondary bg-gradient">
        <div class="container-fluid">
            <p class="navbar-brand text-white m-0 p-0" href="#">Safety Officer Thailand</p>
        </div>
    </nav>


    <main class="flex-shrink-0 mh-100">
        <div class="bg-dark text-secondary px-4 py-5 text-start h-100">

            <div class="col-12 col-md-9 col-lg-8 mx-auto">
                <?php $fnc->match_info($mid); ?>
            </div>
            <!-- <div class="col-12 col-md-9 col-lg-8 mx-auto mt-5">
                <p class="h4 fw-bold text-white">รายชื่อ SO</p>
                <?//php $fnc->so_on_duty_table($mid); ?>
            </div> -->

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

<!-- * cookies concent -->
<script>
        $(document).ready(function() {
            var cookie = false;
            var cookieContent = $('.cookie-disclaimer');

            checkCookie();

            if (cookie === true) {
                cookieContent.hide();
            }

            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toGMTString();
                document.cookie = cname + "=" + cvalue + "; " + expires;
            }

            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i].trim();
                    if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
                }
                return "";
            }

            function checkCookie() {
                var check = getCookie("acookie");
                if (check !== "") {
                    return cookie = true;
                } else {
                    return cookie = false; //setCookie("acookie", "accepted", 365);
                }

            }
            $('.accept-cookie').click(function() {
                setCookie("acookie", "accepted", 365);
                cookieContent.hide(500);
            });
        });
    </script>

</html>