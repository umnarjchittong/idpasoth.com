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
                // echo '<td class="text-center" style="white-space: nowrap;">' . $fnc->gen_categories_shorty($row["shooter_categories"]) . '</td>';
                echo '<td class="text-center" style="white-space: nowrap;">' . $row["shooter_categories"] . '</td>';
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
                        <p class="h4 fw-bold text-white">รายชื่อนักกีฬาที่ลงทะเบียน</p>
                        <?php view_shooter_list($mid); ?>
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

            <?//php require __DIR__ . '/../../policy/cookies-consent.php'; ?>

        </body>

        </html>