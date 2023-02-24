<!doctype html>
<html lang="en">
<?php
include('../core.php');
if (empty($_SESSION["member"]) || $_SESSION["member"]["auth_lv"] < 5) {
    die('<meta http-equiv="refresh" content="0;url=../sign/signout.php?p=no-right">');
    // die();
} else {
    $fnc = new web;

    if (isset($_GET["$mid"]) && $_SESSION["member"]["setting"]["setting_match_active"] != $_GET["mid"]) {
        die('<meta http-equiv="refresh" content="0;url=../member/">');
    }

    // if ($_SESSION["member"]["auth_lv"] >= 9) {
    // $fnc->system_debug = $_SESSION["member"]["setting"]["setting_debug_show"];
    // $fnc->system_alert = $_SESSION["member"]["setting"]["setting_alert"];
    // $fnc->system_meta_redirect = $_SESSION["member"]["setting"]["setting_meta_redirect"];
    // $fnc->database_sample = $_SESSION["member"]["setting"]["setting_db_name"];
    // }
    $fnc->debug_console("member info", $_SESSION["member"]);
}

$mid = $_SESSION["member"]["setting"]["setting_match_active"];
if (isset($_GET["mid"]) && $_GET["mid"] != "") {
    $mid = $_GET["mid"];
}


function gen_result_table($mid, $sql)
{
    global $fnc, $trophy_total;
?>
    <table class="table table-striped table-bordered table-hover table-responsive">
        <thead class="thead-inverse">
            <tr class="table-secondary text-center">
                <?php if ($_GET['v'] == 'dnf' || $_GET['v'] == 'dq') {
                    echo '<th style="width:4em;">#</th>';
                } else {
                    echo '<th style="width:4em;">Place</th>';
                } ?>
                <th class="text-start">Shooter Name</th>
                <?php if (isset($_GET["v"]) && $_GET["v"] != "divisionclass" && $_GET["v"] != "dc") {
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
            $trophy_total += count($data_array);
            // $fnc->debug_console("dq array: ", $data_array);
            if (($data_array)) {
                $x_row = 1;
                foreach ($data_array as $row) {
                    if ($row["shooter_total_score"] > 0 || $_GET['v'] == "dnf" || $_GET['v'] == "dq") {
                        echo '<tr class="">';
                        if ($_GET['v'] == 'dnf' || $_GET['v'] == 'dq') {
                            echo '<td scope="row" class="text-center">' . $row["shooter_number"] . '</td>';
                        } else {
                            echo '<td scope="row" class="text-center">' . $x_row . '</td>';
                        }
                        if ($_SESSION["member"]["auth_lv"] >= 7) {
                            $admin_view = '&admin=' . $_SESSION["member"]["auth_lv"];
                        } else {
                            $admin_view = '';
                        }
                        echo '<td class="text-start"><a href="../shooter/?uid=' . $row["shooter_number"] . '&p=shooterresult&act=shooterview' . $admin_view . '&mid=' . $mid . '" target="_blank">' . $row["shooter_firstName"] .  '&nbsp;&nbsp;&nbsp;' . $row["shooter_lastName"];
                        if (!empty($row["shooter_idpa"])) {
                            echo ', ' . strtoupper($row["shooter_idpa"]) . '';
                        }
                        echo '</a></td>';
                        if (isset($_GET["v"]) && $_GET["v"] != "divisionclass" && $_GET["v"] != "dc") {
                            if (isset($_GET["v"]) && $_GET["v"] != "division") {
                                echo '<td class="text-center">' . $row["shooter_division"];
                                if ($_SESSION["member"]["auth_lv"] == 9) {
                                    echo '/' . $row["shooter_class"];
                                }
                                echo '</td>';
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

function gen_result_table_2OK($mid, $sql)
{
    global $fnc;
?>
    <table class="table table-striped table-bordered table-hover table-responsive">
        <thead class="thead-inverse">
            <tr class="table-secondary text-center">
                <th style="width:4em;">Place</th>
                <?php if (isset($_GET["v"]) && $_GET["v"] != "divisionclass") {
                    if (isset($_GET["v"]) && $_GET["v"] != "division") { ?>
                        <th style="width:6em;">Division</th>
                    <?php } ?>
                    <th style="width:5em;">Class</th>
                <?php } ?>
                <th class="text-start">Shooter Name</th>
                <th style="width:4em;">SQT</th>
                <?php if (isset($_GET["v"]) && $_GET["v"] != "category") { ?>
                    <th style="width:10em;">Categories</th>
                <?php } ?>
                <th style="width:5.5em;">Time</th>
                <th style="width:4em;">PD</th>
                <th style="width:4em;">HNT</th>
                <?php if (isset($_GET["v"]) && $_GET["v"] == "stage") { ?>
                    <th style="width:4em;">PE</th>
                    <th style="width:4em;">FTDR</th>
                    <th style="width:4em;">FP</th>
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
                    echo '<tr class="">';
                    echo '<td scope="row" class="text-center">' . $x_row . '</td>';
                    if (isset($_GET["v"]) && $_GET["v"] != "divisionclass") {
                        if (isset($_GET["v"]) && $_GET["v"] != "division") {
                            echo '<td class="text-center">' . $row["shooter_division"] . '</td>';
                        }
                        echo '<td class="text-center">' . $row["shooter_class"] . '</td>';
                    }
                    echo '<td class="text-start"><a href="../shooter/?uid=' . $row["shooter_number"] . '" target="_blank">' . $row["shooter_firstName"] .  '&nbsp;&nbsp;&nbsp;' . $row["shooter_lastName"] . '</a></td>';
                    echo '<td class="text-center">' . $row["shooter_squad"] . '</td>';
                    if (isset($_GET["v"]) && $_GET["v"] != "category") {
                        echo '<td class="text-center">' . $fnc->gen_categories_shorty($row["shooter_categories"]) . '</td>';
                    }
                    echo '<td class="text-center">' . $row["shooter_total_score"] . '</td>';
                    echo '<td class="text-center">' . $row["shooter_PD"] . '</td>';
                    echo '<td class="text-center">' . $row["shooter_HNT"] . '</td>';
                    if (isset($_GET["v"]) && $_GET["v"] == "stage") {
                        echo '<td class="text-center">' . $row["score_stage_PE"] . '</td>';
                        echo '<td class="text-center">' . $row["score_stage_FTDR"] . '</td>';
                        echo '<td class="text-center">' . $row["score_stage_FP"] . '</td>';
                    }
                    echo '</tr>';
                    $x_row++;
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
                $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division Order By scsh.shooter_division";
                $division = $fnc->get_db_array($sql);
                foreach ($division as $div) {
                    $sql = "Select scsh.shooter_class From score_shooter scsh Where scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.match_id = " . $mid . " Group By scsh.shooter_class";
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
    <link rel="icon" type="image/x-icon" href="/images/favicon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
    <!-- Convert this to an external style sheet -->

</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary bg-gradient">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../admin/">SOTH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<? // php if (isset($_GET["v"]) && $_GET["v"] == "report") {
                                                            // echo ' active"';
                                                            // } 
                                                            ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Overall</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "so") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=overall&mid=<?= $_GET["mid"] ?>">Combined</a></li>
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "so") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=overall&mid=<?= $_GET["mid"] ?>&g=pistol">Pistol</a></li>
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "divisionclass") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=overall&mid=<?= $_GET["mid"] ?>&g=pcc">PCC</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<? // php if (isset($_GET["v"]) && $_GET["v"] == "report") {
                                                            // echo ' active"';
                                                            // } 
                                                            ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Most Accurate</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "so") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=most&mid=<?= $_GET["mid"] ?>">Combined</a></li>
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "so") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=most&mid=<?= $_GET["mid"] ?>&g=pistol">Pistol</a></li>
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "divisionclass") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=most&mid=<?= $_GET["mid"] ?>&g=pcc">PCC</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "dc") {
                                                echo ' active"';
                                            } ?>" href="?v=dc&mid=<?= $_GET["mid"] ?>">Division Champion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET["v"]) && $_GET["v"] == "divisionclass") {
                                                echo ' active"';
                                            } ?> link-primary" href="?v=divisionclass&mid=<?= $_GET["mid"] ?>">Division/Class</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php if (isset($_GET["v"]) && $_GET["v"] == "category") {
                                                                echo ' active"';
                                                            } ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Category Leaders</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "overall") {
                                                            echo ' active"';
                                                        } ?>" href="?v=category&p=overall&mid=<?= $_GET["mid"] ?>">Overall</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <?php
                            $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division ORDER BY CASE WHEN shooter_division = 'SSP' THEN 1 WHEN shooter_division = 'ESP' THEN 2 WHEN shooter_division = 'CDP' THEN 3 WHEN shooter_division = 'CCP' THEN 4 WHEN shooter_division = 'BUG' THEN 5 WHEN shooter_division = 'REV' THEN 6 WHEN shooter_division = 'CO' THEN 7 WHEN shooter_division = 'PCC30' THEN 8 WHEN shooter_division = 'PCC-30' THEN 9 WHEN shooter_division = 'PCC-SMG' THEN 10 WHEN shooter_division = 'PCC10' THEN 11 WHEN shooter_division = 'PCC-10' THEN 12 WHEN shooter_division = 'PCC-RIFLE' THEN 13 WHEN shooter_division = 'SPD' THEN 14 ELSE 15 END ASC";
                            $division = $fnc->get_db_array($sql);
                            foreach ($division as $div) {
                                echo '<li><a class="dropdown-item';
                                if (isset($_GET["p"]) && $_GET["p"] == $div["shooter_division"]) {
                                    echo ' active"';
                                }
                                echo '" href="?v=category&p=' . $div["shooter_division"] . '&mid=' . $_GET["mid"] . '">' . $div["shooter_division"] . '</a></li>';
                            }
                            ?>
                        </ul>
                    </li>

                    <!-- not used -->
                    <!-- <li class="nav-item">
                        <a class="nav-link<? // php if (isset($_GET["v"]) && $_GET["v"] == "mostaccurate") {
                                            // echo ' active"';
                                            // } 
                                            ?>" href="?v=mostaccurate">Most Accurate</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<? // php if (isset($_GET["v"]) && $_GET["v"] == "report") {
                                                            // echo ' active"';
                                                            // } 
                                                            ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Reports</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "so") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=report&p=trophy">Trophy Report</a></li>
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "divisionclass") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=report&p=awards">Awards Report</a></li>
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "divisionclass") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=report&p=penalty">Penalty Report</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<? // php if (isset($_GET["v"]) && $_GET["v"] == "Review") {
                                                            // echo ' active"';
                                                            // } 
                                                            ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Review</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "stg1") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=review&p=stg1">Stage #1</a></li>
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "stg2") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=review&p=stg2">Stage #2</a></li>
                            <li><a class="dropdown-item<? // php if (isset($_GET["p"]) && $_GET["p"] == "stg3") {
                                                        //echo ' active"';
                                                        //} 
                                                        ?>" href="?v=review&p=stg3">Stage #3</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<? // php if (isset($_GET["v"]) && $_GET["v"] == "leaderboard") {
                                            // echo ' active"';
                                            // } 
                                            ?>" href="?v=leaderboard">Leader Board</a>
                    </li> -->

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
                                echo '" href="?v=stage&p=' . $div["score_stage_number"] . '&mid=' . $_GET["mid"] . '&div=' . $_GET["div"] . '&cls=' . $_GET["cls"] . '">Stage #' . $div["score_stage_number"] . '</a></li>';
                            }
                            ?>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="?v=dnf&mid=<?= $_GET["mid"] ?>">DNF</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?v=dq&mid=<?= $_GET["mid"] ?>">DQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../sign/signout.php?p=signout">ออกจากระบบ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <main class="flex-shrink-0 pb-4">
        <div class="container">

            <div class="col-12 col-md-11 col-lg-10 mt-3">
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
                                    echo '<div class="h5 mt-4 mb-1">' . $cate . '</div>';

                                    $sql = "SELECT * FROM `score_shooter` WHERE shooter_place >= 1 AND `shooter_categories` LIKE '%" . $cate . "%' AND `match_id` = " . $mid;
                                    $sql .= " ORDER BY shooter_total_score";
                                    // if ($_SESSION["member"]["auth_lv"] < 9) {
                                    //     $sql .= " LIMIT 5";
                                    // }

                                    echo '<div style="font-size: 0.9em;">';
                                    gen_result_table($mid, $sql);
                                    echo '</div>';
                                }
                            } elseif ($_GET["p"] != "") {
                                // $sql = "Select scsh.shooter_categories From score_shooter scsh Where scsh.shooter_categories <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_categories Order By scsh.shooter_categories";
                                // $categories = $fnc->get_db_array($sql);
                                $categories = $fnc->get_match_categories($mid);
                                foreach ($categories as $cate) {
                                    echo '<div class="h5 mt-4 mb-1">' . $cate . '</div>';

                                    $sql = "SELECT * FROM `score_shooter` WHERE shooter_place >= 1 AND  `shooter_categories` LIKE '%" . $cate . "%' AND `match_id` = " . $mid . " And `shooter_division` = '" . $_GET["p"] . "'";
                                    $sql .= " ORDER BY shooter_total_score";
                                    // if ($_SESSION["member"]["auth_lv"] < 9) {
                                    //     $sql .= " LIMIT 5";
                                    // }

                                    echo '<div style="font-size: 0.9em;">';
                                    gen_result_table($mid, $sql);
                                    echo '</div>';
                                }
                            }
                            break;
                        case "stage":
                            if (isset($_GET["p"]) && $_GET["p"] != "") {
                                // echo '<div class="h3 mt-4 mb-1">Stage #' . $_GET["p"] . '</div>';
                                // $sql = "Select scsh.shooter_division From score_stage scst Right Join score_shooter scsh On scst.score_shooter_id = scsh.shooter_id Where scsh.match_id = " . $mid . " Group By scsh.shooter_division Order By scsh.shooter_division";
                                // $division = $fnc->get_db_array($sql);
                                // foreach ($division as $div) {
                                if ($_SESSION["member"]["auth_lv"] == 9) {
                                    echo '<div class="d-flex justify-content-end">';
                                    echo '<div class="col-12 col-lg-5 mb-3">
                                    <form action="?" method="get">';
                                    echo '<div class="input-group">
                                    <input type="hidden" name="v" value="' . $_GET["v"] . '">
                                    <input type="hidden" name="p" value="' . $_GET["p"] . '">
                                    <input type="hidden" name="mid" value="' . $_GET["mid"] . '">
                                    <input type="text" name="div" class="form-control text-center" placeholder="Div" value="' . strtoupper($_GET["div"]) . '" aria-label="Division" aria-describedby="btn-filter">
                                    <input type="text" name="cls" class="form-control text-center" placeholder="Class" value="' . strtoupper($_GET["cls"]) . '" aria-label="Class" aria-describedby="btn-filter">
                                    <button class="btn btn-outline-primary" type="submit" id="btn-filter">Stage View</button>
                                    <button class="btn btn-outline-success" type="submit" id="btn-filter" name="stg" value="all">View All</button>
                                  </div>';
                                    echo '</form>
                                    </div>';
                                    echo '</div>';
                                }

                                if ($_GET["stg"] == "all") {
                                    $m_stage = $fnc->get_db_col("SELECT match_stages FROM match_idpa Where match_id = " . $_GET["mid"]);
                                    for ($stg = 1; $stg <= $m_stage; $stg++) {
                                        echo '<div class="h5 mt-4 mb-1">Stage #' . $stg . '</div>';

                                        $sql = "Select scsh.*, scst.score_stage_number, scst.score_stage_time, scst.score_stage_string_1, scst.score_stage_PD, scst.score_stage_HNT, scst.score_stage_PE, scst.score_stage_FTDR, scst.score_stage_FP, scst.score_stage_finger_PE, scst.score_stage_DNF From score_stage scst Right Join score_shooter scsh On scst.score_shooter_id = scsh.shooter_id";
                                        $sql .= " Where scsh.shooter_place >= 1 AND Cast(scst.score_stage_number As Int) = " . $stg . " And scsh.match_id = " . $mid . "";
                                        if (isset($_GET["div"]) && $_GET["div"] != "") {
                                            $sql .= " AND scsh.shooter_division = '" . $_GET["div"] . "'";
                                        }
                                        if (isset($_GET["cls"]) && $_GET["cls"] != "") {
                                            $sql .= " AND scsh.shooter_class = '" . $_GET["cls"] . "'";
                                        }
                                        $sql .= " GROUP BY shooter_id";
                                        // $sql .= " Order By scst.score_stage_time, scst.score_stage_PD, scst.score_stage_HNT";
                                        $sql .= " Order By scst.score_stage_time";
                                        echo '<div style="font-size: 0.9em;">';
                                        $fnc->debug_console('stage sql: ' . $sql);
                                        gen_result_table($mid, $sql);
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<div class="h5 mt-4 mb-1">Stage #' . $_GET["p"] . '</div>';

                                    $sql = "Select scsh.*, scst.score_stage_number, scst.score_stage_time, scst.score_stage_string_1, scst.score_stage_PD, scst.score_stage_HNT, scst.score_stage_PE, scst.score_stage_FTDR, scst.score_stage_FP, scst.score_stage_finger_PE, scst.score_stage_DNF From score_stage scst Right Join score_shooter scsh On scst.score_shooter_id = scsh.shooter_id";
                                    $sql .= " Where scsh.shooter_place >= 1 AND Cast(scst.score_stage_number As Int) = " . $_GET["p"] . " And scsh.match_id = " . $mid . "";
                                    if (isset($_GET["div"]) && $_GET["div"] != "") {
                                        $sql .= " AND scsh.shooter_division = '" . $_GET["div"] . "'";
                                    }
                                    if (isset($_GET["cls"]) && $_GET["cls"] != "") {
                                        $sql .= " AND scsh.shooter_class = '" . $_GET["cls"] . "'";
                                    }
                                    $sql .= " GROUP BY shooter_id";
                                    // $sql .= " Order By scst.score_stage_time, scst.score_stage_PD, scst.score_stage_HNT";
                                    $sql .= " Order By scst.score_stage_time";
                                    echo '<div style="font-size: 0.9em;">';
                                    $fnc->debug_console('stage sql: ' . $sql);
                                    gen_result_table($mid, $sql);
                                    echo '</div>';
                                }
                                // }
                            }
                            break;
                        case "stage2":
                            if (isset($_GET["p"]) && $_GET["p"] != "") {
                                // echo '<div class="h3 mt-4 mb-1">Stage #' . $_GET["p"] . '</div>';
                                $sql = "Select scsh.shooter_division From score_stage scst Right Join score_shooter scsh On scst.score_shooter_id = scsh.shooter_id Where scsh.shooter_place >= 1 AND scsh.match_id = " . $mid . " Group By scsh.shooter_division Order By scsh.shooter_division";
                                $division = $fnc->get_db_array($sql);
                                foreach ($division as $div) {
                                    echo '<div class="h5 mt-4 mb-1">Stage #' . $_GET["p"] . ' - ' . $div["shooter_division"] . '</div>';

                                    $sql = "Select scsh.*, scst.score_stage_number, scst.score_stage_time, scst.score_stage_string_1, scst.score_stage_PD, scst.score_stage_HNT, scst.score_stage_PE, scst.score_stage_FTDR, scst.score_stage_FP, scst.score_stage_finger_PE, scst.score_stage_DNF From score_stage scst Right Join score_shooter scsh On scst.score_shooter_id = scsh.shooter_id 
                                            Where scsh.shooter_place >= 1 AND Cast(scst.score_stage_number As Int) = " . $_GET["p"] . " And scsh.match_id = " . $mid . " AND scsh.shooter_division = '" . $div["shooter_division"] . "'";
                                    $sql .= " Order By scst.score_stage_time, scst.score_stage_PD, scst.score_stage_HNT";
                                    echo '<div style="font-size: 0.9em;">';
                                    gen_result_table($mid, $sql);
                                    echo '</div>';
                                }
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

                                echo '<div style="font-size: 0.9em;">';
                                gen_result_table($mid, $sql);
                                echo '</div>';
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

                                echo '<div style="font-size: 0.9em;">';
                                gen_result_table($mid, $sql);
                                echo '</div>';
                            }
                            break;
                        case "stages":
                            $sql = "Select Cast(scst.score_stage_number As Int) From score_stage scst Where scsh.shooter_place >= 1 AND scst.match_id = " . $mid . " Group By Cast(scst.score_stage_number As Int)";
                            $categories = $fnc->get_db_array($sql);
                            foreach ($categories as $cate) {
                                echo '<div class="h2 mt-4">' . $cate["score_stage_number"] . '</div>';

                                $sql = "SELECT * FROM `score_shooter` WHERE shooter_place >= 1 AND `score_stage_number` = '" . $cate["score_stage_number"] . "' AND `match_id` = " . $mid;
                                if (isset($sql_order)) {
                                    $sql .= $sql_order;
                                }

                                echo '<div style="font-size: 0.9em;">';
                                gen_result_table($mid, $sql);
                                echo '</div>';
                            }
                            break;
                        case "divisionclass":
                            $trophy_total = 0;
                            echo '<h3 id="title">Match Result: Division / Class</h3>';
                            // $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division Order By scsh.shooter_division";
                            $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division ORDER BY CASE WHEN shooter_division = 'SSP' THEN 1 WHEN shooter_division = 'ESP' THEN 2 WHEN shooter_division = 'CDP' THEN 3 WHEN shooter_division = 'CCP' THEN 4 WHEN shooter_division = 'BUG' THEN 5 WHEN shooter_division = 'REV' THEN 6 WHEN shooter_division = 'CO' THEN 7 WHEN shooter_division = 'PCC30' THEN 8 WHEN shooter_division = 'PCC-30' THEN 9 WHEN shooter_division = 'PCC-SMG' THEN 10 WHEN shooter_division = 'PCC10' THEN 11 WHEN shooter_division = 'PCC-10' THEN 12 WHEN shooter_division = 'PCC-RIFLE' THEN 13 WHEN shooter_division = 'SPD' THEN 14 ELSE 15 END ASC";
                            $division = $fnc->get_db_array($sql);
                            foreach ($division as $div) {
                                $sql = "Select scsh.shooter_class From score_shooter scsh Where scsh.shooter_place >= 1 AND scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.match_id = " . $mid . " Group By scsh.shooter_class ORDER BY CASE WHEN shooter_class = 'MA' THEN 2 WHEN shooter_class = 'EX' THEN 3 WHEN shooter_class = 'SS' THEN 4 WHEN shooter_class = 'MM' THEN 5 WHEN shooter_class = 'NV' THEN 6 WHEN shooter_class = 'UN' THEN 7 WHEN shooter_class = 'ALL' THEN 8 ELSE 10 END ASC";
                                $class = $fnc->get_db_array($sql);
                                foreach ($class as $cls) {
                                    echo '<div class="h5 mt-4 mb-1">' . $div["shooter_division"] . " / " . $cls["shooter_class"] . '</div>';

                                    $sql = "Select * From score_shooter scsh Where scsh.shooter_place >= 1 AND scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.shooter_class = '" . $cls["shooter_class"] . "' And scsh.match_id = " . $mid;
                                    $sql .= " ORDER BY scsh.shooter_total_score";
                                    // if ($_SESSION["member"]["auth_lv"] < 9) {
                                    //     $sql .= " LIMIT 5";
                                    // }
                                    echo '<div style="font-size: 0.9em;">';
                                    gen_result_table($mid, $sql);
                                    echo '</div>';
                                }
                                echo '<hr class="mx-auto" style="color: #1271fd; width: 50vw; height: 4px; margin-bottom:65px;">';
                            }
                            echo '<script>
                            let title = document.getElementById("title").innerHTML;
                              document.getElementById("title").innerHTML = title + " (รวม ' . $trophy_total . ' รางวัล)";
                            </script>';
                            break;
                        case "dc":
                            echo '<h3>Match Result: Division Champion</h3>';
                            $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division ORDER BY CASE WHEN shooter_division = 'SSP' THEN 1 WHEN shooter_division = 'ESP' THEN 2 WHEN shooter_division = 'CDP' THEN 3 WHEN shooter_division = 'CCP' THEN 4 WHEN shooter_division = 'BUG' THEN 5 WHEN shooter_division = 'REV' THEN 6 WHEN shooter_division = 'CO' THEN 7 WHEN shooter_division = 'PCC30' THEN 8 WHEN shooter_division = 'PCC-30' THEN 9 WHEN shooter_division = 'PCC-SMG' THEN 10 WHEN shooter_division = 'PCC10' THEN 11 WHEN shooter_division = 'PCC-10' THEN 12 WHEN shooter_division = 'PCC-RIFLE' THEN 13 WHEN shooter_division = 'SPD' THEN 14 ELSE 15 END ASC";
                            $fnc->debug_console("SQL= ", $sql);
                            $division = $fnc->get_db_array($sql);
                            foreach ($division as $div) {
                                echo '<div class="h5 mt-4 mb-1">' . $div["shooter_division"] . '</div>';
                                $sql = "Select * From score_shooter scsh Where scsh.shooter_place >= 1 AND scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.match_id = " . $mid;
                                $sql .= ' ORDER BY shooter_total_score LIMIT 3';
                                echo '<div style="font-size: 0.9em;">';
                                gen_result_table($mid, $sql);
                                echo '</div>';

                                echo '<hr class="mx-auto" style="color: #1271fd; width: 50vw; height: 4px; margin-bottom:65px;">';
                            }
                            break;
                        case "overall":
                            if (isset($_GET["g"]) && $_GET["g"] == 'pistol') {
                                $title = "SSP, ESP, CCP, CDP, BUG, REV, CO, SPD";
                                $sql = "SELECT * FROM `score_shooter` WHERE shooter_place >= 1 AND  `match_id` = " . $mid . " AND `shooter_division` <> 'PCC'";
                            } else if (isset($_GET["g"]) && $_GET["g"] == 'pcc') {
                                $title = "PCC";
                                $sql = "SELECT * FROM `score_shooter` WHERE shooter_place >= 1 AND  `match_id` = " . $mid . " AND `shooter_division` = 'PCC'";
                            } else {
                                $title = "Combined";
                                $sql = "SELECT * FROM `score_shooter` WHERE shooter_place >= 1 AND  `match_id` = " . $mid;
                            }
                            $sql .= ' ORDER BY shooter_total_score';
                            $fnc->debug_console("SQL= ", $sql);
                            // echo $sql;
                            echo '<h3>Match Result: Overall ' . $title . '</h3>';

                            echo '<div style="font-size: 0.9em;">';
                            gen_result_table($mid, $sql);
                            echo '</div>';
                            break;
                        case "most":
                            if (isset($_GET["g"]) && $_GET["g"] == 'pistol') {
                                $title = "SSP, ESP, CCP, CDP, BUG, REV, CO, SPD";
                                $sql = "SELECT * FROM `score_shooter` WHERE shooter_place >= 1 AND  `match_id` = " . $mid . " AND `shooter_HNT` is null" . " AND `shooter_division` <> 'PCC'";
                            } else if (isset($_GET["g"]) && $_GET["g"] == 'pcc') {
                                $title = "PCC";
                                $sql = "SELECT * FROM `score_shooter` WHERE shooter_place >= 1 AND  `match_id` = " . $mid . " AND `shooter_HNT` is null" . " AND `shooter_division` = 'PCC'";
                            } else {
                                $title = "Combined";
                                $sql = "SELECT * FROM `score_shooter` WHERE shooter_place >= 1 AND  `match_id` = " . $mid . " AND `shooter_HNT` is null";
                            }
                            $sql .= " ORDER BY shooter_total_score";
                            if ($_SESSION["member"]["auth_lv"] < 9) {
                                $sql .= " LIMIT 3";
                            }
                            $fnc->debug_console("SQL= ", $sql);

                            echo '<h3>Most Accurate: ' . $title . '</h3>';

                            echo '<div style="font-size: 0.9em;">';
                            gen_result_table($mid, $sql);
                            echo '</div>';
                            break;
                        case "dnf":
                            $sql = "SELECT * FROM `score_shooter` WHERE shooter_place = 'dnf' AND  `match_id` = " . $mid;
                            if (isset($sql_order)) {
                                $sql .= $sql_order;
                            } else {
                                $sql .= " ORDER BY shooter_number";
                            }
                            echo '<h3>Match Result: DNF</h3>';

                            echo '<div style="font-size: 0.9em;">';
                            gen_result_table($mid, $sql);
                            echo '</div>';
                            break;
                        case "dq":
                            $sql = "SELECT * FROM `score_shooter` WHERE shooter_place = 'dq' AND  `match_id` = " . $mid;
                            if (isset($sql_order)) {
                                $sql .= $sql_order;
                            } else {
                                $sql .= " ORDER BY shooter_number";
                            }
                            // echo $sql;
                            echo '<h3>Match Result: DQ</h3>';

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
    include('../sweet_alert.php');
    ?>

</body>

</html>