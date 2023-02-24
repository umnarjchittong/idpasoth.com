<!doctype html>
<?php
die();
include("../core.php");
$fnc = new web;

$mid = $fnc->current_match_id;

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
    <title>SOTH - Member Information</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
    <!-- Convert this to an external style sheet -->


</head>

<body class="d-flex flex-column h-100 bg-dark">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-secondary bg-gradient">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Safety Officer Thailand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?p=home&mid=10">home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Begin page content -->
    <main class="flex-shrink-0 mh-100">

        <?php
        $sql = "SELECT `setting_view_result` FROM `settings` ORDER BY `setting_id` Desc LIMIT 1";
        $view_result = $fnc->get_db_col($sql);
        if ($view_result == 'true') { ?>
            <div class="bg-dark text-secondary px-4 py-5 text-start h-100">
                <?php if (isset($_GET["uid"])) {
                    $sql = "Select * From `match-idpa` Where `match-idpa`.match_id = " . $mid;
                    $match = $fnc->get_db_row($sql);
                    $sql = "Select * From score_shooter Where score_shooter.match_id = " . $mid . " And Left(score_shooter.shooter_lastName, 3) = '" . $_GET["uid"] . "'";
                    $shooter = $fnc->get_db_row($sql);
                    if (!$shooter) {
                        echo '<meta http-equiv="refresh" content="0;url=myscore.php">';
                    }
                    $sql = "Select * From score_stage Where score_stage.match_id = " . $mid . " And score_stage.score_shooter_id = " . $shooter["shooter_id"] . " Order By Cast(score_stage.score_shooter_id As Int)";
                    $stage = $fnc->get_db_array($sql);
                ?>
                    <div class="mb-3" style="margin-top: 2em;">
                        <div class="row g-3">
                            <div class="col-3 col-md-1"><img src="../images/soth_logo.png" class="img-fluid rounded"></div>
                            <div class="col">
                                <p class="h4 fw-bold text-white mb-1"><?= $match["match_name"] ?></p>
                                <p class="h6 text-muted"><?= $match["match_location"] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class=""><span class="text-warning fw-bold h2 me-3"><?= substr($shooter["shooter_lastName"], 0, 3) ?></span><span class="text-capitalize h3 text-light"><?= $shooter["shooter_firstName"] . '&nbsp;&nbsp;' . substr($shooter["shooter_lastName"], 3) ?></span></div>
                        <div class=""><span class="text-light h5 me-3 text-uppercase"><?= $shooter["shooter_division"] . ' / ' .  $shooter["shooter_class"] ?></span><span class="text-light h5 me-3 text-uppercase"><?= 'SQ#' . '<span class="text-warning">' . $shooter["shooter_squad"] . '</span>' ?></span><span class="text-capitalize h6 text-light"><?= ($shooter["shooter_categories"]) ?></span></div>
                        <hr style="margin-top: 0.5em;">
                    </div>
                    <div class="mt-4 mb-3">
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

                <?php } else { ?>
                    <div class="py-5">
                        <h1 class="display-5 fw-bold text-white">Dark mode hero</h1>
                        <div class="col-lg-6 mx-auto">
                            <p class="fs-5 mb-4">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                <button type="button" class="btn btn-outline-info btn-lg px-4 me-sm-3 fw-bold">Custom button</button>
                                <button type="button" class="btn btn-outline-light btn-lg px-4">Secondary</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        <?php } else { ?>
            <div class="bg-dark text-secondary px-4 py-5 text-start h-100 text-center pt-5 mt-5">
                <div class="text-light text-uppercase txt-center align-self-center">No right time.</div>
            </div>
        <?php } ?>

    </main>

    <div class="row align-items-end">
        <footer class="footer mt-auto py-3 bg-light text-secondary px-4 text-center">
            <div class="container">
                <span class="text-muted h6 fw-bold" style="font-size:0.9em;">IDPA Online Scoring Presented By SOTH</span>
            </div>
        </footer>
    </div>




    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</body>

</html>