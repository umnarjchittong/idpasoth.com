<!doctype html>
<html lang="en">
<?php
include('../../core.php');
$fnc = new web;

$mid = $fnc->get_db_col("SELECT `setting_match_active` FROM `settings` ORDER BY `setting_id` Desc LIMIT 1");
$view_result = $fnc->get_db_array("SELECT `setting_view_result`, `setting_match_result` FROM `settings` ORDER BY `setting_id` Desc LIMIT 1")[0];

if (isset($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] >= 9) {
    // $fnc->debug_console("member info", $_SESSION["member"]);
    $fnc->debug_console("match id: " . $mid);
    $fnc->debug_console("view result: ", $view_result);
}


function gen_result_table($mid, $sql)
{
    global $fnc;
?>
    <table class="table table-striped table-bordered table-hover table-responsive table-light">
        <thead class="thead-inverse">
            <tr class="table-secondary text-center">
                <th style="width:4em;">Place</th>
                <th class="text-start">Shooter Name</th>
                <?php if (isset($_GET["v"]) && $_GET["v"] != "divisionclass") {
                    if (isset($_GET["v"]) && $_GET["v"] != "division") { ?>
                        <th style="width:6em;">Division</th>
                    <?php } ?>
                    <?php if (isset($_GET["v"]) && $_GET["v"] != "stage") { ?>
                        <th style="width:5em;">Class</th>
                    <?php } ?>
                <?php } ?>
                <?php if (isset($_GET["v"]) && $_GET["v"] != "stage") { ?>
                    <th style="width:4em;">SQT</th>
                <?php } ?>
                <?php if (isset($_GET["v"]) && $_GET["v"] != "category" && $_GET["v"] != "stage") { ?>
                    <th style="width:10em;">Categories</th>
                <?php } ?>
                <?php if (isset($_GET["v"]) && $_GET["v"] == "stage") { ?>
                    <th style="width:5.5em;">Total</th>
                    <th style="width:5.5em;">Time</th>
                    <th style="width:4em;">PD</th>
                    <th style="width:4em;">HNT</th>
                    <!-- <th style="width:4em;">PE</th>
                    <th style="width:4em;">FTDR</th>
                    <th style="width:4em;">FP</th> -->
                <?php } else { ?>
                    <th style="width:5.5em;">Time</th>
                    <th style="width:4em;">PD</th>
                    <th style="width:4em;">HNT</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // echo $sql;
            $data_array = $fnc->get_db_array($sql);
            if (($data_array)) {
                $x_row = 1;
                foreach ($data_array as $row) {
                    if ($row["shooter_total_score"] > 0) {
                        echo '<tr class="">';
                        echo '<td scope="row" class="text-center">' . $x_row . '</td>';
                        echo '<td class="text-start">' . $row["shooter_firstName"] .  '&nbsp;&nbsp;&nbsp;' . $row["shooter_lastName"];
                        if (!empty($row["shooter_idpa"])) {
                            echo ', ' . strtoupper($row["shooter_idpa"]) . '';
                        }
                        echo '</td>';
                        if (isset($_GET["v"]) && $_GET["v"] != "divisionclass") {
                            if (isset($_GET["v"]) && $_GET["v"] != "division") {
                                echo '<td class="text-center">' . $row["shooter_division"] . '</td>';
                            }
                            if (isset($_GET["v"]) && $_GET["v"] != "stage") {
                                echo '<td class="text-center">' . $row["shooter_class"] . '</td>';
                            }
                        }
                        if (isset($_GET["v"]) && $_GET["v"] != "stage") {
                            echo '<td class="text-center">' . $row["shooter_squad"] . '</td>';
                        }
                        if (isset($_GET["v"]) && $_GET["v"] != "category" && $_GET["v"] != "stage") {
                            echo '<td class="text-center">' . $fnc->gen_categories_shorty($row["shooter_categories"]) . '</td>';
                        }
                        if (isset($_GET["v"]) && $_GET["v"] == "stage") {
                            echo '<td class="text-center">' . $row["score_stage_time"] . '</td>';
                            echo '<td class="text-center">' . $row["score_stage_string_1"] . '</td>';
                            echo '<td class="text-center">' . $row["score_stage_PD"] . '</td>';
                            echo '<td class="text-center">' . $row["score_stage_HNT"] . '</td>';
                            // echo '<td class="text-center">' . $row["score_stage_PE"] . '</td>';
                            // echo '<td class="text-center">' . $row["score_stage_FTDR"] . '</td>';
                            // echo '<td class="text-center">' . $row["score_stage_FP"] . '</td>';
                        } else {
                            echo '<td class="text-center">' . $row["shooter_total_score"] . '</td>';
                            echo '<td class="text-center">' . $row["shooter_PD"] . '</td>';
                            echo '<td class="text-center">' . $row["shooter_HNT"] . '</td>';
                        }
                        echo '</tr>';
                        $x_row++;
                    }
                }
            } else {
                // echo '<tr class="">';
                // echo '<td scope="row" class="text-center" colspan="8">Data Not Founded.</td>';
                // echo '</tr>';
            }
            ?>
        </tbody>
    </table>
<?php
}

function view_result_list($mid)
{
    global $fnc;
    $sql_order = "";

    // print_r($data_array);
?>
    <ul class="nav nav-pills justify-content-end mt-4">
        <li class="nav-item">
            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "overall") {
                                    echo ' active';
                                } ?>" aria-current="page" href="?p=<?= $_GET["p"] ?>&mid=<?= $mid ?>&v=overall">Overall</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "stages") {
                                    echo ' active';
                                } ?>" href="?p=<?= $_GET["p"] ?>&mid=<?= $mid ?>&v=stages">Stages Overall</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "division") {
                                    echo ' active';
                                } ?>" href="?p=<?= $_GET["p"] ?>&mid=<?= $mid ?>&v=division">Division</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "divisionclass") {
                                    echo ' active';
                                } ?>" href="?p=<?= $_GET["p"] ?>&mid=<?= $mid ?>&v=divisionclass">Division/Class</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "categories") {
                                    echo ' active';
                                } ?>" href="?p=<?= $_GET["p"] ?>&mid=<?= $mid ?>&v=categories">Categories</a>
        </li>
    </ul>

<?php
    if (isset($_GET["v"])) {
        switch ($_GET["v"]) {
            case "overall":
                $sql = "SELECT * FROM `score_shooter` WHERE `match_id` = " . $mid;
                if (isset($sql_order)) {
                    $sql .= $sql_order;
                }
                echo '<div class="h2 mt-4">' . 'Over All' . '</div>';
                gen_result_table($mid, $sql);
                break;
            case "categories":
                $sql = "Select scsh.shooter_categories From score_shooter scsh Where scsh.shooter_categories <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_categories Order By scsh.shooter_categories";
                $categories = $fnc->get_db_array($sql);
                foreach ($categories as $cate) {
                    echo '<div class="h2 mt-4">' . $cate["shooter_categories"] . '</div>';

                    $sql = "SELECT * FROM `score_shooter` WHERE `shooter_categories` = '" . $cate["shooter_categories"] . "' AND `match_id` = " . $mid;
                    if (isset($sql_order)) {
                        $sql .= $sql_order;
                    }
                    gen_result_table($mid, $sql);
                }
                break;
            case "division":
                $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division Order By scsh.shooter_division";
                $categories = $fnc->get_db_array($sql);
                foreach ($categories as $cate) {
                    echo '<div class="h2 mt-4">' . $cate["shooter_division"] . '</div>';

                    $sql = "SELECT * FROM `score_shooter` WHERE `shooter_division` = '" . $cate["shooter_division"] . "' AND `match_id` = " . $mid;
                    if (isset($sql_order)) {
                        $sql .= $sql_order;
                    }
                    gen_result_table($mid, $sql);
                }
                break;
            case "class":
                $sql = "Select scsh.shooter_class From score_shooter scsh Where scsh.shooter_class <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_class Order By scsh.shooter_class";
                $categories = $fnc->get_db_array($sql);
                foreach ($categories as $cate) {
                    echo '<div class="h2 mt-4">' . $cate["shooter_class"] . '</div>';

                    $sql = "SELECT * FROM `score_shooter` WHERE `shooter_class` = '" . $cate["shooter_class"] . "' AND `match_id` = " . $mid;
                    if (isset($sql_order)) {
                        $sql .= $sql_order;
                    }
                    gen_result_table($mid, $sql);
                }
                break;
            case "stages":
                $sql = "Select Cast(scst.score_stage_number As Int) From score_stage scst Where scst.match_id = " . $mid . " Group By Cast(scst.score_stage_number As Int)";
                $categories = $fnc->get_db_array($sql);
                foreach ($categories as $cate) {
                    echo '<div class="h2 mt-4">' . $cate["score_stage_number"] . '</div>';

                    $sql = "SELECT * FROM `score_shooter` WHERE `score_stage_number` = '" . $cate["score_stage_number"] . "' AND `match_id` = " . $mid;
                    if (isset($sql_order)) {
                        $sql .= $sql_order;
                    }
                    gen_result_table($mid, $sql);
                }
                break;
            case "divisionclass":
                // $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division Order By scsh.shooter_division";
                $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division ORDER BY CASE WHEN shooter_division = 'SSP' THEN 1 WHEN shooter_division = 'ESP' THEN 2 WHEN shooter_division = 'CDP' THEN 3 WHEN shooter_division = 'CCP' THEN 4 WHEN shooter_division = 'BUG' THEN 5 WHEN shooter_division = 'REV' THEN 6 WHEN shooter_division = 'CO' THEN 7 WHEN shooter_division = 'PCC30' THEN 8 WHEN shooter_division = 'PCC-30' THEN 9 WHEN shooter_division = 'PCC-SMG' THEN 10 WHEN shooter_division = 'PCC10' THEN 11 WHEN shooter_division = 'PCC-10' THEN 12 WHEN shooter_division = 'PCC-RIFLE' THEN 13 WHEN shooter_division = 'SPD' THEN 14 ELSE 15 END ASC";
                $division = $fnc->get_db_array($sql);
                foreach ($division as $div) {
                    // $sql = "Select scsh.shooter_class From score_shooter scsh Where scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.match_id = " . $mid . " Group By scsh.shooter_class";
                    $sql = "Select scsh.shooter_class From score_shooter scsh Where scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.match_id = " . $mid . " Group By scsh.shooter_class ORDER BY CASE WHEN shooter_class = 'MA' THEN 2 WHEN shooter_class = 'EX' THEN 3 WHEN shooter_class = 'SS' THEN 4 WHEN shooter_class = 'MM' THEN 5 WHEN shooter_class = 'NV' THEN 6 WHEN shooter_class = 'UN' THEN 7 WHEN shooter_class = 'ALL' THEN 8 ELSE 10 END ASC";
                    $class = $fnc->get_db_array($sql);
                    foreach ($class as $cls) {
                        echo '<div class="h2 mt-4">' . $div["shooter_division"] . " / " . $cls["shooter_class"] . '</div>';

                        $sql = "Select * From score_shooter scsh Where scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.shooter_class = '" . $cls["shooter_class"] . "' And scsh.match_id = " . $mid;
                        if (isset($sql_order)) {
                            $sql .= $sql_order;
                        }
                        gen_result_table($mid, $sql);
                    }
                }
                break;
        }
    }
}

function shooter_info($mid, $uid)
{
    global $fnc;

    $sql = "SELECT * FROM `score_shooter` WHERE `shooter_id` = " . $uid . " AND match_id = " . $mid;
    // echo "user" . $sql;
    $shooter = $fnc->get_db_row($sql);
    echo '<div class="mt-5">' . $shooter["shooter_lastName"] .  '&nbsp;&nbsp;&nbsp;&nbsp;' . $shooter["shooter_firstName"] . '</div>';
}


?>

<head>
    <title>SOTH - Match Results</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link href="../../images/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="../../css/style.css">
    <!-- Convert this to an external style sheet -->
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #FFF;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            color: #FFF;
        }
    </style>

</head>

<body class="d-flex flex-column h-100">

    <nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-danger bg-gradient">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="../shooter/">Safety Officer Thailand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize">
                    <li class="nav-item">
                        <a class="nav-link" href="../../shooter/">My Score</a>
                    </li>
                    <?php if ($view_result["setting_match_result"] == 'true') { ?>
                        <li class="nav-item">
                            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "overall") {
                                                    echo ' active"';
                                                } ?>" href="?v=overall">Overall</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "divisionclass") {
                                                    echo ' active"';
                                                } ?>" href="?v=divisionclass">Division/Class</a>
                        </li>
                        <li class="nav-item d-none">
                            <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "category") {
                                                    echo ' active"';
                                                } ?>" href="?v=category&p=overall">Category Leaders</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle<?php if (isset($_GET["v"]) && $_GET["v"] == "category") {
                                                                    echo ' active"';
                                                                } ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Category Leaders</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "overall") {
                                                                echo ' active"';
                                                            } ?>" href="?v=category&p=overall">Overall</a></li>
                                <!-- <li>
                                    <hr class="dropdown-divider">
                                </li> -->
                                <?php
                                // $sql = "Select shooter_division From score_shooter Where match_id = " . $mid . " Group By match_id, shooter_division Order By shooter_division";
                                // $division = $fnc->get_db_array($sql);
                                // foreach ($division as $div) {
                                //     echo '<li><a class="dropdown-item';
                                //     if (isset($_GET["p"]) && $_GET["p"] == $div["shooter_division"]) {
                                //         echo ' active"';
                                //     }
                                //     echo '" href="?v=category&p=' . $div["shooter_division"] . '">' . $div["shooter_division"] . '</a></li>';
                                // }
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
    </nav>eg4

    <!-- submenu  -->
    <ul class="nav justify-content-between mt-5 d-block d-md-none d-sm-block" style="font-size: 0.7em">
        <li class="nav-item">
            <a class="nav-link link-primary" href="../../shooter/">My Score</a>
        </li>
        <?php if ($view_result["setting_match_result"] == 'true') { ?>
            <li class="">
                <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "overall") {
                                        echo ' active"';
                                    } ?> link-primary" href="../match/result/?v=overall">Overall</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "divisionclass") {
                                        echo ' active"';
                                    } ?> link-primary" href="../match/result/?v=divisionclass">Division/Class</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle<?php if (isset($_GET["v"]) && $_GET["v"] == "category") {
                                                        echo ' active"';
                                                    } ?> link-primary" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Category Leaders</a>
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
                                                    } ?> link-primary" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Stage Leaders</a>
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

    <main class="flex-shrink-0">
        <div class="container">

            <div class="col-12 col-md-11 col-lg-10 mx-auto mt-3">
                <?php
                if (isset($_GET["v"])) {
                    switch ($_GET["v"]) {
                            // case "overall":
                            //     $sql = "SELECT * FROM `score_shooter` WHERE `match_id` = " . $mid;
                            //     if (isset($sql_order)) {
                            //         $sql .= $sql_order;
                            //     }
                            //     echo '<div class="h5 mt-4 mb-1">' . 'Over All' . '</div>';

                            //     echo '<div style="font-size: 0.9em;">';
                            //     gen_result_table($mid, $sql);
                            //     echo '</div>';
                            //     break;
                        case "category":
                            if ($_GET["p"] == "overall") {
                                $categories = $fnc->get_match_categories($mid);

                                foreach ($categories as $cate) {
                                    echo '<div class="h5 mt-4 mb-1 text-dark">' . $cate . '</div>';

                                    $sql = "SELECT * FROM `score_shooter` WHERE `shooter_categories` LIKE '%" . $cate . "%' AND `match_id` = " . $mid;
                                    if (isset($sql_order)) {
                                        $sql .= $sql_order;
                                    }

                                    echo '<div style="font-size: 0.9em;">';
                                    gen_result_table($mid, $sql);
                                    echo '</div>';
                                }
                            } elseif ($_GET["p"] != "") {
                                // $sql = "Select scsh.shooter_categories From score_shooter scsh Where scsh.shooter_categories <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_categories Order By scsh.shooter_categories";
                                // $categories = $fnc->get_db_array($sql);
                                $categories = $fnc->get_match_categories($mid);
                                foreach ($categories as $cate) {
                                    $sql = "SELECT * FROM `score_shooter` WHERE `shooter_categories` LIKE '%" . $cate . "%' AND `match_id` = " . $mid . " And `shooter_division` = '" . $_GET["p"] . "'";
                                    if (!empty($fnc->get_db_row($sql))) {
                                        echo '<div class="h5 mt-4 mb-1 text-dark">' . $cate . '</div>';

                                        if (isset($sql_order)) {
                                            $sql .= $sql_order;
                                        }

                                        echo '<div style="font-size: 0.9em;">';
                                        gen_result_table($mid, $sql);
                                        echo '</div>';
                                    }
                                }
                            }
                            break;
                        case "stage":
                            if (isset($_GET["p"]) && $_GET["p"] != "") {
                                // echo '<div class="h3 mt-4 mb-1">Stage #' . $_GET["p"] . '</div>';
                                // $sql = "Select scsh.shooter_division From score_stage scst Right Join score_shooter scsh On scst.score_shooter_id = scsh.shooter_id Where scsh.match_id = " . $mid . " Group By scsh.shooter_division Order By scsh.shooter_division";
                                // $division = $fnc->get_db_array($sql);
                                // foreach ($division as $div) {
                                echo '<div class="h5 mt-4 mb-1 text-dark">Stage #' . $_GET["p"] . '</div>';

                                $sql = "Select scsh.*, scst.score_stage_number, scst.score_stage_time, scst.score_stage_string_1, scst.score_stage_PD, scst.score_stage_HNT, scst.score_stage_PE, scst.score_stage_FTDR, scst.score_stage_FP, scst.score_stage_finger_PE, scst.score_stage_DNF From score_stage scst Right Join score_shooter scsh On scst.score_shooter_id = scsh.shooter_id";
                                $sql .= " Where Cast(scst.score_stage_number As Int) = " . $_GET["p"] . " And scsh.match_id = " . $mid . "";
                                $sql .= " GROUP BY shooter_id";
                                $sql .= " Order By scst.score_stage_time, scst.score_stage_PD, scst.score_stage_HNT";
                                echo '<div style="font-size: 0.9em;">';
                                // $fnc->debug_console('stage sql: ' . $sql);
                                gen_result_table($mid, $sql);
                                echo '</div>';
                                // }
                            }
                            break;
                            // case "stages":
                            //     $sql = "Select Cast(scst.score_stage_number As Int) From score_stage scst Where scst.match_id = " . $mid . " Group By Cast(scst.score_stage_number As Int)";
                            //     $categories = $fnc->get_db_array($sql);
                            //     foreach ($categories as $cate) {
                            //         echo '<div class="h2 mt-4">' . $cate["score_stage_number"] . '</div>';

                            //         $sql = "SELECT * FROM `score_shooter` WHERE `score_stage_number` = '" . $cate["score_stage_number"] . "' AND `match_id` = " . $mid;
                            //         if (isset($sql_order)) {
                            //             $sql .= $sql_order;
                            //         }

                            //         echo '<div style="font-size: 0.9em;">';
                            //         gen_result_table($mid, $sql);
                            //         echo '</div>';
                            //     }
                            //     break;
                        case "divisionclass":
                            echo '<h3 class="text-dark">Match Result: Division / Class</h3>';
                            $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division ORDER BY CASE WHEN shooter_division = 'SSP' THEN 1 WHEN shooter_division = 'ESP' THEN 2 WHEN shooter_division = 'CDP' THEN 3 WHEN shooter_division = 'CCP' THEN 4 WHEN shooter_division = 'BUG' THEN 5 WHEN shooter_division = 'REV' THEN 6 WHEN shooter_division = 'CO' THEN 7 WHEN shooter_division = 'PCC30' THEN 8 WHEN shooter_division = 'PCC-30' THEN 9 WHEN shooter_division = 'PCC-SMG' THEN 10 WHEN shooter_division = 'PCC10' THEN 11 WHEN shooter_division = 'PCC-10' THEN 12 WHEN shooter_division = 'PCC-RIFLE' THEN 13 WHEN shooter_division = 'SPD' THEN 14 ELSE 15 END ASC";
                            $division = $fnc->get_db_array($sql);
                            foreach ($division as $div) {
                                $sql = "Select scsh.shooter_class From score_shooter scsh Where scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.match_id = " . $mid . " Group By scsh.shooter_class ORDER BY CASE WHEN shooter_class = 'MA' THEN 2 WHEN shooter_class = 'EX' THEN 3 WHEN shooter_class = 'SS' THEN 4 WHEN shooter_class = 'MM' THEN 5 WHEN shooter_class = 'NV' THEN 6 WHEN shooter_class = 'UN' THEN 7 WHEN shooter_class = 'ALL' THEN 8 ELSE 10 END ASC";
                                $class = $fnc->get_db_array($sql);
                                foreach ($class as $cls) {
                                    echo '<div class="h5 mt-4 mb-1 text-dark">' . $div["shooter_division"] . " / " . $cls["shooter_class"] . '</div>';

                                    $sql = "Select * From score_shooter scsh Where scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.shooter_class = '" . $cls["shooter_class"] . "' And scsh.match_id = " . $mid;
                                    if (isset($sql_order)) {
                                        $sql .= $sql_order;
                                    }
                                    echo '<div style="font-size: 0.9em;">';
                                    gen_result_table($mid, $sql);
                                    echo '</div>';
                                }
                            }
                            break;
                        case "overall":
                            $sql = "SELECT * FROM `score_shooter` WHERE `match_id` = " . $mid;
                            if (isset($sql_order)) {
                                $sql .= $sql_order;
                            }
                            echo '<h3 class="text-dark">Match Result: Overall</h3>';

                            echo '<div style="font-size: 0.9em;">';
                            gen_result_table($mid, $sql);
                            echo '</div>';
                            break;
                    }
                }


                ?>
            </div>


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
    include('../../sweet_alert.php');
    ?>

    <? //php require __DIR__ . '/../../policy/cookies-consent.php'; 
    ?>

</body>

</html>