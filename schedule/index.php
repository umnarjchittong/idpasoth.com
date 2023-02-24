<!doctype html>
<html lang="en">
<?php
include('../core.php');
$fnc = new web;

function schedule_table($show = "all", $year = "")
{
    global $fnc;
    $incoming = "";
    if (empty($year)) {
        $year = date("Y");
    }
    if ($show == "incoming") {
        $incoming = " And match_begin >= current_timestamp()";
    }
?>
    <h3 class="text-primary"><?= $year; ?> IDPA's Matchs Schedule by SOTH</h3>
    <table class="table table-striped table-bordered table-hover able-inverse table-responsive">
        <thead class="thead-inverse table-primary">
            <tr>
                <th class="text-center text-uppercase" style="width:8em;">Date</th>
                <th class="text-center text-uppercase">Title</th>
                <th class="text-center text-uppercase d-none d-md-table-cell">MD</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `match_idpa` WHERE `match_status` <> 'delete' and year(`match_begin`) = '"  . $year . "'" . $incoming;
            $data_array = $fnc->get_db_array($sql);
            $fnc->debug_console("schedule table sql : " . $sql);
            if (!empty($data_array)) {
                foreach ($data_array as $row) {
            ?>
                    <tr>
                        <td scope="row" class="text-center"><?= date("M d, Y", strtotime($row["match_begin"])) ?></td>
                        <td><?= $row["match_name"] ?></td>
                        <td class="d-none d-md-table-cell"><?= $row["match_md"] ?></td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td scope="row" colspan="3" class="text-center">Match not found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <? //= $sql; 
    ?>


<?php
}


?>

<head>
    <title>IDAP Schedule <?= $_GET['y'] ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
    <!-- Convert this to an external style sheet -->

</head>

<body>
    <div class="container py-2">
        <img src="../images/soth_banner.png" class="img-fluid">
    </div>
    <div class="container pt-3">
        <?php
        if (isset($_GET["p"]) && $_GET["p"] == "schedule") {
            if (isset($_GET["y"])) {
                $y = $_GET["y"];
            } else {
                $y = date("Y");
            }
            schedule_table("all", $y);
        }
        ?>
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

</body>

</html>