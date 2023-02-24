<!doctype html>
<?php
include("../core.php");
$fnc = new web;

if (isset($_GET["mid"]) && $_GET["mid"] != "") {
    $mid = $_GET["mid"];
} else {
    $mid = $fnc->get_db_col("SELECT `setting_match_active` FROM `settings` ORDER BY `setting_id` Desc LIMIT 1");
}
// $view_result = $fnc->get_db_array("SELECT `setting_view_result`, `setting_match_result` FROM `settings` ORDER BY `setting_id` Desc LIMIT 1")[0];
$view_result = $fnc->get_db_row("SELECT match_id, match_active, shooter_result, match_result, match_active as setting_match_active, shooter_result as setting_view_result, match_result as setting_match_result FROM `match_setting` WHERE match_id = $mid");

if (isset($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] >= 9) {
    // $fnc->debug_console("member info", $_SESSION["member"]);
    $fnc->debug_console("match id: " . $mid);
    $fnc->debug_console("view result: ", $view_result);
}

function read_csv_file($f_name)
{
    $csv = array();
    $lines = file($f_name, FILE_IGNORE_NEW_LINES);
    $x = 0;
    foreach ($lines as $key => $value) {
        $csv[$key] = str_getcsv($value);
        $x++;
    }
    $x--;

    echo "read .csv file total " . $x . " records";
    echo '<pre>';
    print_r($csv);
    echo '</pre>';
    // die();
    return $csv;
}

?>
<html lang="en">

<head>
    <title>SOTH - Shooter Score</title>
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
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-danger bg-gradient">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="../shooter/">SOTH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize">
                    <li class="nav-item">
                        <a class="nav-link active" href="../shooter/">My Score</a>
                    </li>
                    <?php if ($view_result["match_result"] == 'true') { ?>
                        <li class="nav-item">
                            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "overall") {
                                                    echo ' active"';
                                                } ?>" href="../match/result/?v=overall">Overall</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "divisionclass") {
                                                    echo ' active"';
                                                } ?>" href="../match/result/?v=divisionclass">Division/Class</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle<?php if (isset($_GET["v"]) && $_GET["v"] == "category") {
                                                                    echo ' active"';
                                                                } ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Category Leaders</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "overall") {
                                                                echo ' active"';
                                                            } ?>" href="../match/result/?v=category&p=overall">Overall</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <?php
                                $sql = "Select shooter_division From score_shooter Where match_id = " . $mid . " Group By match_id, shooter_division Order By shooter_division";
                                $division = $fnc->get_db_array($sql);
                                foreach ($division as $div) {
                                    echo '<li><a class="dropdown-item';
                                    if (isset($_GET["p"]) && $_GET["p"] == $div["shooter_division"]) {
                                        echo ' active"';
                                    }
                                    echo '" href="../match/result/?v=category&p=' . $div["shooter_division"] . '">' . $div["shooter_division"] . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle<?php if (isset($_GET["v"]) && $_GET["v"] == "stage") {
                                                                    echo ' active"';
                                                                } ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Stage Leaders</a>
                            <ul class="dropdown-menu">
                                <?php
                                $sql = "Select Cast(scst.score_stage_number As Int) As score_stage_number From score_stage scst Where scst.match_id = " . $mid . " Group By Cast(scst.score_stage_number As Int) Order By score_stage_number";
                                $division = $fnc->get_db_array($sql);
                                foreach ($division as $div) {
                                    echo '<li><a class="dropdown-item';
                                    if (isset($_GET["p"]) && $_GET["p"] == $div["score_stage_number"]) {
                                        echo ' active"';
                                    }
                                    echo '" href="?v=stage&p=' . $div["score_stage_number"] . '">Stage #' . $div["score_stage_number"] . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- submenu  -->
    <ul class="nav justify-content-between mt-5 pt-3 d-md-none d-sm-block" style="font-size: 0.7em">
        <?php if ($view_result["match_result"] == 'true') { ?>
            <li class="">
                <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "overall") {
                                        echo ' active"';
                                    } ?> link-warning" href="../match/result/?v=overall">Overall</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "divisionclass") {
                                        echo ' active"';
                                    } ?> link-warning" href="../match/result/?v=divisionclass">Division/Class</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle<?php if (isset($_GET["v"]) && $_GET["v"] == "category") {
                                                        echo ' active"';
                                                    } ?> link-warning" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Category Leaders</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "overall") {
                                                    echo ' active"';
                                                } ?>" href="../match/result/?v=category&p=overall">Overall</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php
                    $sql = "Select shooter_division From score_shooter Where match_id = " . $mid . " Group By match_id, shooter_division Order By shooter_division";
                    $division = $fnc->get_db_array($sql);
                    foreach ($division as $div) {
                        echo '<li><a class="dropdown-item';
                        if (isset($_GET["p"]) && $_GET["p"] == $div["shooter_division"]) {
                            echo ' active"';
                        }
                        echo '" href="../match/result/?v=category&p=' . $div["shooter_division"] . '">' . $div["shooter_division"] . '</a></li>';
                    }
                    ?>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle<?php if (isset($_GET["v"]) && $_GET["v"] == "stage") {
                                                        echo ' active"';
                                                    } ?> link-warning" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Stage Leaders</a>
                <ul class="dropdown-menu">
                    <?php
                    $sql = "Select Cast(scst.score_stage_number As Int) As score_stage_number From score_stage scst Where scst.match_id = " . $mid . " Group By Cast(scst.score_stage_number As Int) Order By score_stage_number";
                    $division = $fnc->get_db_array($sql);
                    foreach ($division as $div) {
                        echo '<li><a class="dropdown-item';
                        if (isset($_GET["p"]) && $_GET["p"] == $div["score_stage_number"]) {
                            echo ' active"';
                        }
                        echo '" href="?v=stage&p=' . $div["score_stage_number"] . '">Stage #' . $div["score_stage_number"] . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
        <?php } ?>
    </ul>

    <!-- Begin page content -->
    <main class="flex-shrink-0 mh-100" style="min-width: 100vw; width: 100vw">

        <?php
        // if (isset($_GET["uid"]) && isset($_GET["act"]) && $_GET["act"] == "shooterview") {        
        if ($view_result["shooter_result"] == 'true' || $_GET["admin"] >= 5) { ?>
            <?php
            // $match_icon = $_SERVER['DOCUMENT_ROOT'] . 'img/match_banner/match_' . $mid . '.jpg';
            $match_icon = '../img/match_banner/match_' . $mid . '.jpg';
            $fnc->debug_console("m icon" . file_exists($match_icon) . ' : ' . $match_icon);
            if (!file_exists($match_icon)) {
                $match_icon = '../../img/match_banner/match_' . $mid . '.jpg';
                if (!file_exists($match_icon)) {
                    $match_icon = '/images/soth_logo.png';
                }
            }
            $fnc->debug_console("m logo" . $match_icon);
            ?>
            <div class="bg-dark text-secondary px-2 px-md-4 py-5 mx-auto text-start h-100" style="max-width: 700px; min-width: 300px">
                <?php if (isset($_GET["uid"]) && isset($_GET["act"]) && $_GET["act"] == "shooterview") {
                    $sql = "Select * From score_shooter Where score_shooter.match_id = " . $mid . " And score_shooter.shooter_number = '" . $_GET["uid"] . "'";
                    $shooter = $fnc->get_db_row($sql);
                    $fnc->debug_console("shooter view sql: " . $sql);
                    if (!$shooter) {
                        // die('nofount');
                        die('<meta http-equiv="refresh" content="0;url=?uid=' . $_GET["uid"] . '&p=shooterresult&act=notfound">');
                        // die();
                    }
                    // $fnc->debug_console("sql = " . $sql);
                    $sql = "Select * From `match_idpa` Where `match_idpa`.match_id = " . $mid;
                    $match = $fnc->get_db_row($sql);
                    // $sql = "Select * From score_shooter Where score_shooter.match_id = " . $mid . " And Left(score_shooter.shooter_lastName, 3) = '" . $_GET["uid"] . "'";
                    $sql = "Select * From score_stage Where score_stage.match_id = " . $mid . " And score_stage.score_shooter_id = " . $shooter["shooter_id"] . " Group by score_stage.score_stage_number Order By Cast(score_stage.score_stage_number As Int)";
                    $stage = $fnc->get_db_array($sql);
                    $fnc->debug_console("score stage sql: " . $sql);
                    // $fnc->debug_console("stage time data: " , $stage);
                ?>
                    <div class="mb-3" style="margin-top: 4em;">
                        <div class="row g-2 d-flex">
                            <div class="col-auto"><img src="<?= $match_icon ?>" class="img-fluid rounded" style="width: 100%; max-width: 100px; min-width: 60px; margin-right: 1em;"></div>
                            <div class="col">
                                <p class="h4 fw-bold text-white mb-1"><?= $match["match_name"] ?></p>
                                <p class="h6 text-muted"><?= $match["match_location"] ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-start d-none" style="margin-top: 2em;">
                        <img src="../images/soth_logo.png" style="max-width: 100px; min-width: 60px; margin-right: 1em;">
                        <div class="col">
                            <p class="h4 fw-bold text-white mb-1"><?= $match["match_name"] ?></p>
                            <p class="h6 text-muted"><?= $match["match_location"] ?></p>
                        </div>
                        <img src="../images/soth_logo.png" style="max-width: 150px; min-width: 100px">
                    </div>

                    <div class="mb-3">
                        <div class=""><span class="text-warning fw-bold h2 me-3"><?= "#" . $shooter["shooter_number"] ?></span><span class="text-capitalize h3 text-light"><?= $shooter["shooter_firstName"] . '&nbsp;&nbsp;' . $shooter["shooter_lastName"] ?></span><span class="text-uppercase ms-3 fs-5"><?= $shooter["shooter_idpa"] ?></span></div>
                        <div class=""><span class="text-light h5 me-3 text-uppercase"><?= $shooter["shooter_division"] . ' / ' .  $shooter["shooter_class"] ?></span><span class="text-light h5 me-3 text-uppercase"><?= 'SQ#' . '<span class="text-warning">' . $shooter["shooter_squad"] . '</span>' ?></span><span class="text-capitalize h6 text-light"><?= ($shooter["shooter_categories"]) ?></span></div>
                        <hr style="margin-top: 0.5em;">
                    </div>
                    <div class="mb-3 d-flex justify-content-between d-none" style="margin-top: 2em;">
                        <img src="../images/soth_logo.png" style="max-width: 350px; min-width: 150px">
                        <img src="../images/soth_logo.png" style="max-width: 350px; min-width: 150px">
                    </div>
                    <div class="mt-4 mb-3 col-12">
                        <table class="table table-bordered table-hover table-striped table-responsive">
                            <thead>
                                <tr class="table-dark text-center" style="font-size: 1.0em;">
                                    <th>Stage</th>
                                    <th>Final</th>
                                    <th>PD</th>
                                    <th>PE</th>
                                    <th>HNT</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stage as $stg) { ?>
                                    <tr class="table-dark text-center" style="font-size: 0.85em;">
                                        <td scope="row"><?= '#' . $stg["score_stage_number"] ?></td>
                                        <td><?= $stg["score_stage_time"] ?></td>
                                        <td><?= $stg["score_stage_PD"] ?></td>
                                        <td><?= $stg["score_stage_PE"] ?></td>
                                        <td><?= $stg["score_stage_HNT"] ?></td>
                                        <td><?= $stg["score_stage_string_1"] ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="table-light text-center fw-bold" style="font-size: 1em;">
                                    <td scope="row">Total</td>
                                    <td><?= $shooter["shooter_total_score"] ?></td>
                                    <td><?= $shooter["shooter_PD"] ?></td>
                                    <td><?= $shooter["shooter_PE"] ?></td>
                                    <td><?= $shooter["shooter_HNT"] ?></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                <?php } else {
                    $sql = "Select match_name From `match_idpa` Where `match_idpa`.match_id = " . $mid;
                    $match = $fnc->get_db_row($sql);
                    $match_icon = '../img/match_banner/match_banner_' . $mid . '.jpg';
                    $fnc->debug_console("m icon" . file_exists($match_icon) . ' : ' . $match_icon);
                    if (!file_exists($match_icon)) {
                        $match_icon = '../../img/match_banner/match_banner_' . $mid . '.jpg';
                        if (!file_exists($match_icon)) {
                            $match_icon = '../images/soth_banner.png';
                        }
                    }
                ?>
                    <div class="py-3 mt-4 col-12 col-md-10 mx-auto h-100" style="max-width: 500px;">
                        <img src="<?= $match_icon ?>" class="img-fluid box_shadow w-100">
                        <div class="bg-danger py-3 rounded-bottom shadow text-center h5 text-white"><?= $match["match_name"] ?></div>
                        <h3 class="fw-bold text-white mt-4">ระบุลำดับนักกีฬา</h3>

                        <form action="?" method="get">
                            <div class="input-group mb-3 my-4 w-100">
                                <input type="text" name="uid" class="form-control form-control-lg text-center" placeholder="*ตัวเลข 3 หลัก" maxlength="3" required>
                                <button class="btn btn-outline-danger btn-lg px-4 fw-bold" type="submit">ดูผลการแข่งขัน</button>
                                <input type="hidden" name="p" value="shooterresult">
                                <input type="hidden" name="act" value="shooterview">
                            </div>
                            <?php
                            if (isset($_GET["uid"]) && isset($_GET["act"]) && $_GET["act"] == "notfound") {
                                echo '<div class="text-center text-danger h4">ไม่พบข้อมูลนักกีฬา ลำดับที่ : <strong>' . $_GET["uid"] . '</strong></div>';
                            }
                            ?>

                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" style="margin-top: 6em;">
                                <a href="../match/shooters/" target="_blank" class="btn btn-outline-light btn-lg px-4">ดูลำดับและรายชื่อนักกีฬา</a>
                            </div>
                        </form>
                    </div>
                <?php } ?>

            </div>


        <?php } else { ?>
            <div class="bg-dark text-secondary px-4 py-5 text-start h-100 text-center pt-5 mt-5" style="padding: 150px 0px;">
                <div style="margin-top: 1em;"><img src="../images/soth_banner.png" class="img-fluid box_shadow"></div>
                <div class="text-light text-uppercase txt-center align-self-center h3 mt-4">ระบบยังไม่เปิดให้ดูผลคะแนน</div>
            </div>
            <?php if (!isset($_GET['p']) || $_GET['p'] == "") { ?>
                <footer class="text-center my-5">
                    <a href="../sign/" target="_top" class="btn btn-outline-warning px-4">เข้าสู่ระบบสำหรับ SO</a>
                </footer>
            <?php } ?>
        <?php } ?>
        <?php // } 
        ?>

        <footer class="footer mt-auto py-3 bg-danger bg-gradient text-secondary px-1 px-md-4 text-center" style="position: relative; margin-top: -56px; height: 56px; clear: both; background-color: white; min-width: 100vw; width: 100vw">
            <div class="container">
                <span class="text-light h6 fw-bold" style="font-size:0.9em; letter-spacing: 0.2em">IDPA Online Scoring Presented By SOTH</span>
            </div>
        </footer>

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