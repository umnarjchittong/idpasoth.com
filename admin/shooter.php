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

function shooter_admin_menu()
{
?>
    <nav class="nav justify-content-end">
        <a class="nav-link" href="?p=shooter">Shooter Search</a>
        <a class="nav-link" href="?p=shooterList">Shooter List</a>
        <a class="nav-link" href="?p=shooterList0">Shooter List 0 Match</a>
        <a class="nav-link" href="?p=noShooterId">None SOTH ID</a>
        <a class="nav-link" href="?p=syncShooter">Sync Shooter</a>
        <a class="nav-link" href="?p=shooterListDel">Shooter Dup Del</a>
        <a class="nav-link" href="?p=genDb">Gen DB</a>
    </nav>
<?php
}

function gen_sync_shooter_soth_db($mid = "")
{
    global $fnc;
?>
    <h1 class="mt-5">Sync Shooters</h1>
    <!-- <p class="lead">Coming soon...</p> -->
    <?php
    if ($mid && $mid != "") {
        $sql = "Select shso.shooter_soth_id, scsh.shooter_id, scsh.shooter_idpa, scsh.shooter_firstName, scsh.shooter_lastName, scsh.shooter_categories, maid.match_name 
        From score_shooter scsh Left Join match_idpa maid On maid.match_id = scsh.match_id Left Join shooter_soth shso On shso.shooter_soth_idpa = scsh.shooter_idpa 
        Where scsh.shooter_soth_id Is Null AND scsh.match_id = " . $mid . "
        Order By scsh.shooter_firstName, scsh.shooter_lastName Desc";
    } else {
        $sql = "Select shso.shooter_soth_id, scsh.shooter_id, scsh.shooter_idpa, scsh.shooter_firstName, scsh.shooter_lastName, scsh.shooter_categories, maid.match_name 
        From score_shooter scsh Left Join match_idpa maid On maid.match_id = scsh.match_id Left Join shooter_soth shso On shso.shooter_soth_idpa = scsh.shooter_idpa 
        Where scsh.shooter_soth_id Is Null
        Order By scsh.shooter_firstName, scsh.shooter_lastName Desc";
    }
    $sql_update = "";
    $data_array = $fnc->get_db_array($sql);
    foreach ($data_array as $row) {
        if ($row['shooter_soth_id']) {
            $sql_update .= "UPDATE score_shooter SET shooter_soth_id='" . $row['shooter_soth_id'] . "' WHERE shooter_id = '" . $row["shooter_id"] . "'; ";
        } else {
            $sql = "SELECT shooter_soth_id FROM shooter_soth WHERE shooter_soth_firstname = '" . $row['shooter_firstName'] . "' AND shooter_soth_lastname = '" . $row['shooter_lastName'] . "'";
            $shooter_soth_id = $fnc->get_db_col($sql);
            if ($shooter_soth_id) {
                $sql_update .= "UPDATE score_shooter SET shooter_soth_id='" . $shooter_soth_id . "' WHERE shooter_id = '" . $row["shooter_id"] . "'; ";
            }
        }
    }

    if ($_SESSION["member"]["auth_lv"] == 9) {
        // $fnc->sql_execute_multi($sql_update);
    }
    echo '<h2>Generate Completed</h2>';
    echo $sql_update;
}

function gen_shooter_soth_db($mid = "")
{
    global $fnc;
    ?>
    <h1 class="mt-5">Shooters Gen DB</h1>
    <?php
    if ($mid && $mid != "") {
        $sql = "SELECT match_id FROM match_idpa WHERE match_id = " . $mid . " AND match_status = 'enable' ORDER by match_begin desc";
    } else {
        // $sql = "SELECT match_id FROM match_idpa WHERE match_status = 'enable' ORDER by match_begin desc";
        $sql = "SELECT match_id FROM match_idpa WHERE match_status = 'enable' ORDER by match_begin desc Limit 1";
    }
    echo $sql . "<br>";
    foreach ($fnc->get_db_array($sql) as $match) {
        // $sql = "Select * From score_shooter scsh Where scsh.match_id = " . $match['match_id'] . " And scsh.shooter_idpa <> ''";
        $sql = "Select * From score_shooter Where shooter_soth_id is null AND match_id = " . $match['match_id'];
        echo "<hr>" . $sql;
        $fnc->get_db_array($sql);
        $sql_shooter = "";
        foreach ($fnc->get_db_array($sql) as $row) {
            $sql_chk = "SELECT shooter_soth_id FROM shooter_soth WHERE shooter_soth_firstname = '" . $row["shooter_firstName"] . "' AND shooter_soth_lastname = '" . $row["shooter_lastName"] . "'";
            // echo $sql_chk . "<br>";
            // $chk = $fnc->get_db_col($sql_chk);
            // echo "chk: " . $chk;
            // var_dump($fnc->get_db_col($sql_chk));
            if (!$fnc->get_db_col($sql_chk)) {
                $uniqid = uniqid();
                // echo "NOT FOUND" . "<br>";
                $sql_shooter .= "INSERT IGNORE INTO shooter_soth(shooter_soth_id, shooter_soth_citizenid, shooter_soth_tel, shooter_soth_idpa, shooter_soth_email, shooter_soth_line, shooter_soth_firstname, shooter_soth_lastname, shooter_soth_categories) 
                        VALUES ('" . $uniqid . "','','','" . $row["shooter_idpa"] . "','" . $row["shooter_email"] . "','','" . $row["shooter_firstName"] . "','" . $row["shooter_lastName"] . "','" . $row["shooter_categories"] . "'); ";
                $sql_shooter .= "UPDATE score_shooter SET shooter_soth_id='" . $uniqid . "' WHERE shooter_firstName = '" . $row["shooter_firstName"] . "' AND shooter_lastName = '" . $row["shooter_lastName"] . "'; ";
            } else {
                $sql_chk = "SELECT shooter_soth_id FROM shooter_soth WHERE shooter_soth_firstname = '" . $row["shooter_firstName"] . "' AND shooter_soth_lastname = '" . $row["shooter_lastName"] . "'";
                $uniqid = $fnc->get_db_col($sql_chk);
                $sql_shooter .= "UPDATE score_shooter SET shooter_soth_id='" . $uniqid . "' WHERE shooter_firstName = '" . $row["shooter_firstName"] . "' AND shooter_lastName = '" . $row["shooter_lastName"] . "'; ";
                // echo "FOUND" . "<br>";
            }
        }
    }
    if ($_SESSION["member"]["auth_lv"] == 9) {
        // $fnc->sql_execute_multi($sql_shooter);
    }
    echo '<h2>Generate Completed</h2>';
    echo $sql_shooter;
}

function gen_none_shooter_id($mid = "")
{
    global $fnc;
    // $sql = "Select shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories, Count(score_shooter.shooter_soth_id) As cnt_match 
    // From shooter_soth Left Join score_shooter On score_shooter.shooter_soth_id = shooter_soth.shooter_soth_id 
    // Having Count(score_shooter.shooter_soth_id) > 0
    // Group By shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories 
    // Order By shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname";
    // $sql = "Select shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories, Count(score_shooter.shooter_soth_id) As cnt_match 
    // From shooter_soth Left Join score_shooter On score_shooter.shooter_soth_id = shooter_soth.shooter_soth_id Group By shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories 
    // Having shooter_soth.shooter_soth_id = ''
    // Order By shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname";
    $sql = "Select shso.shooter_soth_id, scsh.shooter_id, scsh.shooter_idpa, scsh.shooter_firstName, scsh.shooter_lastName, scsh.shooter_categories, maid.match_name 
    From score_shooter scsh Left Join match_idpa maid On maid.match_id = scsh.match_id Left Join shooter_soth shso On shso.shooter_soth_idpa = scsh.shooter_idpa 
    Where scsh.shooter_soth_id Is Null
    Order By scsh.shooter_firstName, scsh.shooter_lastName Desc";
    if ($mid) {
        $sql .= " AND scsh.match_id = " . $mid;
    }
    $data_array = $fnc->get_db_array($sql);

    ?>
    <div>
        <h1 class="fs-3 text-primary mt-5">Shooter Score With None SOTH ID</h1>
    </div>
    <? //= $sql 
    ?>
    <div class="table-responsive-md">
        <table class="table table-striped">
            <thead class="">
                <tr class="py-2">
                    <th scope="col">#</th>
                    <th scope="col">Key</th>
                    <th scope="col">IDPA ID</th>
                    <th scope="col">FULL NAME</th>
                    <th scope="col">CATEGORIES</th>
                    <th scope="col">MATCH</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data_array) {
                    $x = 0;
                    $sql_update = "";
                    foreach ($data_array as $row) {
                        $x++;
                        echo '<tr class="">';
                        echo '<td scope="row">' . $x . '</td>';
                        if ($row['shooter_soth_id']) {
                            $sql_update .= "UPDATE score_shooter SET shooter_soth_id='" . $row['shooter_soth_id'] . "' WHERE shooter_id = '" . $row["shooter_id"] . "'; ";
                            echo '<td><a href="?p=shooter&shooterId=' . $row['shooter_soth_id'] . '" target="shooter_view">' . $row['shooter_soth_id'] . '</a></td>';
                        } else {
                            $sql = "SELECT shooter_soth_id FROM shooter_soth WHERE shooter_soth_firstname = '" . $row['shooter_firstName'] . "' AND shooter_soth_lastname = '" . $row['shooter_lastName'] . "'";
                            $shooter_soth_id = $fnc->get_db_col($sql);
                            echo '<td><a href="?p=shooter&shooterId=' . $shooter_soth_id . '" target="shooter_view">' . $shooter_soth_id . '</a></td>';
                        }
                        echo '<td>' . $row['shooter_idpa'] . '</td>';
                        echo '<td><a href="../admin/?p=shooter&fname=' . $row['shooter_firstName'] . '&lname=' . $row['shooter_lastName'] . '" target="shooter_view">' . $row['shooter_firstName'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['shooter_lastName'] . '</a></td>';
                        echo '<td>' . $row['shooter_categories'] . '</td>';
                        echo '<td>' . $row['match_name'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<td class="text-center bg-light py-3" scope="row" colspan="6"> Data Not Found !</td>';
                }
                ?>
            </tbody>
        </table>
    </div>


<?php

    // echo $sql . "<hr>";
    // echo "<pre>";
    // print_r($data_array);
    // echo "</pre>";
}


function gen_shooter_list($keysearch = "")
{
    global $fnc;
    $sql = "SELECT * FROM shooter_soth ORDER BY shooter_soth_firstname, shooter_soth_firstname ASC";
    $sql = "SELECT * FROM shooter_soth ORDER BY shooter_soth_idpa ASC";
    $sql = "Select shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories, Count(score_shooter.shooter_soth_id) As cnt_match 
    From shooter_soth Left Join score_shooter On score_shooter.shooter_soth_id = shooter_soth.shooter_soth_id 
    Having Count(score_shooter.shooter_soth_id) > 0
    Group By shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories 
    Order By shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname";
    $sql = "Select shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories, Count(score_shooter.shooter_soth_id) As cnt_match 
    From shooter_soth Left Join score_shooter On score_shooter.shooter_soth_id = shooter_soth.shooter_soth_id Group By shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories ";
    $sql .= " Having Count(score_shooter.shooter_soth_id) > 0 ";
    $sql .= " Order By shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname";
    $data_array = $fnc->get_db_array($sql);
?>
    <div>
        <h1 class="fs-3 text-primary mt-5">Shooter List with SOTH ID</h1>
    </div>
    <div class="table-responsive-md">
        <table class="table table-primary table-striped">
            <thead class="">
                <tr>
                    <th scope="col" class="py-3">#</th>
                    <th scope="col" class="py-3">Key</th>
                    <th scope="col" class="py-3">IDPA ID</th>
                    <th scope="col" class="py-3">FULL NAME</th>
                    <th scope="col" class="py-3">CATEGORIES</th>
                    <th scope="col" class="py-3">MATCH</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 0;
                foreach ($data_array as $row) {
                    $x++;
                    if ($row['cnt_match'] == 0) {
                        echo '<tr class="text-warning">';
                    } else {
                        echo '<tr class="">';
                    }
                    echo '<td scope="row">' . $x . '</td>';
                    echo '<td><a href="?p=shooter&shooterId=' . $row['shooter_soth_id'] . '" target="shooter_view">' . $row['shooter_soth_id'] . '</a></td>';
                    echo '<td>' . $row['shooter_soth_idpa'] . '</td>';
                    echo '<td><a href="../admin/?p=shooter&fname=' . $row['shooter_soth_firstname'] . '&lname=' . $row['shooter_soth_lastname'] . '" target="shooter_view">' . $row['shooter_soth_firstname'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['shooter_soth_lastname'] . '</a></td>';
                    echo '<td>' . $row['shooter_soth_categories'] . '</td>';
                    echo '<td>' . $row['cnt_match'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>


<?php
}

function gen_shooter_list0($keysearch = "")
{
    global $fnc;
    // $sql = "SELECT * FROM shooter_soth ORDER BY shooter_soth_firstname, shooter_soth_firstname ASC";
    // $sql = "SELECT * FROM shooter_soth ORDER BY shooter_soth_idpa ASC";
    $sql = "Select shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories, Count(score_shooter.shooter_soth_id) As cnt_match 
    From shooter_soth Left Join score_shooter On score_shooter.shooter_soth_id = shooter_soth.shooter_soth_id 
    Having Count(score_shooter.shooter_soth_id) > 0
    Group By shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories 
    Order By shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname";
    $sql = "Select shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories, Count(score_shooter.shooter_soth_id) As cnt_match 
    From shooter_soth Left Join score_shooter On score_shooter.shooter_soth_id = shooter_soth.shooter_soth_id Group By shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories ";
    $sql .= " Having Count(score_shooter.shooter_soth_id) = 0 ";
    $sql .= " Order By shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname";
    $data_array = $fnc->get_db_array($sql);
?>
    <div>
        <h1 class="fs-3 text-primary mt-5">Shooter List with SOTH ID</h1>
    </div>
    <div class="table-responsive-md">
        <table class="table table-primary table-striped">
            <thead class="">
                <tr>
                    <th scope="col" class="py-3">#</th>
                    <th scope="col" class="py-3">Key</th>
                    <th scope="col" class="py-3">IDPA ID</th>
                    <th scope="col" class="py-3">FULL NAME</th>
                    <th scope="col" class="py-3">CATEGORIES</th>
                    <th scope="col" class="py-3">MATCH</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 0;
                foreach ($data_array as $row) {
                    $x++;
                    if ($row['cnt_match'] == 0) {
                        echo '<tr class="text-warning">';
                    } else {
                        echo '<tr class="">';
                    }
                    echo '<td scope="row">' . $x . '</td>';
                    echo '<td><a href="?p=shooter&shooterId=' . $row['shooter_soth_id'] . '" target="shooter_view">' . $row['shooter_soth_id'] . '</a></td>';
                    echo '<td>' . $row['shooter_soth_idpa'] . '</td>';
                    echo '<td><a href="../admin/?p=shooter&fname=' . $row['shooter_soth_firstname'] . '&lname=' . $row['shooter_soth_lastname'] . '" target="shooter_view">' . $row['shooter_soth_firstname'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['shooter_soth_lastname'] . '</a></td>';
                    echo '<td>' . $row['shooter_soth_categories'] . '</td>';
                    echo '<td>' . $row['cnt_match'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>


<?php
}

function gen_shooter_list_del()
{
    global $fnc;
    $sql = "Select shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories, Count(score_shooter.shooter_soth_id) As cnt_match 
    From shooter_soth Left Join score_shooter On score_shooter.shooter_soth_id = shooter_soth.shooter_soth_id Group By shooter_soth.shooter_soth_id, shooter_soth.shooter_soth_idpa, shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname, shooter_soth.shooter_soth_categories 
    Having Count(score_shooter.shooter_soth_id) = 0 
    Order By shooter_soth.shooter_soth_firstname, shooter_soth.shooter_soth_lastname";
    $data_array = $fnc->get_db_array($sql);

    $sql_del = "";
    foreach ($data_array as $row) {
        $sql_del .= "DELETE FROM shooter_soth WHERE shooter_soth_id = '" . $row["shooter_soth_id"] . "'; ";
    }
    if ($_SESSION["member"]["auth_lv"] == 9) {
        // $fnc->sql_execute_multi($sql_del);
    }
    echo '<div class="table-responsive-md">
        <h1 class="mt-5 fs-2 text-primary">Duplicate Deleted</h1>
        </div>';
    print_r($sql_del);
}

function shooter_upload()
{
    global $fnc;
?>
    <div class="col-12 col-md-10 col-lg-8 mx-auto mt-4">
        <form action="../db_mgt.php?p=approve&act=csvupload" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="upload_file" class="form-label text-capitalize text-primary fw-bold">Upload Shooter List .CSV</label>
                <div class="input-group mb-3">
                    <input class="form-control" type="file" id="upload_file" name="upload_file" accept=".csv" required>
                    <button class="btn btn-outline-primary px-3" type="submit">Upload</button>
                </div>
                <input type="hidden" name="fst" value="csvupload">
            </div>
        </form>
        <a href="?p=verify&act=stat_csv" target="_top">โหลดจากระบบ STAT<br>>> <?= $fnc->get_db_col("SELECT match_name FROM match_idpa WHERE match_id = " . $_SESSION["member"]["setting"]["setting_match_active"]) ?></a>
    </div>
<?php
}

function shooter_approve($csv = '../uploads/approve/shooter_approve.csv')
{
    read_csv_file($csv, 0);
}

function read_csv_file($f_name, $tbl = NULL)
{
    $csv = array();
    $lines = file($f_name, FILE_IGNORE_NEW_LINES);
    $x = 0;
    foreach ($lines as $key => $value) {
        $csv[$key] = str_getcsv($value);
        $x++;
    }
    $x--;

    echo '</div><div class="mx-4">';
    echo '<p class="fs-5 fw-bold">read .csv file total ' . $x . ' shooters</p>';
    // echo '<p>' . $f_name . '</p>';
    if (!is_null($tbl) && $tbl >= 0) {
        echo '<table class="table table-striped table-bordered table-hover table-responsive mt-4">
<thead class="thead-inverse">
  <tr class="table-secondary text-center">';
        // foreach ($csv[0] as $val) {
        // for ($x=0; $x <= 16; $x++) {
        // echo '<th>' . $csv[0][$x] . '</th>';
        // }
        echo '<th>' . $csv[0][5] . '</th>';
        echo '<th>' . $csv[0][4] . '</th>';
        echo '<th>' . $csv[0][3] . '</th>';
        echo '<th>' . $csv[0][1] . '</th>';
        echo '<th>' . $csv[0][2] . '</th>';
        echo '<th class="table-info">' . 'History' . '</th>';
        echo '</tr>
  </thead>
    <tbody>';
        for ($i = 1; $i < count($csv); $i++) {
            echo '<tr>';
            if (empty($csv[$i][7])) {
                if (is_numeric(explode(' ', $csv[$i][3])[0])) {
                    $csv[$i][7] = explode(' ', $csv[$i][3])[0];
                    $csv[$i][3] = substr($csv[$i][3], 4);
                }
            }
            // foreach ($csv[$i] as $val) {
            // for ($x=0; $x <= 16; $x++) {
            //     echo '<td>' . $csv[$i][$x]  . '</td>';
            // }
            echo '<td class="text-center"><a href="?p=shooter&keysearch=' . $csv[$i][5] . '" target="ค้นหา นกฬ">' . $csv[$i][5] . '</a></td>';
            echo '<td><a href="?p=shooter&keysearch=' . $csv[$i][4] . '" target="ค้นหา นกฬ">' . $csv[$i][4] . '</a></td>';
            echo '<td><a href="?p=shooter&keysearch=' . $csv[$i][3] . '" target="ค้นหา นกฬ">' . $csv[$i][3] . '</a></td>';
            echo '<td class="text-center">' . $csv[$i][1] . '</td>';
            echo '<td class="text-center">' . $csv[$i][2] . '</td>';
            echo '<td class="table-info">';
            get_shooter_history($csv[$i][4], $csv[$i][3], $csv[$i][2]);
            echo '</td>';
            echo '</tr>';
            if ($tbl > 0 && $tbl <= $i) {
                exit;
            }
        }
        echo '</tbody>
    </table>';
    } else {

        echo '<pre>';
        print_r($csv);
        echo '</pre>';
        // die();
    }
    return $csv;
}

function get_shooter_history($fname, $lname, $cls)
{
    global $fnc;
    $cls_num = array("UN" => 0, "NV" => 1, "MM" => 2, "SS" => 3, "EX" => 4, "MA" => 5, "DM" => 6);
    if (isset($fname) && isset($lname)) {
        $sql = "Select score_shooter.*, match_idpa.match_begin, match_idpa.match_name, match_idpa.match_level, match_idpa.match_stages, match_idpa.match_rounds, match_idpa.match_md From score_shooter Inner Join match_idpa On match_idpa.match_id = score_shooter.match_id";
        $sql .= " Where score_shooter.shooter_firstName = '" . $fname . "' And score_shooter.shooter_lastName = '" . $lname . "'";
        $sql .= " Group By match_idpa.match_begin, match_idpa.match_name, match_idpa.match_level, match_idpa.match_stages, match_idpa.match_rounds, match_idpa.match_md, match_idpa.match_id Order By match_idpa.match_begin Desc";
    }

    $data_array = $fnc->get_db_array($sql);
    $history = "";
    if (!empty($data_array)) {
        foreach ($data_array as $row) {
            if ($history) {
                $history .= '<br>';
            }
            $history .= '<span class="m-0 p-0';
            if ($cls_num[$cls] < $cls_num[$row["shooter_class"]]) {
                $history .= ' text-danger fw-bold';
            }
            $history .= '" style="white-space: nowrap;">' . $row["shooter_division"] . ' / ' . $row["shooter_class"] . ' ' . $row["shooter_lastName"] . ' [' . $row["match_begin"] . '] ' . $row["match_name"];
            $history .= ' ' . $row["match_level"] . ' / ' . $row["match_stages"] . ' / ' . $row["match_rounds"];
            $history .= '</span>';
        }
        echo $history;
    }
}

?>

<head>
    <title>SOTH - Shooter</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
    <!-- Convert this to an external style sheet -->

</head>

<body style="background-color: #fff3df;">

    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-warning bg-gradient d-none">
        <div class="container-fluid">
            <a class="navbar-brand" href="./admin/">SOTH</a>
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
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- MD -</a>
                                    </li>
                                    <li><a class="dropdown-item" href="../member/?p=match&act=newmatch" target="_top">ลงทะเบียน
                                            Match</a></li>
                                    <li><a class="dropdown-item" href="../member/?p=match&act=sanction">Match ที่ขอจัดไว้</a>
                                    </li>
                                    <li><a class="dropdown-item" href="../member/?p=match&act=approved">Match ที่อนุมัติแล้ว</a>
                                    </li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 6 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- STAT -</a>
                                    </li>
                                    <li><a class="dropdown-item" href="../score/" target="_blank">ผลการแข่ง</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 7 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- ADMIN
                                            -</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=sanction" target="_top">Match ที่ขอจัด</a>
                                    </li>
                                    <li><a class="dropdown-item" href="../admin/?p=so">จัดการ SO</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=member">จัดการสมาชิก</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=match">จัดการ Match</a></li>
                                    <li><a class="dropdown-item" href="../admin/report.php?p=rpt&v=Trainnee&order=FULL%20NAME&sort=a">SO
                                            ที่ผ่านฝึกงาน</a></li>
                                    <li><a class="dropdown-item" href="../admin/shooter.php?p=shooter">ประวัติ นกฬ.</a></li>
                                    <li><a class="dropdown-item" href="../admin/report.php?p=rpt">รายงานระบบ</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 8 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <!-- <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- EDITOR -</a></li>
                                                                    <li><a class="dropdown-item" href="../admin/?p=so">จัดการ SO</a></li>
                                                                    <li><a class="dropdown-item" href="../admin/?p=match">จัดการ Match</a></li> -->
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- DEVELOPER
                                            -</a></li>
                                    <li><a class="dropdown-item" href="../admin/setting.php">การตั้งค่า</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../member/?p=jobs">การทำหน้าที่ SO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../member/?p=matchs">การแข่งขันทั้งหมด</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../member/?p=profile">โปรไฟล์ของฉัน</a>
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
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-warning bg-gradient">
        <div class="container-fluid">
            <a class="navbar-brand" href="./admin/">SOTH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?p=shooter">ค้นหา นกฬ.</a>
                    </li>
                    <?php if ($_SESSION["member"]["auth_lv"] >= 6) { ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="?p=approve">ตรวจสอบ นกฬ.</a>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION["member"]["auth_lv"] >= 9) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">สำหรับเจ้าหน้าที่</a>
                            <ul class="dropdown-menu box_shadow">
                                <!-- <li><a class="dropdown-item" href="../admin/?p=sanction" target="_top">Match ที่ขอจัด</a></li> -->
                                <?php if ($_SESSION["member"]["auth_lv"] >= 5 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- MD -</a>
                                    </li>
                                    <li><a class="dropdown-item" href="?p=shooterList" target="_top">ทะเบียน นกฬ.</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 6 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- STAT -</a>
                                    </li>
                                    <li><a class="dropdown-item" href="?p=syncShooter">ซิงค์ นกฬ.</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 7 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- ADMIN
                                            -</a></li>
                                    <li><a class="dropdown-item" href="?p=shooterList0" target="_top">นกฬ.
                                            ที่ไม่มีประวัติแข่ง</a></li>
                                    <li><a class="dropdown-item" href="?p=noShooterId">นกฬ. ไม่มีรหัส SOTH ID</a></li>
                                    <li><a class="dropdown-item" href="?p=genDb">นำเข้าข้อมูล นกฬ.</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 8 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <!-- <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- EDITOR -</a></li>
                                                                    <li><a class="dropdown-item" href="../admin/?p=so">จัดการ SO</a></li>
                                                                    <li><a class="dropdown-item" href="../admin/?p=match">จัดการ Match</a></li> -->
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- DEVELOPER
                                            -</a></li>
                                    <li><a class="dropdown-item" href="?p=shooterListDel">ลบข้อมูลที่ซ้ำซ้อน</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
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

            if ($_SESSION["member"]["auth_lv"] >= 5) {
                // shooter_admin_menu();
                switch ($_GET["p"]) {
                    case "syncShooter":
                        gen_sync_shooter_soth_db($_GET["mid"]);
                        break;
                    case "genDb":
                        gen_shooter_soth_db($_GET["mid"]);
                        break;
                    case "shooterList":
                        gen_shooter_list();
                        break;
                    case "shooterList0":
                        gen_shooter_list0();
                        break;
                    case "shooterListDel":
                        gen_shooter_list_del();
                        break;
                    case "shooter":
                        if ((isset($_GET["fname"]) && isset($_GET["lname"])) || isset($_GET["shooterId"])) {
                            $fnc->shooter_info();
                        } else {
                            // $fnc->so_admin_menu();
                            $fnc->shooter_list();
                        }
                        break;
                    case "approve":
                        if (isset($_GET["act"]) && $_GET["act"] == 'uploaded') {
                            shooter_approve();
                        } else {
                            shooter_upload();
                        }
                        break;
                    case "verify":
                        $file_csv = '../' . $fnc->get_db_col("SELECT match_csv_file FROM match_idpa WHERE match_id = " . $_SESSION["member"]["setting"]["setting_match_active"]);
                        // echo $file_csv;
                        shooter_approve($file_csv);
                        break;
                    case "noShooterId":
                        gen_none_shooter_id();
                        break;
                }
            }

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>

    <?php
    include('../sweet_alert.php');
    ?>

</body>

</html>