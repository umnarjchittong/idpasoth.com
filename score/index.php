<!doctype html>
<?php
include("../core.php");
if (empty($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] < 6) {
    //   echo '<meta http-equiv="refresh" content="0;url=../sign/signout.php?p=no-right">';
    die('<meta http-equiv="refresh" content="0;url=../sign/signout.php?p=no-right">');
    //   die();
} else {
    $fnc = new web;
    if ($_SESSION["member"]["auth_lv"] >= 9) {
        $fnc->system_debug = $_SESSION["member"]["setting"]["setting_debug_show"];
        $fnc->system_alert = $_SESSION["member"]["setting"]["setting_alert"];
        $fnc->system_meta_redirect = $_SESSION["member"]["setting"]["setting_meta_redirect"];
        // $fnc->database_sample = $_SESSION["member"]["setting"]["setting_db_name"];
    }
    $fnc->debug_console("member info", $_SESSION["member"]);
}

$mid = $_SESSION["member"]["setting"]["setting_match_active"];
if (isset($_GET["mid"]) && $_GET["mid"] != "") {
    $mid = $_GET["mid"];
}
// $file_csv = "../uploads/score/GLOCKShootingDay12020.csv";

function read_csv_file($f_name, $tbl = NULL)
{
    $csv = array();
    $lines = file('../' . $f_name, FILE_IGNORE_NEW_LINES);
    $x = 0;
    foreach ($lines as $key => $value) {
        $csv[$key] = str_getcsv($value);
        $x++;
    }
    $x--;

    echo "read .csv file total " . $x . " records";
    if (!is_null($tbl) && $tbl >= 0) {
        echo '<table class="table table-striped table-bordered table-hover table-responsive mt-4">
<thead class="thead-inverse">
  <tr class="table-secondary text-center">';
        foreach ($csv[0] as $val) {
            echo '<th>' . $val . '</th>';
        }
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
            foreach ($csv[$i] as $val) {
                echo '<td>' . $val . '</td>';
            }
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

function read_csv_file_2OK($f_name, $tbl = false)
{
    $csv = array();
    $lines = file('../' . $f_name, FILE_IGNORE_NEW_LINES);
    $x = 0;
    foreach ($lines as $key => $value) {
        $csv[$key] = str_getcsv($value);
        $x++;
    }
    $x--;

    echo "read .csv file total " . $x . " records";
    if ($tbl) {
        echo '<table class="table table-striped table-bordered table-hover table-responsive mt-4">
<thead class="thead-inverse">
  <tr class="table-secondary text-center">';
        foreach ($csv[0] as $val) {
            echo '<th>' . $val . '</th>';
        }
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
            foreach ($csv[$i] as $val) {
                echo '<td>' . $val . '</td>';
            }
            echo '</tr>';
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

function update_shooter_csv_string($f_name, $match_id) // for more string
{
    global $fnc;

    $csv = array();
    $data = array();
    $title = array();
    $lines = file('../' . $f_name, FILE_IGNORE_NEW_LINES);
    $x = 0;
    foreach ($lines as $key => $value) {
        $csv[$key] = str_getcsv($value);
        $x++;
    }
    $x--;

    echo "read .csv file total " . $x . " records";
    $script_running = '';

    $stg = array(1 => 20, 2 => 29, 3 => 38, 4 => 47, 5 => 56, 6 => 65, 7 => 74, 8 => 83, 9 => 92, 10 => 101, 11 => 110, 12 => 119, 13 => 128, 14 => 137, 15 => 146);
    $stg_first = 20;

    $stg_number = 1;
    $x = 0;
    foreach ($csv[0] as $csv_header) {
        $title[$x] = $csv_header;
        $x++;
    }

    for ($r = 1; $r < (count($csv)); $r++) {
        $x = 0;
        $string_title = "";
        $string_time = 0;
        for ($c = 0; $c < (count($title)); $c++) {
            if (strpos($title[$c], "String")) {
                if (strpos($title[$c], "String 1")) {
                    $string_title = $title[$c];
                    // $string_time += $csv[$r][$c];
                    do {
                        $string_time += $csv[$r][$c];
                        $script_running .= "<br>&nbsp; &nbsp; &nbsp; S_$c : $title[$c] = " . $csv[$r][$c];
                        $c++;
                    } while (strpos($title[$c], "String"));
                    // echo "<br>" . $string_title . " (";
                    // $csv[$r][$x] = $string_time;
                    // $c--;
                    $data[$r][$x] = $string_time;
                    $script_running .=  "<br>Z_$x : $string_title = " . $string_time;
                    $x++;
                }
                // if (is_numeric($csv[$r][$c])) {
                //     $string_time += $csv[$r][$c];
                // }
                // echo $csv[$r][$c] . ", ";                
                // if ($string_time > 0) {
                //     $data[$r][$x] = $string_time;
                // } else {
                //     $data[$r][$x] = $csv[$r][$c];
                // }
                $data[$r][$x] = $csv[$r][$c];
                $script_running .=  "<br>A_$x : $title[$c] = " . $csv[$r][$c];
                $x++;
            } else {
                if ($string_time > 0) {
                    // $data[$r][$x . '+' . $string_title] = $string_time;
                    $data[$r][$x] = $string_time;
                    // echo ") total = " . $string_time;
                    $string_title = "";
                    $string_time = 0;
                    // $x++;
                    // echo "<hr>C = $c, X = $x<hr>";
                } else {
                    // $data[$r][$x] = "";
                    // echo ") total = " . "";
                    // $string_title = "";
                    // $string_time = 0;
                    // $x++;
                }
                // $data[$r][$x . '-' . $title[$c]] = $csv[$r][$c];
                $data[$r][$x] = $csv[$r][$c];
                $script_running .=  "<br>B_$x : $title[$c] = " . $csv[$r][$c];
                $x++;
            }
        }
        $csv[$r] = $data[$r];
    }
    // ** view script running
    // echo $script_running;

    // ** view csv data
    // echo "<hr><pre>";
    // print_r($csv[1]);
    // echo "</pre>";
    // die();

    $sql_insert = "";
    $script_sql = '';
    $x_insert = 0;
    $x_update = 0;
    $fnc->sql_execute("DELETE FROM `score_stage` WHERE `match_id` = " . $match_id);
    $fnc->sql_execute("DELETE FROM `score_shooter` WHERE `match_id` = " . $match_id);
    $score_stage_id = $fnc->get_db_col("SELECT max(score_stage_id) as last_id FROM `score_stage` ORDER BY `score_stage_id` DESC");
    $shooter_id = $fnc->get_db_col("SELECT max(shooter_id) as last_id FROM score_shooter ORDER BY shooter_id DESC");
    for ($i = 1; $i < (count($csv)); $i++) {
        // clear old data;
        if (empty($csv[$i][7])) {
            if (is_numeric(explode(' ', $csv[$i][3])[0])) {
                $csv[$i][7] = explode(' ', $csv[$i][3])[0];
                $csv[$i][3] = substr($csv[$i][3], 4);
            }
        }
        $score_stage_id++;
        $sql_insert = "INSERT INTO `score_shooter` (`shooter_id`, `match_id`, `shooter_place`, `shooter_division`, `shooter_class`, `shooter_lastName`, `shooter_firstName`, `shooter_idpa`, `shooter_location`, `shooter_number`, `shooter_squad`, `shooter_session`, `shooter_completed`, `shooter_DNF`, `shooter_categories`, 
      `shooter_total_score`, `shooter_PD`, `shooter_HNT`, `shooter_PE`, `shooter_FTDR`, `shooter_FP`, `shooter_finger_PE`) 
      VALUES ('" . $score_stage_id . "', '" . $match_id . "', '" . $csv[$i][0] . "', '" . $csv[$i][1] . "', '" . $csv[$i][2] . "', '" . $csv[$i][3] . "', '" . $csv[$i][4] . "', '" . $csv[$i][5] . "', '" . $csv[$i][6] . "', '" . $csv[$i][7] . "', '" . $csv[$i][8] . "', '" . $csv[$i][9] . "', '" . $csv[$i][10] . "', '" . $csv[$i][11] . "', '" . $csv[$i][12] . "', 
      '" . $csv[$i][13] . "', '" . $csv[$i][14] . "', '" . $csv[$i][15] . "', '" . $csv[$i][16] . "', '" . $csv[$i][17] . "', '" . $csv[$i][18] . "', '" . $csv[$i][19] . "')";
        $sql_insert = str_replace("''", "NULL", $sql_insert);
        //   die($sql_insert);
        $fnc->sql_execute($sql_insert);
        $script_sql .= "<hr><strong>#" . ($x_insert + 1) . " shooter insert: </strong>" . $csv[$i][4] . " " . $csv[$i][3] . "<br>Added";
        $shooter_id = $fnc->get_last_id("score_shooter", "shooter_id");
        // * if has score in stage #
        if ($shooter_id) {
            $sql_stage_insert = "";
            for ($k = 1; $k < count($stg); $k++) {
                if (isset($csv[$i][$stg[$k]]) && $stg[$k] < (count($csv[$i]) - 1)) {
                    // if ($csv[$i][($stg[$k] + 8)] == 1) {
                    $score_stage_id++;
                    if ($csv[$i][($stg[$k])] == "") {
                        $sql_stage_insert .= "INSERT INTO `score_stage` (`score_stage_id`, `score_shooter_id`, `match_id`, `score_stage_number`, `score_stage_DNF`) 
                        VALUES ('" . $score_stage_id . "', '" . $shooter_id . "', '" . $match_id . "', '" . $k . "', '1'); ";
                        $script_sql .= '<br>DNF:' . $csv[$i][($stg[$k] + 8)] . ' - ' . $sql_stage_insert . '<br>';
                        $script_sql .= ' Stage #' . $k . ',';
                        // $k= $k-1;
                    } else {
                        $sql_stage_insert .= "INSERT INTO `score_stage` (`score_stage_id`, `score_shooter_id`, `match_id`, `score_stage_number`, `score_stage_time`, `score_stage_string_1`, `score_stage_PD`, `score_stage_HNT`, `score_stage_PE`, `score_stage_FTDR`, `score_stage_FP`, `score_stage_finger_PE`, `score_stage_DNF`) 
        VALUES ('" . $score_stage_id . "', '" . $shooter_id . "', '" . $match_id . "', '" . $k . "', '" . $csv[$i][($stg[$k])] . "', '" . $csv[$i][($stg[$k] + 1)] . "', '" . $csv[$i][($stg[$k] + 2)] . "', '" . $csv[$i][($stg[$k] + 3)] . "', '" . $csv[$i][($stg[$k] + 4)] . "', '" . $csv[$i][($stg[$k] + 5)] . "', '" . $csv[$i][($stg[$k] + 6)] . "', '" . $csv[$i][($stg[$k] + 7)] . "', '" . $csv[$i][($stg[$k] + 8)] . "'); ";
                        $script_sql .= '<br>FINISH:' . $csv[$i][($stg[$k] + 8)] . ' - ' . $sql_stage_insert . '<br>';
                        // $script_sql .= "k=" . $k . ", stgk1=" . ($stg[$k] + 1) . "<br>";
                        $script_sql .= ' Stage #' . $k . ',';
                    }
                }
            }
            // $script_sql .= $sql_insert;
            $script_sql .= '<br>Added stage info : <strong class="text-success">completed</strong>';
            // print_r($sql_stage_insert);
            // sql_stage_insert
            $sql_stage_insert = str_replace("''", "NULL", $sql_stage_insert);
            // $script_sql .= '<hr><br>' . $sql_stage_insert;
            // ! break
            $fnc->sql_execute_multi($sql_stage_insert);
            $sql_insert = "";

            // * view script sql
            // echo "<pre>";
            // print_r($script_sql);
            // echo "</pre>";
        }

        $x_insert++;
    }
    // $fnc->sql_execute_multi($sql_insert);
    echo "<hr>Added All " . $x_insert . " records<br>";
    // $fnc->sql_execute_multi($sql_update);
    // echo $sql_insert;
}

function update_shooter_csv($f_name, $match_id)
{
    // update_shooter_csv_string($f_name, $match_id);
    // die();

    global $fnc;

    $csv = array();
    $lines = file('../' . $f_name, FILE_IGNORE_NEW_LINES);
    $x = 0;
    foreach ($lines as $key => $value) {
        $csv[$key] = str_getcsv($value);
        $x++;
    }
    $x--;

    echo "read .csv file total " . $x . " records";

    $stg = array(1 => 20, 2 => 29, 3 => 38, 4 => 47, 5 => 56, 6 => 65, 7 => 74, 8 => 83, 9 => 92, 10 => 101, 11 => 110, 12 => 119, 13 => 128, 14 => 137, 15 => 146);
    //   $stg = array(1 => 20, 2 => 29, 3 => 38, 4 => 47, 5 => 56, 6 => 65, 7 => 74, 8 => 83, 9 => 92, 10 => 101);
    $sql_insert = "";
    $x_insert = 0;
    $x_update = 0;
    $fnc->sql_execute("DELETE FROM `score_stage` WHERE `match_id` = " . $match_id);
    $fnc->sql_execute("DELETE FROM `score_shooter` WHERE `match_id` = " . $match_id);
    for ($i = 1; $i < (count($csv)); $i++) {
        // clear old data;
        if (empty($csv[$i][7])) {
            if (is_numeric(explode(' ', $csv[$i][3])[0])) {
                $csv[$i][7] = explode(' ', $csv[$i][3])[0];
                $csv[$i][3] = substr($csv[$i][3], 4);

                // if (strlen($csv[$i][7]) < 3) {
                //   do {
                //     $csv[$i][7] = "0" . $csv[$i][7];
                //   } while (strlen($csv[$i][7]) < 3);
                // }
            }
        }
        $sql_insert = "INSERT INTO `score_shooter` (`match_id`, `shooter_place`, `shooter_division`, `shooter_class`, `shooter_lastName`, `shooter_firstName`, `shooter_idpa`, `shooter_location`, `shooter_number`, `shooter_squad`, `shooter_session`, `shooter_completed`, `shooter_DNF`, `shooter_categories`, 
      `shooter_total_score`, `shooter_PD`, `shooter_HNT`, `shooter_PE`, `shooter_FTDR`, `shooter_FP`, `shooter_finger_PE`) 
      VALUES ('" . $match_id . "', '" . $csv[$i][0] . "', '" . $csv[$i][1] . "', '" . $csv[$i][2] . "', '" . $csv[$i][3] . "', '" . $csv[$i][4] . "', '" . $csv[$i][5] . "', '" . $csv[$i][6] . "', '" . $csv[$i][7] . "', '" . $csv[$i][8] . "', '" . $csv[$i][9] . "', '" . $csv[$i][10] . "', '" . $csv[$i][11] . "', '" . $csv[$i][12] . "', 
      '" . $csv[$i][13] . "', '" . $csv[$i][14] . "', '" . $csv[$i][15] . "', '" . $csv[$i][16] . "', '" . $csv[$i][17] . "', '" . $csv[$i][18] . "', '" . $csv[$i][19] . "')";
        $sql_insert = str_replace("''", "NULL", $sql_insert);
        //   die($sql_insert);
        $fnc->sql_execute($sql_insert);
        echo "<hr><strong>#" . ($x_insert + 1) . " shooter insert: </strong>" . $csv[$i][4] . " " . $csv[$i][3] . "<br>Added";
        $shooter_id = $fnc->get_last_id("score_shooter", "shooter_id");
        // * if has score in stage #
        if ($shooter_id) {
            $sql_stage_insert = "";
            for ($k = 1; $k < count($stg); $k++) {
                if (isset($csv[$i][$stg[$k]]) && $stg[$k] < (count($csv[$i]) - 1)) {
                    $sql_stage_insert .= "INSERT INTO `score_stage` (`score_shooter_id`, `match_id`, `score_stage_number`, `score_stage_time`, `score_stage_string_1`, `score_stage_PD`, `score_stage_HNT`, `score_stage_PE`, `score_stage_FTDR`, `score_stage_FP`, `score_stage_finger_PE`, `score_stage_DNF`) 
        VALUES ('" . $shooter_id . "', '" . $match_id . "', '" . $k . "', '" . $csv[$i][($stg[$k])] . "', '" . $csv[$i][($stg[$k] + 1)] . "', '" . $csv[$i][($stg[$k] + 2)] . "', '" . $csv[$i][($stg[$k] + 3)] . "', '" . $csv[$i][($stg[$k] + 4)] . "', '" . $csv[$i][($stg[$k] + 5)] . "', '" . $csv[$i][($stg[$k] + 6)] . "', '" . $csv[$i][($stg[$k] + 7)] . "', '" . $csv[$i][($stg[$k] + 8)] . "'); ";
                    echo '<br>' . $sql_stage_insert . '<br>';
                    echo ' Stage #' . $k . ',';
                }
            }
            // echo $sql_insert;
            echo '<br>Added stage info : <strong class="text-success">completed</strong>';
            // print_r($sql_stage_insert);
            // sql_stage_insert
            $sql_stage_insert = str_replace("''", "NULL", $sql_stage_insert);
            // echo '<hr><br>' . $sql_stage_insert;
            $fnc->sql_execute_multi($sql_stage_insert);
        }

        $x_insert++;
    }
    // $fnc->sql_execute_multi($sql_insert);
    echo "<hr>Added All " . $x_insert . " records<br>";
    // $fnc->sql_execute_multi($sql_update);
    // echo $sql_insert;
}

// function read_csv_file1($f_name)
// {
//   $csv = array();
//   $lines = file('../' . $f_name, FILE_IGNORE_NEW_LINES);

//   foreach ($lines as $key => $value) {
//     $csv[$key] = str_getcsv($value);
//   }

//   echo '<pre>';
//   print_r($csv);
//   echo '</pre>';
// }

// function read_csv_file2($f_name)
// {
//   $csv = array();
//   $file = fopen('../' . $f_name, 'r');

//   while (($result = fgetcsv($file)) !== false) {
//     $csv[] = $result;
//   }

//   fclose($file);

//   echo '<pre>';
//   print_r($csv);
//   echo '</pre>';
// }

function view_shooter_list($mid)
{
    global $fnc;
    $sql_order = "";
    if (isset($_GET["filter"]) && $_GET["filter"] != "") {
        $filter = explode(",", $_GET["filter"]);
    }
    // print_r($data_array);
?>
    <table class="table table-striped table-bordered table-hover table-responsive mt-4">
        <thead class="thead-inverse">
            <tr class="table-secondary text-center">
                <th class="text-center"><?php $sql_order .= $fnc->table_header_sorting("NO.", "shooter_num", $sql_order); ?></th>
                <th class="text-start"><?php $sql_order .= $fnc->table_header_sorting("Name", "shooter_firstName", $sql_order); ?></th>
                <!-- <th><?php // $sql_order .= $fnc->table_header_sorting("Division", "shooter_division", $sql_order); 
                            ?></th> -->
                <!-- <th><?php // $sql_order .= $fnc->table_header_sorting("Class", "shooter_class", $sql_order); 
                            ?></th> -->
                <th><?php $sql_order .= $fnc->table_header_sorting("SQ", "shooter_sqd", $sql_order); ?></th>
                <th><?php $sql_order .= $fnc->table_header_sorting("Division/Class", "shooter_division", $sql_order); ?></th>
                <th><?php $sql_order .= $fnc->table_header_sorting("Categories", "shooter_categories", $sql_order); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT *,left(shooter_lastName,3) as shooter_num, Cast(shooter_squad As Int) as shooter_sqd FROM `score_shooter` WHERE `match_id` = " . $mid . " ORDER BY shooter_number";
            if (isset($sql_order)) {
                $sql .= $sql_order;
            }
            // echo $sql;
            $data_array = $fnc->get_db_array($sql);
            if (($data_array)) {
                foreach ($data_array as $row) {
                    echo '<tr class="';
                    if (isset($filter) && $filter[0] == $row["shooter_firstName"] && $filter[1] == $row["shooter_lastName"]) {
                        echo 'text-warning fs-5 fw-bold bg-dark';
                    }
                    echo '">';
                    echo '<td class="text-center">' . $row["shooter_number"] . '</td>';
                    // echo '<td class="text-start" nowarp style="white-space: nowrap;"><a href="?p=shooterscore&mid=' . $mid . '&uid=' . $row["shooter_id"] . '" target="_blank">' . $row["shooter_firstName"] .  '&nbsp;&nbsp;&nbsp;&nbsp;' . $row["shooter_lastName"] . '</a></td>';
                    // echo '<td class="text-start" nowarp style="white-space: nowrap;">' . $row["shooter_firstName"] .  '&nbsp;&nbsp;&nbsp;&nbsp;' . $row["shooter_lastName"] . '</td>';
                    echo '<td class="text-start" nowarp style="white-space: nowrap;"><a href="../admin/?p=shooter&fname=' . $row["shooter_firstName"] . '&lname=' . $row["shooter_lastName"] . '" target="shooter_view">' . $row["shooter_firstName"] .  '&nbsp;&nbsp;&nbsp;&nbsp;' . $row["shooter_lastName"] . '<i class="bi bi-person-badge ms-2"></i></a></td>';
                    // echo '<td class="text-center">' . $row["shooter_division"] . '</td>';
                    // echo '<td class="text-center">' . $row["shooter_class"] . '</td>';
                    echo '<td class="text-center">' . $row["shooter_squad"] . '</td>';
                    echo '<td class="text-center">' . $row["shooter_division"] . ' / ' . $row["shooter_class"] . '</td>';
                    echo '<td class="text-center">' . $row["shooter_categories"] . '</td>';
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

        function gen_result_table($mid, $sql)
        {
            global $fnc;
            ?>
            <table class="table table-striped table-bordered table-hover table-responsive mt-3 mb-4">
                <thead class="thead-inverse">
                    <tr class="table-secondary text-center">
                        <th>Place</th>
                        <?php if (isset($_GET["v"]) && $_GET["v"] != "divisionclass") {
                            if (isset($_GET["v"]) && $_GET["v"] != "division") { ?>
                                <th>Division</th>
                            <?php } ?>
                            <th>Class</th>
                        <?php } ?>
                        <th class="text-start">Shooter Name</th>
                        <th>SQT</th>
                        <th>Categories</th>
                        <th>Total Score</th>
                        <th>PD</th>
                        <th>HNT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // echo $sql;
                    $data_array = $fnc->get_db_array($sql);
                    if (isset($_GET["filter"]) && $_GET["filter"] != "") {
                        $filter = explode(",", $_GET["filter"]);
                    }
                    if (($data_array)) {
                        $x_row = 1;
                        foreach ($data_array as $row) {
                            $shooter_fullname = $row["shooter_firstName"] .  '&nbsp;&nbsp;&nbsp;&nbsp;' . $row["shooter_lastName"];
                            echo '<tr class="';
                            if (isset($filter) && $filter[0] == $row["shooter_firstName"] && $filter[1] == $row["shooter_lastName"]) {
                                echo 'text-warning fs-5 fw-bold bg-dark';
                                $shooter_fullname = '<strong class="text-warning fs-5">' . $shooter_fullname . '</strong>';
                            }
                            echo '">';
                            echo '<td scope="row" class="text-center">' . $x_row . '</td>';
                            if (isset($_GET["v"]) && $_GET["v"] != "divisionclass") {
                                if (isset($_GET["v"]) && $_GET["v"] != "division") {
                                    echo '<td class="text-center">' . $row["shooter_division"] . '</td>';
                                }
                                echo '<td class="text-center">' . $row["shooter_class"] . '</td>';
                            }
                            // echo '<td class="text-start"><a href="../guest/myscore.php?mid=' . $mid . '&uid=' . $row["shooter_number"] . '" target="_blank">' . $row["shooter_lastName"] .  '&nbsp;&nbsp;&nbsp;&nbsp;' . $row["shooter_firstName"] . '</a></td>';


                            echo '<td class="text-start"><a href="../shooter/?uid=' . $row["shooter_number"] . '&mid=' . $mid . '&act=shooterview&admin=' . $_SESSION['member']["auth_lv"] . '" target="_blank">' . $shooter_fullname . '</a></td>';
                            echo '<td class="text-center">' . $row["shooter_squad"] . '</td>';
                            echo '<td class="text-center">' . $row["shooter_categories"] . '</td>';
                            echo '<td class="text-center">' . $row["shooter_total_score"] . '</td>';
                            echo '<td class="text-center">' . $row["shooter_PD"] . '</td>';
                            echo '<td class="text-center">' . $row["shooter_HNT"] . '</td>';
                            echo '</tr>';
                            $x_row++;
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

                function gen_breakdown2($mid)
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

                    echo '<div class="col-6">';
                    echo '<table class="table table-striped table-inverse table-responsive table-bordered">
                                        <thead class="thead-inverse">';
                    echo '
                                            <tr>
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

                    echo '<div class="col-3">';
                    echo '<table class="table table-striped table-inverse table-responsive table-bordered">
                                        <thead class="thead-inverse">';
                    echo '
                                            <tr>
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

                    echo '<div class="col-3">';
                    echo '<table class="table table-striped table-inverse table-responsive table-bordered">
                                        <thead class="thead-inverse">';
                    echo '
                                            <tr>
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

                function gen_match_dropdown_list()
                {
                    global $fnc;
                    if ($_SESSION["member"]["auth_lv"] >= 5) {
                        $match_list = $fnc->get_db_array("SELECT match_id, match_name, match_begin FROM `match_idpa` WHERE match_status = 'enable' ORDER BY match_begin DESC LIMIT 10");
                        echo '<div class="dropdown mt-2 mb-3 col-12 col-md-10 col-lg-8 mx-auto">
                        <a class="btn btn-secondary dropdown-toggle w-100" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          เลือกแมทช์อื่น
                        </a>
                      
                        <ul class="dropdown-menu dropdown-menu-dark">';
                        foreach ($match_list as $match) {
                            echo '
                            <li><a class="dropdown-item" href="?p=' . $_GET["p"] . '&mid=' . $match["match_id"] . '">' . $match["match_begin"] . ' - ' . $match["match_name"] . '</a></li>';
                        }

                        echo '</ul>
                        </div>';
                    }
                }


                ?>
                <html lang="en">

                <head>
                    <title>SOTH - STAT Manager</title>
                    <!-- Required meta tags -->
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <link rel="icon" type="image/x-icon" href="/images/favicon.png">

                    <!-- Bootstrap CSS -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

                    <link rel="stylesheet" href="../css/style.css">
                    <!-- Convert this to an external style sheet -->

                </head>

                <body style="background-color:#FFF;">

                    <?php if ($_SESSION["member"]["auth_lv"] >= 6) { ?>
                        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-success bg-gradient">
                            <div class="container-fluid">
                                <a class="navbar-brand text-white fw-bold" href="../score/?p=home&mid=<?= $mid ?>">SOTH</a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarCollapse">
                                    <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize">
                                        <!-- <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="?">home</a>
                  </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="?p=upload&mid=<?= $mid ?>">อัพโหลไฟล์</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="?p=readcsv&mid=<?= $mid ?>">อ่านข้อมูลไฟล์</a>
                                        </li>

                                        <!-- <li class="nav-item">
            <a class="nav-link" href="?p=matchs">matchs list</a>
          </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="?p=showscore&mid=<?= $mid ?>">เปิด-ปิด ผลการแข่ง</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="?p=qrcode&mid=<?= $mid ?>">QR Code</a>
                                        </li>
                                        <?php
                                        if ($_SESSION["member"]["auth_lv"] >= 5) {
                                            echo '<li class="nav-item">
                                            <a class="nav-link" href="../admin/result.php?mid=' . $mid . '" target="_blank">Results (MD)</a>
                                            </li>';
                                        } else {
                                            echo '<li class="nav-item">
                                            <a class="nav-link" href="../result/?v=overall&mid=' . $mid . '" target="_blank">Results</a>
                                            </li>';
                                        }
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="../score/?p=breakdown&mid=<?= $mid ?>" target="_blank">Break Down</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="../sign/signout.php?p=signout">ออกจากระบบ</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    <?php } ?>


                    <main class="flex-shrink-0">
                        <div class="container col-12">
                            <?php

                            // read_csv_file1("../uploads/score/TPSCGunMeetingDay.csv");

                            if (isset($_GET["p"]) && $_GET["p"] != "") {
                                switch ($_GET["p"]) {
                                    case "upload":
                                        // $csv = read_csv_file("../uploads/score/TPSCGunMeetingDay_sample.csv");
                                        // update_shooter_csv($file_csv, 10);
                                        gen_match_dropdown_list();
                                        echo '<div class="col-12 col-md-10 col-lg-8 mx-auto box_shadow">';
                                        $match_info = $fnc->match_info($mid);
                                        echo '</div>';
                            ?>

                                        <div class="col-12 col-md-10 col-lg-8 mx-auto mt-5">
                                            <div class="row">
                                                <div class="col-auto text-start">
                                                    <a href="?p=reload&mid=<?= $mid ?>" target="_top" class="btn btn-success px-3 text-capitalize">reload .CSV<br>to Database</a>
                                                </div>
                                                <div class="col align-self-center" style="white-space: nowrap;">
                                                    <?php
                                                    $filename = explode("/", $match_info["match_csv_file"]);
                                                    ?>
                                                    <strong>File : </strong><?= end($filename) ?>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-12 col-md-10 col-lg-8 mx-auto mt-4">
                                            <form action="../db_mgt.php?p=result&act=csvupload"method="post" enctype="multipart/form-data">
                                                <div class="mb-3">
                                                    <label for="upload_file" class="form-label text-capitalize text-primary fw-bold">Upload New .CSV</label>
                                                    <div class="input-group mb-3">
                                                        <input class="form-control" type="file" id="upload_file" name="upload_file" accept=".csv" required>
                                                        <button class="btn btn-outline-primary px-3" type="submit">Upload</button>
                                                    </div>
                                                    <input type="hidden" name="fst" value="csvupload">
                                                    <input type="hidden" name="m_id" value="<?= $mid ?>">
                                                </div>
                                            </form>
                                        </div>
                                        <?php
                                        if (isset($_GET["v"]) && $_GET["v"] == "readcsv") {
                                            read_csv_file($match_info["match_csv_file"], 5);
                                        }
                                        break;
                                    case "showscore":
                                        // $csv = read_csv_file("../uploads/score/TPSCGunMeetingDay_sample.csv");
                                        if ($_SESSION["member"]["auth_lv"] >= 5) {
                                            if (!$fnc->get_db_col("SELECT * FROM `match_setting` WHERE match_id = $mid")) {
                                                $fnc->sql_execute("INSERT INTO `match_setting`(`match_id`) VALUES (" . $mid . ")");
                                            }
                                        }
                                        gen_match_dropdown_list();
                                        echo '<div class="col-12 col-md-10 col-lg-8 mx-auto box_shadow">';
                                        $fnc->match_info($mid);
                                        echo '</div>';
                                        echo '<div class="mt-5 text-center mb-5">';
                                        $view_result = $fnc->get_db_row("SELECT match_id, match_active, shooter_result, match_result, match_active as setting_match_active, shooter_result as setting_view_result, match_result as setting_match_result FROM `match_setting` WHERE match_id = $mid");
                                        // $view_result = $fnc->get_db_array("SELECT `setting_id`, `setting_view_result`, `setting_match_result` FROM `settings` ORDER BY `setting_id` Desc LIMIT 1")[0];
                                        $fnc->debug_console("view result: ", $view_result);
                                        $btn_active_color = ' bi-toggle2-off text-secondary';
                                        $btn_score_color = ' bi-toggle2-off text-secondary';
                                        $btn_result_color = ' bi-toggle2-off text-secondary';
                                        $btn_active_action = 'openview';
                                        $btn_score_action = 'openview';
                                        $btn_result_action = 'openview';

                                        echo '<div class="col-12 col-md-10 col-lg-8 py-3 row mx-auto box_shadow">';
                                        if ($view_result["match_active"] == 'true') {
                                            $btn_active_color = ' bi-toggle2-on text-primary';
                                            $btn_active_action = 'closeview';
                                        }
                                        echo '
                                            <div class="col-3 text-center pe-3 py-3">
                                                <a href="../db_mgt.php?p=matchactive&act=' . $btn_active_action . '&mid=' . $view_result["match_id"] . '" target="_top" class=""><i class="bi' . $btn_active_color . ' fs-1"></i></a>
                                            </div>';
                                        echo '
                                            <div class="col-9 align-self-center fs-5 text-start">
                                            เปิดใช้งานแมทช์
                                            </div>';

                                        if ($view_result["shooter_result"] == 'true') {
                                            $btn_score_color = ' bi-toggle2-on text-primary';
                                            $btn_score_action = 'closeview';
                                        }
                                        echo '
                                            <div class="col-3 text-center pe-3 py-3">
                                            <a href="../db_mgt.php?p=viewresult&act=' . $btn_score_action . '&mid=' . $view_result["match_id"] . '" target="_top" class=""><i class="bi' . $btn_score_color . ' fs-1"></i></a>
                                            </div>';
                                        echo '
                                            <div class="col-9 align-self-center fs-5 text-start">
                                            การแสดงผลคะแนน นกฬ.
                                            </div>';

                                            if ($view_result["match_result"] == 'true') {
                                                $btn_result_color = ' bi-toggle2-on text-primary';
                                                $btn_result_action = 'closeview';
                                            }
                                        echo '
                                            <div class="col-3 text-center pe-3 py-3">
                                            <a href="../db_mgt.php?p=matchresult&act=' . $btn_result_action . '&mid=' . $view_result["match_id"] . '" target="_top" class=""><i class="bi' . $btn_result_color . ' fs-1"></i></a>
                                            </div>';
                                        echo '
                                            <div class="col-9 align-self-center fs-5 text-start">
                                            การแสดงผลการแข่งขัน Match
                                            </div>';
                                        echo '</div>';

                                        echo '<hr class="mt-5">';
                                        if ($view_result["shooter_result"] == 'true') {
                                            $result_lbl = '<strong class="text-primary h1">เปิด</strong>';
                                            $result_btn = '<a href="../db_mgt.php?p=viewresult&act=closeview&mid=' . $view_result["match_id"] . '" target="_top" class="btn btn-lg btn-secondary text-uppercase mt-4 px-5">CLOSE</a>';
                                            // $result_btn = '<a href="../db_mgt.php?p=viewresult&act=closeview&mid=' . $view_result["match_id"] . '" target="_top" class="mt-4 px-5"><i class="bi bi-toggle2-on fs-1"></i></a>';
                                        } else {
                                            $result_lbl = '<strong class="text-danger h1">ปิด</strong>';
                                            $result_btn = '<a href="../db_mgt.php?p=viewresult&act=openview&mid=' . $view_result["match_id"] . '" target="_top" class="btn btn-lg btn-success text-uppercase mt-4 px-5">OPEN</a>';
                                        }
                                        echo '<div class="h3">ขณะนี้ ' . $result_lbl . ' การแสดงผลคะแนนแล้ว</div>';
                                        echo $result_btn;


                                        echo '<hr class="my-4">';

                                        if ($view_result["match_result"] == 'true') {
                                            $result_lbl = '<strong class="text-primary h1">เปิด</strong>';
                                            $result_btn = '<a href="../db_mgt.php?p=matchresult&act=closeview&mid=' . $view_result["match_id"] . '" target="_top" class="btn btn-lg btn-secondary text-uppercase mt-4 px-5">CLOSE</a>';
                                        } else {
                                            $result_lbl = '<strong class="text-danger h1">ปิด</strong>';
                                            $result_btn = '<a href="../db_mgt.php?p=matchresult&act=openview&mid=' . $view_result["match_id"] . '" target="_top" class="btn btn-lg btn-success text-uppercase mt-4 px-5">OPEN</a>';
                                        }
                                        echo '<div class="h3">ขณะนี้ ' . $result_lbl . ' การแสดง Match Over All แล้ว</div>';
                                        echo $result_btn;

                                        echo '</div>';

                                        break;
                                    case "reload":
                                        // $csv = read_csv_file("../uploads/score/TPSCGunMeetingDay_sample.csv");
                                        gen_match_dropdown_list();
                                        echo '<div class="col-12 col-md-10 col-lg-8 mx-auto box_shadow">';
                                        $match_info = $fnc->match_info($mid);
                                        echo '</div>';
                                        // update_shooter_csv($match_info["match_csv_file"], $mid);
                                        update_shooter_csv_string($match_info["match_csv_file"], $mid);
                                        break;
                                    case "viewshooter":
                                        // echo '<div class="mt-4 mb-2 text-end"><a class="btn btn-primary px-3 me-3" href="?p=viewshooter&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view shooters</a><a class="btn btn-info px-3 me-3" href="?p=viewbreakdown&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view match breakdown</a><a class="btn btn-success px-3" href="?p=viewresult&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view match result</a></div>';
                                        gen_match_dropdown_list();
                                        echo '<div class="mt-4 mb-2 text-end"><a class="btn btn-info px-3 me-3" href="?p=viewbreakdown&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view match breakdown</a><a class="btn btn-success px-3" href="?p=viewresult&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view match result</a></div>';
                                        echo '<div class="col-12 mb-4">';
                                        $fnc->match_info($mid);
                                        echo '</div>';
                                        echo '<div class="my-4">&nbsp;</div>';
                                        view_shooter_list($mid);
                                        echo '<div class="my-2">&nbsp;</div>';
                                        break;
                                    case "shooterscore":
                                        gen_match_dropdown_list();
                                        $fnc->match_info($mid);
                                        if (isset($_GET["uid"])) {
                                            shooter_info($mid, $_GET["uid"]);
                                        }
                                        echo '<div class="my-2">&nbsp;</div>';
                                        break;
                                    case "viewbreakdown":
                                        gen_match_dropdown_list();
                                        echo '<div class="mt-4 mb-2 text-end"><a class="btn btn-primary px-3 me-3" href="?p=viewshooter&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view shooters</a><a class="btn btn-success px-3" href="?p=viewresult&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view match result</a></div>';
                                        echo '<div class="col-12 mb-4">';
                                        $fnc->match_info($mid);
                                        echo '</div>';
                                        echo '<div class="my-4">&nbsp;</div>';
                                        $fnc->gen_breakdown($mid);
                                        echo '<div class="my-2">&nbsp;</div>';
                                        break;
                                    case "viewresult":
                                        gen_match_dropdown_list();
                                        echo '<div class="mt-4 mb-2 text-end"><a class="btn btn-info px-3 me-3" href="?p=viewbreakdown&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view match breakdown</a><a class="btn btn-primary px-3 me-3" href="?p=viewshooter&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view shooters</a></div>';
                                        echo '<div class="col-12 mb-4">';
                                        $fnc->match_info($mid);
                                        echo '</div>';
                                        echo '<div class="my-4">&nbsp;</div>';
                                        echo '<h3>Match Result: Division / Class</h3>';
                                        // $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division Order By scsh.shooter_division";
                                        $sql = "Select scsh.shooter_division From score_shooter scsh Where scsh.shooter_division <> '' And scsh.match_id = " . $mid . " Group By scsh.shooter_division ORDER BY CASE WHEN shooter_division = 'SSP' THEN 1 WHEN shooter_division = 'ESP' THEN 2 WHEN shooter_division = 'CDP' THEN 3 WHEN shooter_division = 'CCP' THEN 4 WHEN shooter_division = 'BUG' THEN 5 WHEN shooter_division = 'REV' THEN 6 WHEN shooter_division = 'CO' THEN 7 WHEN shooter_division = 'PCC30' THEN 8 WHEN shooter_division = 'PCC-30' THEN 9 WHEN shooter_division = 'PCC-SMG' THEN 10 WHEN shooter_division = 'PCC10' THEN 11 WHEN shooter_division = 'PCC-10' THEN 12 WHEN shooter_division = 'PCC-RIFLE' THEN 13 WHEN shooter_division = 'SPD' THEN 14 ELSE 15 END ASC";
                                        $division = $fnc->get_db_array($sql);
                                        foreach ($division as $div) {
                                            $sql = "Select scsh.shooter_class From score_shooter scsh Where scsh.shooter_place >= 1 AND scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.match_id = " . $mid . " Group By scsh.shooter_class ORDER BY CASE WHEN shooter_class = 'MA' THEN 2 WHEN shooter_class = 'EX' THEN 3 WHEN shooter_class = 'SS' THEN 4 WHEN shooter_class = 'MM' THEN 5 WHEN shooter_class = 'NV' THEN 6 WHEN shooter_class = 'UN' THEN 7 WHEN shooter_class = 'ALL' THEN 8 ELSE 10 END ASC";
                                            $class = $fnc->get_db_array($sql);
                                            foreach ($class as $cls) {
                                                echo '<div class="h5 mt-4 mb-1">' . $div["shooter_division"] . " / " . $cls["shooter_class"] . '</div>';

                                                $sql = "Select * From score_shooter scsh Where scsh.shooter_place >= 1 AND scsh.shooter_division = '" . $div["shooter_division"] . "' And scsh.shooter_class = '" . $cls["shooter_class"] . "' And scsh.match_id = " . $mid;
                                                if (isset($sql_order)) {
                                                    $sql .= $sql_order;
                                                }
                                                echo '<div style="font-size: 0.9em;">';
                                                gen_result_table($mid, $sql);
                                                echo '</div>';
                                            }
                                            echo '<hr class="mx-auto" style="color: #1271fd; width: 50vw; height: 4px; margin-bottom:65px;">';
                                        }
                                        echo '<div class="my-2">&nbsp;</div>';
                                        break;
                                    case "matchinfo":
                                        if (isset($mid)) {
                                            if ($_SESSION["member"]["auth_lv"] >= 9) {
                                                $fnc->match_admin_menu();
                                            }
                                            $fnc->match_detail($mid);
                                        }
                                        break;
                                    case "home":

                                        gen_match_dropdown_list();
                                        echo '<div class="mt-4 mb-2 text-end"><a class="btn btn-primary px-3 me-3" href="?p=viewshooter&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view shooters</a><a class="btn btn-info px-3 me-3" href="?p=viewbreakdown&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view match breakdown</a><a class="btn btn-success px-3" href="?p=viewresult&mid=' . $mid . '&filter=' . $_GET['filter'] . '" role="button">view match result</a></div>';

                                        $fnc->match_info($mid);
                                        break;
                                    case "readcsv":
                                        gen_match_dropdown_list();
                                        echo '<div class="col-12 col-md-10 col-lg-8 mx-auto box_shadow">';
                                        $match_info = $fnc->match_info($mid);
                                        echo '</div>';
                                        read_csv_file($match_info["match_csv_file"], 0);
                                        break;
                                    case "qrcode":
                                        gen_match_dropdown_list();
                                        echo '<div class="col-12 col-md-10 col-lg-8 mx-auto box_shadow">';
                                        $match_info = $fnc->match_info($mid);
                                        echo '</div>
                    ';

                                        $fnc->gen_qrcode_page();

                                        break;
                                    case "breakdown":
                                        // echo '<div><a href="../docs/breakdown.jpg" target="_blank">sample photo</a></div>';

                                        // gen_breakdown($mid)
                                        gen_match_dropdown_list();
                                        $fnc->match_info($mid);
                                        echo '<div class="my-5"></div>';
                                        $fnc->gen_breakdown($mid)
                                        ?>







                            <?php
                                        die();
                                        break;
                                }
                            } else {
                                //                     echo '
                                // <div class="alert alert-warning alert-dismissible fade show" role="alert">';
                                //                     echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                //                     echo '<h3 class="mt-5 mb-3">อัพโหลดผลการแข่งขัน</h3>';
                                //                     echo '<p class="h6 ps-3">1. หลังจาก นกฬ. ลงทะเบียนครบถ้วน STAT ทำการ Master Export เป็นไฟล์ .CSV และอัพโหลดข้อมูลสู่เว็บไซต์ เพื่อให้ นกฬ. ได้ตรวจเช็คข้อมูลการลงทะเบียน</p>';
                                //                     echo '<p class="h6 ps-3">2. หลังจากสิ้นสุดการแข่งขัน STAT ทำการ Master Export เป็นไฟล์ .CSV และอัพโหลดข้อมูลสู่เว็บไซต์ เพื่อให้ นกฬ. ตรวจสอบผลการแข่งขันของตัวเอง</p>';
                                //                     echo '</div>';
                                gen_match_dropdown_list();
                                echo '<div class="col-12 col-md-10 col-lg-8 mx-auto box_shadow">';
                                $fnc->match_info($mid);
                                echo '</div>';
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
                        gtag(' js', new Date());
                        gtag('config', 'G-VVZW40KL0H');
                    </script>

                    <!-- Bootstrap JS -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

                    <?php
                    include('../sweet_alert.php');
                    ?>

                    <? //php require __DIR__ . '/../policy/cookies-consent.php'; 
                    ?>

                </body>

                </html>