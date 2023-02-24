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

function report_admin_menu()
{
?>
    <div class="container bg-gradient pt-2 text-end d-print-none" style="background-color: #d8d8d8; font-size: 0.75em;">
        <ul class="nav justify-content-end text-capitalize">
            <li class="nav-item align-self-center fw-bold">
                New Registered:
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="?p=rpt&v=newRegister&order=Register&sort=z">New Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="?p=rpt&v=newSO&order=Register&sort=z">New SO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="?p=rpt&v=Trainnee&order=FULL%20NAME&sort=a">Trainnee SO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="?p=rpt&v=newMatch&order=Register&sort=z">New Match</a>
            </li>
        </ul>
        <ul class="nav justify-content-end text-capitalize">
            <li class="nav-item align-self-center fw-bold">
                IDPA MEMBER:
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="?p=rpt&v=notmember&order=Register&sort=z">Not Member</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="?p=rpt&v=expired&order=IDPA%20EXPIRE&sort=a">Expired</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="?p=rpt&v=exp3month&order=IDPA%20EXPIRE&sort=a">Expiring in 3 month</a>
            </li>
        </ul>
    </div>
<?php
}

function so_list_rpt($rpt_type = "")
{
    global $fnc;
    $sql_order = NULL;

    $sql = "SELECT * FROM `so_member` WHERE ";
    if (isset($_GET["v"]) && $_GET["v"] == "newRegister") {
        // $newSO = ", so_regis_datetime Desc";
        $sql .= "`so_status` = 'register'";
        $rpt_title = "SO สมัครสมาชิกใหม่ ยังไม่ได้ยืนยันตัวตน";
    }
    if (isset($_GET["v"]) && $_GET["v"] == "newSO") {
        // $newSO = ", so_regis_datetime Desc";
        $sql .= "`so_status` = 'enable'";
        $rpt_title = "SO ที่ลงทะเบียนล่าสุด";
    }
    if (isset($_GET["v"]) && $_GET["v"] == "Trainnee") {
        // $newSO = ", so_regis_datetime Desc";
        $sql .= "`so_status` = 'enable' AND `so_level` LIKE '%ฝึก%'";
        $rpt_title = "SO ฝึกหัด/ฝึกงาน";
    }
    if (isset($_GET["v"]) && $_GET["v"] == "newMatch") {    // $sql .= " AND `so_idpa_id` = ''";

        $rpt_title = "Match ที่รายงานผลล่าสุด";
    }
    if (isset($_GET["v"]) && $_GET["v"] == "notmember") {
        $sql .= " `so_status` = 'enable' And (`so_idpa_id` is NULL OR LENGTH(`so_idpa_id`) <= 4)";
        $rpt_title = "SO ที่ลงทะเบียน แต่ยังไม่เป็น IDPA Member";
    }
    if (isset($_GET["v"]) && $_GET["v"] == "expired") {
        $sql .= " `so_idpa_expire` != '' AND `so_idpa_expire` <= current_timestamp()";
        $rpt_title = "SO IDPA Member ที่หมดอายุแล้ว";
    }
    if (isset($_GET["v"]) && $_GET["v"] == "exp3month") {
        $sql .= " `so_idpa_expire` > current_timestamp() AND `so_idpa_expire` <= '" . date("Y-m-d", strtotime("+3 Months")) . "'";
        $rpt_title = "SO IDPA Member ที่กำลังจะหมดอายุใน 3 เดือน";
    }
    if (isset($_GET["p"]) && $_GET["p"] == "idpaExpr") {
        $sql .= " AND `so_idpa_id` <> ''";
    }
    if (isset($_GET["keysearch"]) && $_GET["keysearch"] != "") {
        $sql .= " AND (`so_idpa_id` LIKE '" . $_GET["keysearch"] . "' OR `so_firstname` LIKE '%" . $_GET["keysearch"] . "%' OR `so_lastname` LIKE '%" . $_GET["keysearch"] . "%' OR `so_firstname_en` LIKE '%" . $_GET["keysearch"] . "%' OR `so_lastname_en` LIKE '%" . $_GET["keysearch"] . "%' OR `so_nickname` LIKE '" . $_GET["keysearch"] . "' OR `so_email` LIKE '%" . $_GET["keysearch"] . "%')";
    }

?>
    <div class="container mb-4">
        <div class="row">
            <div class="col-12 col-md-8">
                <h4 class="text-primary text-uppercase mt-4"><strong><?= $rpt_title ?></strong></h4>
            </div>
            <div class="col align-self-end text-end pt-md-4">
                <form action="?" method="get">
                    <div class="input-group input-group-sm">
                        <input type="hidden" name="p" value="<?= $_GET["p"]; ?>">
                        <?php
                        if (isset($_GET["v"]) && $_GET["v"] != "") {
                            echo '<input type="hidden" name="v" value="' . $_GET["v"] . '">';
                        }
                        ?>
                        <input type="text" class="form-control" name="keysearch" placeholder="ระบุ idpa id, ชื่อ หรืออีเมล" <?php {
                                                                                                                                if (isset($_GET["keysearch"]) && $_GET["keysearch"] != "") echo ' value="' . $_GET['keysearch'] . '"';
                                                                                                                            } ?> aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="bi bi-search me-2"></i>ค้นหา</button>
                    </div>
                </form>

            </div>
        </div>
        <div>
            <p class="text-mute my-0 py-0" style="font-size: 0.75em;">คลิกหมายเลข idpa เพื่อแสดงข้อมูลสมาชิก idpa.com / คลิกชื่อ เพื่อแสดงรายละเอียดและประวัติการทำงาน / คลิกหัวข้อตารางเพื่อเรียงลำดับ</p>
        </div>
        <table class="table table-light table-striped table-hover">
            <thead>
                <tr class="table-primary">
                    <th class="d-none d-md-table-cell"><?php $sql_order .= table_header_sorting("IDPA ID", "so_idpa_id", $sql_order); ?></th>
                    <th><?php $sql_order .= table_header_sorting("FULL NAME", "so_firstname_en", $sql_order); ?></th>
                    <th class="d-none d-lg-table-cell"><?php $sql_order .= table_header_sorting("SO LEVEL", "so_level", $sql_order); ?></th>
                    <th><?php $sql_order .= table_header_sorting("IDPA EXPIRE", "so_idpa_expire", $sql_order); ?></th>
                    <th><?php $sql_order .= table_header_sorting("SO EXPIRE", "so_license_expire", $sql_order); ?></th>
                    <th class="d-none d-lg-table-cell"><?php $sql_order .= table_header_sorting("Register", "so_regis_datetime	", $sql_order); ?></th>
                    <!-- <th><?php //$sql_order .= table_header_sorting("LINE ID", "so_line_id", $sql_order); 
                                ?></th> -->
                    <th class="text-end d-none d-md-table-cell">
                        <!-- <div><a href="?p=so&act=soadd" target="_top" class="btn btn-primary text-uppercase w-100"><i class="bi bi-person-plus-fill"></i></a></div> -->
                    </th>
                    <!-- <th>IDPA Expr</th> -->
                </tr>
            </thead>
            <tbody style="font-size: 0.9em;">
                <?php
                if (isset($sql_order)) {
                    $sql .= $sql_order;
                }
                $sql .= " Limit 30";
                $fnc->debug_console("table so list:", $sql);
                $so_array = $fnc->get_db_array($sql);
                if (!empty($so_array)) {
                    foreach ($so_array as $row) {
                        echo '<tr';
                        if ($_GET["v"] == "Trainnee") {
                            $sql_cnt_on_duty = "SELECT count(`on_duty_id`) as cnd_on_duty FROM `on_duty` WHERE `on_duty_status` = 'enable' AND `so_id` = " . $row["so_id"];
                            $cnt_on_duty = $fnc->get_db_col($sql_cnt_on_duty);
                            if ($cnt_on_duty < 2) {
                                echo ' class="d-none"';
                            }
                        }
                        echo '>
                                <td scope="row" class="d-none d-md-table-cell"><a href="https://www.idpa.com/members/' . $row["so_idpa_id"] . '" target="_blank">' . $row["so_idpa_id"] . '</a></td>
                                <td>';
                        echo '<p class="d-block d-md-none m-0 fw-bold"><a href="https://www.idpa.com/members/' . $row["so_idpa_id"] . '" target="_blank">' . $row["so_idpa_id"] . '</a></p>';
                        echo '<p class="m-0"><a href="../admin/?p=soinfo&soid=' . $row["so_id"] . '" target="_top">' . $row["so_firstname_en"] . ' ' . $row["so_lastname_en"] . '</a></p>';

                        echo '<p class="m-0">' . $row["so_firstname"] . ' ' . $row["so_lastname"] . ' (' . $row["so_nickname"] . ')</p></td>';
                        echo '<td class="d-none d-lg-table-cell">' . $row["so_level"];
                        if ($_GET["v"] == "Trainnee") {
                            echo '<br>' . 'ทำงาน ' . $cnt_on_duty . ' ครั้ง';
                        }
                        echo '</td>';
                        echo '<td>';
                        if ($row["so_idpa_expire"]) {
                            echo date("M d, Y", strtotime($row["so_idpa_expire"]));
                        }
                        echo '</td>';
                        echo '<td>';
                        if ($row["so_license_expire"]) {
                            echo date("M d, Y", strtotime($row["so_license_expire"]));
                        }
                        echo '</td>
                                <td class="d-none d-lg-table-cell">' . date("M d, Y", strtotime($row["so_regis_datetime"])) . '</td>';
                        echo '<td class="text-center d-none d-md-table-cell">';
                        if ($_GET["v"] == "newRegister") {
                            echo '<a href="../db_mgt.php?p=so&act=approved&soid=' . $row["so_id"] . '" target="_top" class="link-primary"><i class="bi bi-person-circle"></i></a>';
                        } else {
                            echo '<a href="../admin/?p=so&act=soedit&soid=' . $row["so_id"] . '" target="_blank" class="link-warning"><i class="bi bi-pencil-square"></i></a>';
                        }
                        echo '<a href="../db_mgt.php?p=so&&act=sodelete&soid=' . $row["so_id"] . '" target="_top" class="link-danger ps-2">' . '<i class="bi bi-trash-fill"></i>' . '</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="8" class="text-center">SO not founded.</td></tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
<?php
}

function table_header_sorting($label, $col_name, $sql_order = NULL)
{
    // $sql_order = NULL;
    if (isset($_GET["order"]) && $_GET["order"] == $label) {
        if (isset($_GET["sort"]) && $_GET["sort"] == "z") {
            $sql_order = " ORDER BY " . $col_name . " DESC";
            echo '<a href="?p=' . $_GET["p"] . '&v=' . $_GET["v"] . '&order=' . $label . '&sort=a" target="_top">' . $label . ' <i class="bi bi-sort-down"></i>' . '</a>';
        } else {
            echo '<a href="?p=' . $_GET["p"] . '&v=' . $_GET["v"] . '&order=' . $label . '&sort=z" target="_top">' . $label . ' <i class="bi bi-sort-down-alt"></i>' . '</a>';
            $sql_order = " ORDER BY " . $col_name . " ASC";
        }
        return $sql_order;
    } else {
        echo '<a href="?p=' . $_GET["p"] . '&v=' . $_GET["v"] . '&order=' . $label . '&sort=a" target="_top">' . $label . '</a>';
    }
}

function match_list_rpt($rpt_type = "")
{
    global $fnc;
    $sql_order = NULL;
    if (isset($_GET["year"]) && strlen($_GET["year"]) == 4) {
        $sql_year = " AND year(match_begin) = '" . $_GET["year"] . "'";
    } else {
        $sql_year = "";
    }
    if (isset($_GET["filter"]) && isset($_GET["key"])) {
        $sql_filter = " AND " . $_GET["filter"] . " Like '%" . $_GET["key"] . "%'";
    } else {
        $sql_filter = "";
    }
?>
    <div class="mt-4 mb-3">
        <div class="row">
            <div class="col">
                <h4 class="text-primary text-uppercase"><strong>รายชื่อ Match ในระบบฐานข้อมูล <?= "(" . $fnc->get_db_col("SELECT count(`match_id`) as cnt_so FROM `match_idpa` WHERE `match_status` = 'enable'" . $sql_year . $sql_filter) . " รายการ)"; ?></strong></h4>
            </div>
            <div class="col-5 col-md-3 col-lg-2 align-self-end text-end">
                <form action="?p=match" method="get">
                    <?php
                    if (isset($_GET['order'])) {
                        echo '<input type="hidden" name="order" value="' . $_GET['order'] . '">';
                    }
                    if (isset($_GET['sort'])) {
                        echo '<input type="hidden" name="sort" value="' . $_GET['sort'] . '">';
                    }
                    echo '<input type="hidden" name="p" value="' . $_GET['p'] . '">';
                    $sql = "Select Year(maid.match_begin) As yrs From `match_idpa` maid Group By Year(maid.match_begin) Order By yrs Desc";
                    $match_year = $fnc->get_db_array($sql);
                    echo '<select name="year" class="form-select form-select-sm" aria-label="Default select example" onchange="this.form.submit();">';
                    echo '<option';
                    if (!isset($_GET["year"]) || strlen($_GET["year"]) != 4) {
                        echo ' selected';
                    }
                    echo ' value="">แสดงทั้งหมด</option>';
                    foreach ($match_year as $yrs) {
                        echo '<option value="' . $yrs["yrs"] . '"';
                        if (isset($_GET["year"]) && $_GET["year"] == $yrs["yrs"]) {
                            echo ' selected';
                        }
                        echo '>แสดงปี ' . $yrs["yrs"] . '</option>';
                    }
                    ?>
                    </select>
                </form>
            </div>
        </div>
        <table class="table table-light table-striped table-hover">
            <thead>
                <tr class="table-primary">
                    <th><?php $sql_order .= table_header_sorting("DATE", "match_begin", $sql_order); ?></th>
                    <th><?php $sql_order .= table_header_sorting("TITLE", "match_name", $sql_order); ?></th>
                    <th class="text-center"><?php $sql_order .= table_header_sorting("LEVEL", "match_level", $sql_order); ?></th>
                    <th class="text-center"><?php $sql_order .= table_header_sorting("STAGES", "match_stages", $sql_order); ?></th>
                    <th class="d-none d-lg-table-cell"><?php $sql_order .= table_header_sorting("MD", "match_md", $sql_order); ?></th>
                    <th class="d-none d-lg-table-cell"><?php $sql_order .= table_header_sorting("Register", "match_regist_datetime", $sql_order); ?></th>
                    <!-- <th>IDPA Expr</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `match_idpa` WHERE `match_status` = 'enable'" . $sql_year . $sql_filter;
                if (!empty($sql_order)) {
                    $sql .= $sql_order;
                } else {
                    $sql .= ' Order by match_begin Desc';
                }
                $fnc->debug_console("table match list:", $sql);
                $dataset = $fnc->get_db_array($sql);
                if (!empty($dataset)) {
                    foreach ($dataset as $row) {
                        echo '<tr>
                                        <td scope="row" style="font-size:0.8em;">' . date("M d, Y", strtotime($row["match_begin"])) . '</td>';
                        if (isset($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] >= 3) {
                            if (isset($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] >= 5) {
                                echo '<td><a href="?p=matchinfo&mid=' . $row["match_id"] . '" target="_top">' . $row["match_name"] . '</a></td>';
                            } else {
                                echo '<td><a href="../guest/matchinfo.php?mid=' . $row["match_id"] . '" target="_blank">' . $row["match_name"] . '</a></td>';
                            }
                        } else {
                            echo '<td>' . $row["match_name"] . '</td>';
                        }
                        echo '<td class="text-center">' . $row["match_level"] . '</td>
                                        <td class="text-center">' . $row["match_stages"] . '</td>
                                        <td class="d-none d-lg-table-cell">' . $row["match_md"] . '</td>
                                        <td class="d-none d-lg-table-cell">' . date("M d, Y", strtotime($row["match_regist_datetime"])) . '</td>
                                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-center py-3">NO DATA</td></tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
<?php
}

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
    <h3 class="mt-4"><?= $year; ?> IDPA's Matchs Schedule by SOTH</h3>
    <table class="table table-striped table-bordered table-hover able-inverse table-responsive">
        <thead class="thead-inverse table-primary">
            <tr>
                <th class="text-center text-uppercase" style="width:7em;">Date</th>
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
    <title>SOTH - Admin Report</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
    <!-- Convert this to an external style sheet -->

</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SOTH</a>
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
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- MD -</a></li>
                                    <li><a class="dropdown-item" href="../member/?p=match&act=newmatch" target="_top">ลงทะเบียน Match</a></li>
                                    <li><a class="dropdown-item" href="../member/?p=match&act=sanction">Match ที่ขอจัดไว้</a></li>
                                    <li><a class="dropdown-item" href="../member/?p=match&act=approved">Match ที่อนุมัติแล้ว</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 6 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- STAT -</a></li>
                                    <li><a class="dropdown-item" href="../score/" target="_blank">ผลการแข่ง</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 7 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- ADMIN -</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=sanction" target="_top">Match ที่ขอจัด</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=so">จัดการ SO</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=member">จัดการสมาชิก</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=match">จัดการ Match</a></li>
                                    <li><a class="dropdown-item" href="../admin/report.php?p=rpt&v=Trainnee&order=FULL%20NAME&sort=a">SO ที่ผ่านฝึกงาน</a></li>
                                    <li><a class="dropdown-item" href="../admin/report.php?p=rpt">รายงานระบบ</a></li>
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] >= 8 || $_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <!-- <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- EDITOR -</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=so">จัดการ SO</a></li>
                                    <li><a class="dropdown-item" href="../admin/?p=match">จัดการ Match</a></li> -->
                                <?php } ?>
                                <?php if ($_SESSION["member"]["auth_lv"] == 9) { ?>
                                    <li><a class="dropdown-item disabled fw-bold text-center text-primary" href="#">- DEVELOPER -</a></li>
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


    <main class="flex-shrink-0">
        <div class="container">
            <?php

            if (isset($_GET["p"]) && $_GET["p"] == "rpt") {
                if ($_SESSION["member"]["auth_lv"] >= 7) {
                    report_admin_menu();
                }
                if (isset($_GET["v"]) && $_GET["v"] != "") {
                    switch ($_GET["v"]) {
                        case "newRegister":
                            so_list_rpt($_GET["p"]);
                            break;
                        case "newSO":
                            so_list_rpt($_GET["p"]);
                            break;
                        case "Trainnee":
                            so_list_rpt($_GET["p"]);
                            break;
                        case "newMatch":
                            match_list_rpt($_GET["p"]);
                            break;
                        case "idpaExpr":
                            so_list_rpt($_GET["p"]);
                            break;
                        case "notmember":
                            so_list_rpt($_GET["p"]);
                            break;
                        case "expired":
                            so_list_rpt($_GET["p"]);
                            break;
                        case "exp3month":
                            so_list_rpt($_GET["p"]);
                            break;
                    }
                }
            } elseif (isset($_GET["p"]) && $_GET["p"] == "schedule") {
                if (isset($_GET["y"])) {
                    $y = $_GET["y"];
                } else {
                    $y = date("Y");
                }
                schedule_table("all", $y);
            } else {
            ?>
                <h1 class="mt-5">Reports</h1>
                <p class="lead">Coming soon...</p>
            <?php
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <?php
    include('../sweet_alert.php');
    ?>

</body>

</html>