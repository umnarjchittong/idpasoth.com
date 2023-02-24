<!doctype html>
<?php
include("../../core.php");
$fnc = new web;
if (isset($_GET["mid"]) && !empty($_GET["mid"])) {
    $mid = $_GET["mid"];
} else {
    $mid = $fnc->get_db_col("SELECT `setting_match_active` FROM `settings` ORDER BY `setting_id` Desc LIMIT 1");
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

function gen_breakdown($mid)
{
    global $fnc;
    $division_list = array("SSP", "ESP", "CDP", "CCP", "BUG", "REV", "CO", "PCC-SMG", "PCC-Rifle", "SPD");
    $sql_div = 'SELECT DISTINCT (shooter_division) FROM `score_shooter` WHERE match_id = ' . $mid . ' ORDER BY CASE WHEN shooter_division = "SSP" THEN 1 WHEN shooter_division = "ESP" THEN 2 WHEN shooter_division = "CDP" THEN 3 WHEN shooter_division = "CCP" THEN 4 WHEN shooter_division = "BUG" THEN 5 WHEN shooter_division = "REV" THEN 6 WHEN shooter_division = "CO" THEN 7 WHEN shooter_division = "PCC30" THEN 8 WHEN shooter_division = "PCC-30" THEN 9 WHEN shooter_division = "PCC-SMG" THEN 10 WHEN shooter_division = "PCC10" THEN 11 WHEN shooter_division = "PCC-10" THEN 12 WHEN shooter_division = "PCC-RIFLE" THEN 13 WHEN shooter_division = "SPD" THEN 14 ELSE 15 END ASC';
    $data_array = $fnc->get_db_rows($sql_div);
    $div_json = '';
    foreach ($data_array as $row) {
        if ($div_json) {
            $div_json .= ', ';
        }
        $div_json .= '"' . $row["shooter_division"] . '"';
    }
    $div_json = '[' . $div_json . ']';
    $division_list = json_decode($div_json, TRUE);

    $class_list = array("MA", "EX", "SS", "MM", "NV", "UN", "ALL");
    $sql_cls = 'SELECT DISTINCT (shooter_class) FROM `score_shooter` WHERE match_id = ' . $mid . ' ORDER BY CASE WHEN shooter_class = "MA" THEN 2 WHEN shooter_class = "EX" THEN 3 WHEN shooter_class = "SS" THEN 4 WHEN shooter_class = "MM" THEN 5 WHEN shooter_class = "NV" THEN 6 WHEN shooter_class = "UN" THEN 7 WHEN shooter_class = "ALL" THEN 8 ELSE 10 END ASC';
    $data_array = $fnc->get_db_rows($sql_cls);
    $cls_json = '';
    foreach ($data_array as $row) {
        if ($cls_json) {
            $cls_json .= ', ';
        }
        $cls_json .= '"' . $row["shooter_class"] . '"';
    }
    $cls_json = '[' . $cls_json . ']';
    $class_list = json_decode($cls_json, TRUE);

    $json_text = '';
    foreach ($division_list as $div) {
        $json_div = '"' . $div . '":{';
        $json_cls = '';
        foreach ($class_list as $class) {
            $data_class[$class] = 0;
            $sql_cls = "SELECT count(shooter_id) as cnt_shooter FROM score_shooter WHERE match_id = $mid AND shooter_division = '$div' AND shooter_class = '$class'";
            $fnc->debug_console("sql_cls: " . $sql_cls);
            $fnc->get_db_col($sql_cls);
            if ($json_cls) {
                $json_cls .= ',';
            }
            $json_cls .= '"' . $class . '":' . $fnc->get_db_col($sql_cls);
        }
        if ($json_text) {
            $json_text .= ',';
        }
        $json_text .= $json_div . $json_cls . '}';
    }
    $json_text = '{' . $json_text . '}';
    $data = json_decode($json_text, true);

    echo '<div class="row">';

    echo '<div class="col-12 col-lg-6">';
    echo '<table class="table table-striped table-inverse table-responsive table-bordered bg-white">
                                        <thead class="thead-inverse">';
    echo '
                                            <tr class="bg-primary text-light">
                                            <th colspan="' . (count($data_class) + 1) . '" style="text-align: center;">Division / Class</th>
                                            </tr>';
    echo '
                                            <tr class="table-secondary">';
    echo '<th>Division</th>';
    foreach ($class_list as $cls) {
        echo '<th style="text-align:center;">' . $cls . '</th>';
    }
    echo '</tr>
                                            </thead>
                                            <tbody>';
    $i = 0;
    foreach ($division_list as $div) {
        echo '
                                            <tr>';
        echo '<td style="text-align:left; font-weight:bold;">' . $div . '</td>';
        foreach ($data[$div] as $shooter) {
            echo '<td style="text-align:center;">' . $shooter . '</td>';
            $data_class[$class_list[$i]] += $shooter;
            if ($i < (count($data_class) - 1)) {
                $i++;
            } else {
                $i = 0;
            }
        }
        echo '
                                            </tr>';
    }
    echo '
                                            </tbody>
                                            </table>';
    echo '</div>';

    echo '<div class="col-6 col-lg-3">';
    echo '<table class="table table-striped table-inverse table-responsive table-bordered bg-white">
                                        <thead class="thead-inverse">';
    echo '
                                            <tr class="bg-primary text-light">
                                            <th colspan="2" style="text-align: center;">Division</th>
                                            </tr>
                                            </thead>
                                            <tbody>';
    foreach ($division_list as $div) {
        echo '
                                            <tr>';
        echo '<td style="text-align:left; font-weight:bold;">' . $div . '</td>';
        echo '<td style="text-align:center;">' . array_sum($data[$div]) . '</td>';
        echo '
                                            </tr>';
    }
    echo '
                                            </tbody>
                                            </table>';
    echo '</div>';

    echo '<div class="col-6 col-lg-3">';
    echo '<table class="table table-striped table-inverse table-responsive table-bordered bg-white">
                                        <thead class="thead-inverse">';
    echo '
                                            <tr class="bg-primary text-light">
                                            <th colspan="2" style="text-align: center;">Class</th>
                                            </tr>
                                            </thead>
                                            <tbody>';
    foreach ($class_list as $cls) {
        echo '
                                            <tr>';
        echo '<td style="text-align:left; font-weight:bold;">' . $cls . '</td>';
        echo '<td style="text-align:center;">' . $data_class[$cls] . '</td>';
        echo '
                                            </tr>';
    }
    echo '
                                            </tbody>
                                            </table>';
    echo '</div>';

    echo '</div>';
}

function view_shooter_list($mid)
{
    global $fnc;
    $sql_order = "";

    // print_r($data_array);
?>
    <table class="table table-striped table-bordered table-hover table-responsive mt-2 table-light">
        <thead class="thead-inverse">
            <tr class="table-primary text-center">
                <th style="width: 4.5em;"><a href="?sort=shooter_number" target="_top">NO.</a></th>
                <th class="text-start"><a href="?sort=shooter_firstName" target="_top">Name</a></th>
                <th style="width: 4em;"><a href="?sort=shooter_sqd" target="_top">SQ</a></th>
                <th style="width: 10em;">Division/Class</th>
                <th style="width: 12.5em;">Categories</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT *, Cast(shooter_squad As Int) as shooter_sqd FROM `score_shooter` WHERE `match_id` = " . $mid;
        $order = " ORDER BY shooter_number";
        if (isset($_GET['sort'])) {
            $order = " ORDER BY " . $_GET['sort'];
        }
        // echo $sql;
        $data_array = $fnc->get_db_array($sql . $order);
        if (($data_array)) {
            foreach ($data_array as $row) {
                echo '<tr class="">';
                echo '<td class="text-center">' . $row["shooter_number"] . '</td>';
                // echo '<td class="text-start" nowarp style="white-space: nowrap;"><a href="?p=shooterscore&mid=' . $mid . '&uid=' . $row["shooter_id"] . '" target="_blank">' . $row["shooter_firstName"] .  '&nbsp;&nbsp;&nbsp;&nbsp;' . $row["shooter_lastName"] . '</a></td>';
                echo '<td class="text-start" nowarp style="white-space: nowrap;">' . $row["shooter_firstName"] .  '&nbsp;&nbsp;&nbsp;&nbsp;' . $row["shooter_lastName"] . '</td>';
                // echo '<td class="text-center">' . $row["shooter_division"] . '</td>';
                // echo '<td class="text-center">' . $row["shooter_class"] . '</td>';
                echo '<td class="text-center">' . $row["shooter_sqd"] . '</td>';
                echo '<td class="text-center">' . $row["shooter_division"] . ' / ' . $row["shooter_class"] . '</td>';
                echo '<td class="text-center" style="white-space: nowrap;">' . $fnc->gen_categories_shorty($row["shooter_categories"]) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="">';
            echo '<td scope="row" class="text-center" colspan="8">Data Not Founded.</td>';
            echo '</tr>';
        }
        echo '
      </tbody>
</table>';
    }

        ?>
        <html lang="en">

        <head>
            <title>SOTH - Shooters Information</title>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Favicons -->
            <link href="../../images/favicon.png" rel="icon">

            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

            <link rel="stylesheet" href="../../css/style.css">
            <!-- Convert this to an external style sheet -->


        </head>

        <body class="d-flex flex-column h-100 bg-dark">
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-secondary bg-gradient">
                <div class="container-fluid">
                    <p class="navbar-brand text-white m-0 p-0" href="#">Safety Officer Thailand</p>
                </div>
            </nav>

            <!-- Begin page content -->
            <main class="flex-shrink-0 mh-100">
                <div class="bg-dark text-secondary px-4 py-5 text-start h-100">
                    <div class="col-12 col-md-9 col-lg-8 mx-auto">
                        <?php $fnc->match_info($mid); ?>
                    </div>
                    <div class="mt-5 col-12 col-md-9 col-lg-8 mx-auto">
                        <p class="h4 fw-bold text-white">Breakdown</p>
                        <?php $fnc->gen_breakdown($mid); ?>
                    </div>

                </div>

            </main>

            <div class="row align-items-end">
                <footer class="footer mt-auto py-3 bg-light text-secondary px-4 text-center">
                    <div class="container">
                        <span class="text-muted h6 fw-bold" style="font-size:0.9em;">IDPA Online Scoring Presented By SOTH</span>
                    </div>
                </footer>
            </div>


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