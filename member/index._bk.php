<!doctype html>
<html lang="en">
<?php
include('../core.php');
if (empty($_SESSION["member"])) {
    echo '<meta http-equiv="refresh" content="0;url=../sign/signout.php?p=no-right">';
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

// * so on duty table show position order by priority
function so_on_duty($so_id)
{
    global $fnc;
?>
    <div class="mt-4 mb-3">
        <h4 class="text-primary text-uppercase mt-4"><strong>ประวัติการทำงาน</strong></h4>
        <!-- <div class="card"> -->
        <div class="card-body p-0">
            <table class="table table-striped table-bordered table-hover table-responsive">
                <?php
                $sql = "Select v_on_duty.match_id, v_on_duty.match_name, v_on_duty.match_level, v_on_duty.match_begin, v_on_duty.`on-duty_position` From v_on_duty Where v_on_duty.so_id = " . $so_id . " Order By v_on_duty.match_begin Desc";
                $fnc->debug_console("on duty table: ", $sql);
                $dataset = $fnc->get_db_array($sql);
                ?>
                <thead class="thead-inverse">
                    <tr class="table-success">
                        <th class="text-center">#</th>
                        <th class="text-center">DATE</th>
                        <th>MATCH TITLE</th>
                        <th class="text-center">POSITION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (is_array($dataset)) {
                        $x = 1;
                        foreach ($dataset as $row) {
                            echo '<tr>
                                    <td scope="row" class="text-center">' . $x . '</td>
                                    <td class="text-center">' . date("d M Y", strtotime($row["match_begin"])) . '</td>
                                    <td><a href="?p=matchinfo&mid=' . $row["match_id"] . '" target="_TOP">' . $row["match_name"] . ' (' . $row["match_level"] . ')' . '</a></td>
                                    <td class="text-center">' . $row["on-duty_position"] . '</td>';
                            echo '</tr>';
                            $x++;
                        }
                    } else {
                        echo '<tr>
                                <td scope="row" colspan="4" class="text-center py-3">No Data</td>
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <!-- </div> -->
    </div>
<?php
}

function table_header_sorting($label, $col_name, $sql_order = NULL)
{
    // $sql_order = NULL;
    if (isset($_GET["order"]) && $_GET["order"] == $label) {
        if (isset($_GET["sort"]) && $_GET["sort"] == "z") {
            $sql_order = " ORDER BY " . $col_name . " DESC";
            echo '<a href="?p=' . $_GET["p"] . '&order=' . $label . '&sort=a" target="_top">' . $label . ' <i class="bi bi-sort-down"></i>' . '</a>';
        } else {
            echo '<a href="?p=' . $_GET["p"] . '&order=' . $label . '&sort=z" target="_top">' . $label . ' <i class="bi bi-sort-down-alt"></i>' . '</a>';
            $sql_order = " ORDER BY " . $col_name . " ASC";
        }
        return $sql_order;
    } else {
        echo '<a href="?p=' . $_GET["p"] . '&order=' . $label . '&sort=a" target="_top">' . $label . '</a>';
    }
}

function match_list()
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
                <h4 class="text-primary text-uppercase"><strong>รายชื่อ Match ในระบบฐานข้อมูล <?= "(" . $fnc->get_db_col("SELECT count(`match_id`) as cnt_so FROM `match-idpa` WHERE `match_status` = 'enable'" . $sql_year . $sql_filter) . " รายการ)"; ?></strong></h4>
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
                    $sql = "Select Year(maid.match_begin) As yrs From `match-idpa` maid Group By Year(maid.match_begin) Order By yrs Desc";
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
                    <th class="d-none d-lg-table-cell"><?php $sql_order .= table_header_sorting("CONTACT", "match_md_contact", $sql_order); ?></th>
                    <!-- <th>IDPA Expr</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable'" . $sql_year . $sql_filter;
                if (isset($sql_order)) {
                    $sql .= $sql_order;
                }
                $fnc->debug_console("table match list:", $sql);
                $dataset = $fnc->get_db_array($sql);
                if ($dataset) {
                    foreach ($dataset as $row) {
                        echo '<tr>
                                    <td scope="row" style="font-size:0.8em;">' . date("d M Y", strtotime($row["match_begin"])) . '</td>
                                    <td><a href="?p=matchinfo&mid=' . $row["match_id"] . '" target="_top">' . $row["match_name"] . '</a></td>
                                    <td class="text-center">' . $row["match_level"] . '</td>
                                    <td class="text-center">' . $row["match_stages"] . '</td>
                                    <td class="d-none d-lg-table-cell">' . $row["match_md"] . '</td>
                                    <td class="d-none d-lg-table-cell">' . $row["match_md_contact"] . '</td>
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

function match_detail($m_id)
{
    global $fnc;
?>
    <div class="container mb-4">
        <div class="row">
            <div class="col">
                <h4 class="text-primary text-uppercase mt-4"><strong><a href="index.php?p=matchs" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>Match Information</strong></h4>
            </div>
            <div class="container">
                <?php
                $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
                $row = $fnc->get_db_row($sql);
                $fnc->debug_console("match info sql: ", $sql);
                $fnc->debug_console("match info: ", $row);

                match_info($m_id);
                ?>

                <?php
                so_on_duty_table($m_id);
                ?>

            </div>

        </div>
    <?php
}

function so_on_duty_table($m_id)
{
    global $fnc;
    $sql_order = NULL;
    ?>
        <div class="mt-4 mb-3">
            <table class="table table-striped table-bordered table-hover table-responsive">
                <thead class="thead-inverse">
                    <tr class="table-primary">
                        <th>#</th>
                        <th>IDPA ID</th>
                        <th>NAME</th>
                        <?php
                        if (isset($_GET["p"]) && $_GET["p"] == "duty") {
                            echo '<th colspan="2">POSITION</th>';
                        } else {
                            echo '<th>POSITION</th>';
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_order = NULL;
                    $sql = "Select v_on_duty.`on-duty_id`, v_on_duty.so_id, v_on_duty.so_idpa_id, v_on_duty.so_firstname, v_on_duty.so_lastname, v_on_duty.so_firstname_en, v_on_duty.so_lastname_en, v_on_duty.so_nickname, v_on_duty.`on-duty_priority`, v_on_duty.`on-duty_position`, v_on_duty.`on-duty_notes` From v_on_duty Where v_on_duty.`on-duty_status` = 'enable' And v_on_duty.match_id = " . $m_id . " order by v_on_duty.`on-duty_priority`, v_on_duty.`on-duty_position`, v_on_duty.`so_firstname`";
                    $fnc->debug_console("on duty table: ", $sql);
                    $dataset = $fnc->get_db_array($sql);
                    if (is_array($dataset)) {
                        $x = 1;
                        foreach ($dataset as $row) {
                            echo '<tr>
                                            <td scope="row">' . $x . '</td>
                                            <td>' . $row["so_idpa_id"] . '</td>
                                            <td>' . $row["so_firstname"] . ' ' . $row["so_lastname"] . ' (' . $row["so_nickname"] . ')' . '</td>
                                            <td>' . $row["on-duty_position"] . '</td>';
                            if (isset($_GET["p"]) && $_GET["p"] == "duty") {
                                echo '<td class="text-center d-none d-md-table-cell">' . '<a href="?p=duty&mid=' . $m_id . '&act=dutyedit&odid=' . $row["on-duty_id"] . '" target="_top" class="link-warning"><i class="bi bi-pencil-square"></i></a>' . '<a href="?p=duty&mid=' . $m_id . '&act=dutydelete&odid=' . $row["on-duty_id"] . '" target="_top" class="link-danger ps-3">' . '<i class="bi bi-trash-fill"></i>' . '</a></td>';
                            }
                            echo '</tr>';
                            $x++;
                        }
                    } else {
                        echo '<tr>
                                        <td scope="row" colspan="4" class="text-center py-3">No Data</td>
                                    </tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>
    <?php
}

function match_info($m_id)
{
    global $fnc;
    $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
    $row = $fnc->get_db_row($sql);
    $fnc->debug_console("match info sql: ", $sql);
    $fnc->debug_console("match info: ", $row);
    ?>
        <div class="mt-4 mb-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="text-secondary my-2"><strong><?= $row["match_name"] ?></strong></h5>
                </div>
                <div class="card-body row">
                    <div class="col-12 col-md-6">
                        <p class="card-title"><?= "RANGE: " . $row["match_location"] ?></p>
                    </div>
                    <div class="col-12 col-md-6 text-md-end">
                        <p class="card-text"><?= "DATE: " . $row["match_begin"] . ' - ' . $row["match_finish"] ?></p>
                    </div>
                </div>
                <?php if (!empty($row["match_detail"])) { ?>
                    <div class="card-body">
                        <p class="card-text"><?= $row["match_detail"] ?></p>
                    </div>
                <?php } ?>
                <div class="card-body row">
                    <div class="col-4 col-md-4">
                        <?= "LV: " . $row["match_level"] ?>
                    </div>
                    <div class="col-4 col-md-4 text-center">
                        <?= "STAGES: " . $row["match_stages"] ?>
                    </div>
                    <div class="col-4 col-md-4 text-end">
                        <?= "ROUNDS: " . $row["match_rounds"] ?>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-6">
                            <?= "Match Director: " . $row["match_md"] ?>
                        </div>
                        <div class="col-12 col-md-6 text-md-end">
                            <?= "Contacts: " . $row["match_md_contact"] ?>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted" style="font-size: 0.75em;">
                    <div class="row">
                        <div class="col">
                            registered: <?= date("Y/m/d", strtotime($row["match_regist_datetime"])) ?>
                        </div>
                        <div class="col text-end">
                            lastupdate: <?= date("Y/m/d", strtotime($row["match_lastupdate"])) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

function so_form_update_avatar($so_id)
{
    global $fnc;
    ?>
        <div class="container mb-4">
            <h4 class="text-primary text-uppercase mt-4"><strong>SO Profile Update + Avatar</strong></h4>
            <!-- <div class="container mt-4"> -->
            <div class="card p-3 mt-4">
                <?php
                $sql = "SELECT * FROM `so-member` WHERE `so_id` = " . $so_id;
                $row = $fnc->get_db_row($sql);
                $fnc->debug_console("so info sql: ", $sql);
                $fnc->debug_console("so info: ", $row);
                ?>
                <form action="../db_mgt.php?p=so&act=soedit" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-5">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">ชื่อ - สกุล <span class="lbl_required">*</span></label>
                                <div class="row gx-2">
                                    <div class="col">
                                        <input type="text" class="form-control col" id="firstname" name="firstname" value="<?= $row["so_firstname"] ?>" maxlength="30" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control col" id="lastname" name="lastname" value="<?= $row["so_lastname"] ?>" maxlength="30" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="firstname_en" class="form-label">Full Name <span class="lbl_required">*</span></label>
                                <div class="row gx-2">
                                    <div class="col">
                                        <input type="text" class="form-control col" id="firstname_en" name="firstname_en" value="<?= $row["so_firstname_en"] ?>" maxlength="30" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control col" id="lastname_en" name="lastname_en" value="<?= $row["so_lastname_en"] ?>" maxlength="30" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nickname" class="form-label">ชื่อเรียก / ชื่อเล่น <span class="lbl_required">*</span></label>
                                <input type="text" class="form-control col" id="nickname" name="nickname" value="<?= $row["so_nickname"] ?>" maxlength="20" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-5">
                            <div class="mb-3">
                                <label for="citizen_id" class="form-label">หมายเลขบัตรประชาชน <span class="lbl_required">*</span></label>
                                <input type="text" class="form-control" id="citizen_id" name="citizen_id" value="<?= $row["so_citizen_id"] ?>" maxlength="13" required>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">วัน/เดือน/ปี เกิด <span class="lbl_required">*</span></label>
                                <input type="date" class="form-control col" id="dob" name="dob" value="<?= $row["so_dob"] ?>" required>
                            </div>
                            <div class="mb-3">
                                <div class="row gx-2">
                                    <div class="col">
                                        <label for="sex" class="form-label">เพศ <span class="lbl_required">*</span></label>
                                        <select id="sex" name="sex" class="form-select" required>
                                            <?php
                                            foreach ($fnc->opt_sex as $sex) {
                                                echo '<option value="' . $sex . '"';
                                                if ($row["so_sex"] == $sex) {
                                                    echo ' selected';
                                                }
                                                echo '>' . $sex . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="blood" class="form-label">หมู่เลือด <span class="lbl_required">*</span></label>
                                        <select id="blood" name="blood" class="form-select" required>
                                            <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                                            <?php
                                            foreach ($fnc->opt_blood_type as $blood) {
                                                echo '<option value="' . $blood . '"';
                                                if ($row["so_blood_type"] == $blood) {
                                                    echo ' selected';
                                                }
                                                echo '>' . $blood . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-5 mb-md-0">
                            <div class="mb-3">
                                <label for="phone" class="form-label">เบอร์โทร <span class="lbl_required">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= $row["so_phone"] ?>" maxlength="30" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">อีเมล <span class="lbl_required">*</span></label>
                                <input type="email" class="form-control col" id="email" name="email" value="<?= $row["so_email"] ?>" maxlength="50" required>
                            </div>
                            <div class="mb-3">
                                <label for="line_id" class="form-label">LINE ID</label>
                                <input type="text" class="form-control col" id="line_id" name="line_id" value="<?= $row["so_line_id"] ?>" maxlength="30">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">ที่อยู่</label>
                                <input type="text" class="form-control col" id="address" name="address" value="<?= $row["so_address"] ?>" maxlength="50" required>
                            </div>
                            <div class="mb-3">
                                <div class="row gx-2">
                                    <div class="col">
                                        <label for="subdistrict" class="form-label">แขวง/ตำบล <span class="lbl_required">*</span></label>
                                        <input type="text" class="form-control col" id="subdistrict" name="subdistrict" value="<?= $row["so_subdistrict"] ?>" maxlength="30" required>
                                    </div>
                                    <div class="col">
                                        <label for="district" class="form-label">เขต/อำเภอ <span class="lbl_required">*</span></label>
                                        <input type="text" class="form-control col" id="district" name="district" value="<?= $row["so_district"] ?>" maxlength="30" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row gx-2">
                                    <div class="col">
                                        <label for="province" class="form-label">จังหวัด <span class="lbl_required">*</span></label>
                                        <input type="text" class="form-control col" id="province" name="province" value="<?= $row["so_province"] ?>" maxlength="30" required>
                                    </div>
                                    <div class="col">
                                        <label for="zip" class="form-label">รหัสไปรษณีย์ <span class="lbl_required">*</span></label>
                                        <input type="text" class="form-control col" id="zip" name="zip" value="<?= $row["so_zipcode"] ?>" maxlength="5" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="idpa_id" class="form-label">IDPA ID</label>
                                    <input type="text" class="form-control" id="idpa_id" name="idpa_id" value="<?= $row["so_idpa_id"] ?>" placeholder="TH0000001 (ถ้ามี)" maxlength="12">
                                </div>
                                <!-- <div class="col mb-3">
                                    <label for="so_level" class="form-label">SO LEVEL</label>
                                    <select id="so_level" name="so_level" class="form-select" disabled readonly>
                                        <?php
                                        // foreach ($fnc->opt_so_level as $opt) {
                                        //     echo '<option value="' . $opt . '"';
                                        //     if ($row["so_level"] == $opt) {
                                        //         echo ' selected';
                                        //     }
                                        //     echo '>' . $opt . '</option>';
                                        // }
                                        ?>
                                    </select>
                                </div> -->
                            </div>
                            <div class="mb-3">
                                <label for="club" class="form-label">CLUB</label>
                                <input type="text" class="form-control" id="club" name="club" value="<?= $row["so_club"] ?>" placeholder="(ถ้ามี)" maxlength="50">
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="idpa_exp" class="form-label">IDPA EXPIRE</label>
                                    <input type="date" class="form-control col" id="idpa_exp" name="idpa_exp" value="<?php if ($row["so_idpa_expire"]) {
                                                                                                                            echo $row["so_idpa_expire"];
                                                                                                                        } ?>">
                                </div>
                                <div class="col mb-3">
                                    <label for="so_exp" class="form-label">SO EXPIRE</label>
                                    <input type="date" class="form-control col" id="so_exp" name="so_exp" value="<?php if ($row["so_license_expire"]) {
                                                                                                                        echo $row["so_license_expire"];
                                                                                                                    } ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="idpa_profile" class="form-label">Change Password</label>
                                <input type="password" class="form-control col" id="pwd" name="pwd" placeholder="*******" maxlength="24" minlength="4">
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4 mb-3">
                                    <img class="img-thumbnail rounded mx-auto" src="../<?= $row["so_avatar"]; ?>">
                                </div>
                                <div class="col mb-3">
                                    <label for="avatar" class="form-label">Change Profile Image</label>
                                    <input type="file" name="avatar" id="avatar" accept="image/png, image/jpeg" class="form-control form-control-sm">
                                    <label for="avatar" class="form-label text-end text-muted w-100">(ratio 1:1 recommended)</label>
                                </div>
                            </div>
                            <div class="row mt-5 align-items-end gx-5" style="padding-top: 1em;">
                                <div class="col-6">
                                    <a href="../admin/?p=so" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                                </div>
                                <div class="col-6">
                                    <input type="hidden" name="status" value="<?= $row["so_status"] ?>">
                                    <input type="hidden" name="fst" value="soupdate">
                                    <input type="hidden" name="so_id" value="<?= $_SESSION["member"]["so_id"] ?>">
                                    <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="update">
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <!-- </div> -->
            </form>
        </div>

    </div>
<?php
}

function so_form_update($so_id)
{
    global $fnc;
?>
    <div class="container mb-4">
        <h4 class="text-primary text-uppercase mt-4"><strong>SO Profile Update</strong></h4>
        <!-- <div class="container mt-4"> -->
        <div class="card p-3 mt-4">
            <?php
            $sql = "SELECT * FROM `so-member` WHERE `so_id` = " . $so_id;
            $row = $fnc->get_db_row($sql);
            $fnc->debug_console("so info sql: ", $sql);
            $fnc->debug_console("so info: ", $row);
            ?>
            <form action="../db_mgt.php?p=so&act=soedit" method="post">
                <div class="row">
                    <div class="col-12 col-md-6 mb-5">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">ชื่อ - สกุล *</label>
                            <div class="row gx-2">
                                <div class="col">
                                    <input type="text" class="form-control col" id="firstname" name="firstname" value="<?= $row["so_firstname"] ?>" maxlength="30" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control col" id="lastname" name="lastname" value="<?= $row["so_lastname"] ?>" maxlength="30" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="firstname_en" class="form-label">Full Name *</label>
                            <div class="row gx-2">
                                <div class="col">
                                    <input type="text" class="form-control col" id="firstname_en" name="firstname_en" value="<?= $row["so_firstname_en"] ?>" maxlength="30" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control col" id="lastname_en" name="lastname_en" value="<?= $row["so_lastname_en"] ?>" maxlength="30" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nickname" class="form-label">ชื่อเรียก / ชื่อเล่น *</label>
                            <input type="text" class="form-control col" id="nickname" name="nickname" value="<?= $row["so_nickname"] ?>" maxlength="20" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-5">
                        <div class="mb-3">
                            <label for="citizen_id" class="form-label">หมายเลขบัตรประชาชน *</label>
                            <input type="text" class="form-control" id="citizen_id" name="citizen_id" value="<?= $row["so_citizen_id"] ?>" maxlength="13" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">วัน/เดือน/ปี เกิด *</label>
                            <input type="date" class="form-control col" id="dob" name="dob" value="<?= $row["so_dob"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <div class="row gx-2">
                                <div class="col">
                                    <label for="sex" class="form-label">เพศ *</label>
                                    <select id="sex" name="sex" class="form-select" required>
                                        <?php
                                        foreach ($fnc->opt_sex as $sex) {
                                            echo '<option value="' . $sex . '"';
                                            if ($row["so_sex"] == $sex) {
                                                echo ' selected';
                                            }
                                            echo '>' . $sex . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="blood" class="form-label">หมู่เลือด *</label>
                                    <select id="blood" name="blood" class="form-select" required>
                                        <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                                        <?php
                                        foreach ($fnc->opt_blood_type as $blood) {
                                            echo '<option value="' . $blood . '"';
                                            if ($row["so_blood_type"] == $blood) {
                                                echo ' selected';
                                            }
                                            echo '>' . $blood . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-5 mb-md-0">
                        <div class="mb-3">
                            <label for="phone" class="form-label">เบอร์โทร *</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= $row["so_phone"] ?>" maxlength="30" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">อีเมล *</label>
                            <input type="email" class="form-control col" id="email" name="email" value="<?= $row["so_email"] ?>" maxlength="50" required>
                        </div>
                        <div class="mb-3">
                            <label for="line_id" class="form-label">LINE ID</label>
                            <input type="text" class="form-control col" id="line_id" name="line_id" value="<?= $row["so_line_id"] ?>" maxlength="30">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">ที่อยู่</label>
                            <input type="text" class="form-control col" id="address" name="address" value="<?= $row["so_address"] ?>" maxlength="50" required>
                        </div>
                        <div class="mb-3">
                            <div class="row gx-2">
                                <div class="col">
                                    <label for="subdistrict" class="form-label">แขวง/ตำบล *</label>
                                    <input type="text" class="form-control col" id="subdistrict" name="subdistrict" value="<?= $row["so_subdistrict"] ?>" maxlength="30" required>
                                </div>
                                <div class="col">
                                    <label for="district" class="form-label">เขต/อำเภอ *</label>
                                    <input type="text" class="form-control col" id="district" name="district" value="<?= $row["so_district"] ?>" maxlength="30" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row gx-2">
                                <div class="col">
                                    <label for="province" class="form-label">จังหวัด *</label>
                                    <input type="text" class="form-control col" id="province" name="province" value="<?= $row["so_province"] ?>" maxlength="30" required>
                                </div>
                                <div class="col">
                                    <label for="zip" class="form-label">รหัสไปรษณีย์ *</label>
                                    <input type="text" class="form-control col" id="zip" name="zip" value="<?= $row["so_zipcode"] ?>" maxlength="5" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <div class="mb-3">
                            <label for="idpa_id" class="form-label">IDPA ID</label>
                            <input type="text" class="form-control" id="idpa_id" name="idpa_id" value="<?= $row["so_idpa_id"] ?>" placeholder="TH0000001 (ถ้ามี)" maxlength="12">
                        </div>
                        <div class="mb-3">
                            <label for="club" class="form-label">CLUB</label>
                            <input type="text" class="form-control" id="club" name="club" value="<?= $row["so_club"] ?>" placeholder="(ถ้ามี)" maxlength="50">
                        </div>
                        <div class="mb-3">
                            <label for="idpa_profile" class="form-label">IDPA Profile URL</label>
                            <input type="url" class="form-control col" id="idpa_profile" name="idpa_profile" value="<?= $row["so_idpa_profile"] ?>" placeholder="(ถ้ามี)" maxlength="30">
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="idpa_exp" class="form-label">IDPA EXPIRE</label>
                                <input type="date" class="form-control col" id="idpa_exp" name="idpa_exp" value="<?php if ($row["so_idpa_expire"]) {
                                                                                                                        echo $row["so_idpa_expire"];
                                                                                                                    } ?>">
                            </div>
                            <div class="col mb-3">
                                <label for="so_exp" class="form-label">SO EXPIRE</label>
                                <input type="date" class="form-control col" id="so_exp" name="so_exp" value="<?php if ($row["so_license_expire"]) {
                                                                                                                    echo $row["so_license_expire"];
                                                                                                                } ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="idpa_profile" class="form-label">Change Password</label>
                            <input type="password" class="form-control col" id="pwd" name="pwd" placeholder="*******" maxlength="24" minlength="4">
                        </div>
                        <div class="row mt-5 align-items-end gx-5" style="padding-top: 2em;">
                            <div class="col-6">
                                <a href="index.php" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                            </div>
                            <div class="col-6">
                                <input type="hidden" name="status" value="<?= $row["so_status"] ?>">
                                <input type="hidden" name="fst" value="soupdate">
                                <input type="hidden" name="so_id" value="<?= $_SESSION["member"]["so_id"] ?>">
                                <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="update">
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        <!-- </div> -->
        </form>
    </div>

    </div>
<?php
}


?>

<head>
    <title>SOTH - Member Information</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
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
                        <a class="nav-link<?php if (!isset($_GET["p"])) {
                                                echo ' active" aria-current="page';
                                            } ?>" href="../member/">home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET["p"]) && $_GET["p"] == "jobs") {
                                                echo ' active" aria-current="page';
                                            } ?>" href="../member/?p=jobs">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET["p"]) && $_GET["p"] == "matchs") {
                                                echo ' active" aria-current="page';
                                            } ?>" href="../member/?p=matchs">matchs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET["p"]) && $_GET["p"] == "profile") {
                                                echo ' active" aria-current="page';
                                            } ?>" href="../member/?p=profile">Profile</a>
                    </li>
                    <?php if ($_SESSION["member"]["auth_lv"] >= 7) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">admin</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../admin/?p=so">SO Manager</a></li>
                                <li><a class="dropdown-item" href="../admin/?p=match">Match Manager</a></li>
                                <!-- <li><a class="dropdown-item" href="#">Jobs Manager</a></li> -->
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../admin/setting.php">Settings</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../sign/signout.php?p=signout">Sign-out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-shrink-0">
        <div class="container">
            <?php
            if (isset($_GET["p"]) && $_GET["p"] != "") {
                switch ($_GET["p"]) {
                    case "profile":
                        so_form_update_avatar($_SESSION["member"]["so_id"]);
                        break;
                    case "jobs":
                        $fnc->so_on_duty($_SESSION["member"]["so_id"]);
                        break;
                    case "matchs":
                        $fnc->match_list();
                        break;
                    case "matchinfo":
                        if (isset($_GET["mid"])) {
                            $fnc->match_detail($_GET["mid"]);
                        } else {
                            echo "eror: no match id variable";
                        }
                        break;
                }
            } else {
                echo '<h1 class="mt-5">My Info</h1>';
                $fnc->gen_member_card($_SESSION["member"]["so_id"]);
            }

            ?>

            <?php

            // if (isset($_GET["p"]) && $_GET["p"] == "profile") {
            //     so_form_update_avatar($_SESSION["member"]["so_id"]);
            // } elseif (isset($_GET["p"]) && $_GET["p"] == "jobs") {
            //     $fnc->so_on_duty($_SESSION["member"]["so_id"]);
            // } elseif (isset($_GET["p"]) && $_GET["p"] == "matchs") {
            //     // match_list();
            //     $fnc->match_list();
            // } elseif (isset($_GET["p"]) && $_GET["p"] == "matchinfo" && $_GET["mid"]) {
            //     $fnc->match_detail($_GET["mid"]);
            // } else {

            //     echo '<h1 class="mt-5">My Info</h1>';

            //     $fnc->gen_member_card($_SESSION["member"]["so_id"]);

            // }
            ?>

        </div>
    </main>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</body>

</html>