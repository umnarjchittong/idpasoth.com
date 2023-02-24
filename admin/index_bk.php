<!doctype html>
<html lang="en">
<?php
include('../core.php');
if (empty($_SESSION["member"])) {
  echo '<meta http-equiv="refresh" content="0;url=../sign/signout.php?p=no-right">';
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

function so_list()
{
  global $fnc;
  $sql_order = NULL;
?>
  <div class="mb-5">
    <div class="row">
      <div class="col-12 col-md-8">
        <h4 class="text-primary text-uppercase mt-4"><strong>รายชื่อ SO ในระบบฐานข้อมูล (<label id="num_of_data">0</label> คน)</strong></h4>
      </div>
      <div class="col align-self-end text-end pt-4">
        <form action="?" method="get">
          <div class="input-group input-group-sm">
            <input type="hidden" name="p" value="so">
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
    <table class="table table-light table-striped table-hover mt-3">
      <thead>
        <tr class="table-primary">
          <th><?php $sql_order .= table_header_sorting("IDPA ID", "so_idpa_id", $sql_order); ?></th>
          <th><?php $sql_order .= table_header_sorting("FULL NAME", "so_firstname", $sql_order); ?></th>
          <th class="d-none d-md-table-cell"><?php $sql_order .= table_header_sorting("NICK", "so_nickname", $sql_order); ?></th>
          <th class="d-none d-md-table-cell"><?php $sql_order .= table_header_sorting("PHONE", "so_phone", $sql_order); ?></th>
          <th class="d-none d-lg-table-cell"><?php $sql_order .= table_header_sorting("EMAIL", "so_email", $sql_order); ?></th>
          <!-- <th><?php //$sql_order .= table_header_sorting("LINE ID", "so_line_id", $sql_order); 
                    ?></th> -->
          <!-- <th>IDPA Expr</th> -->
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_GET["v"]) && $_GET["v"] == "delete") {
          $sql = "SELECT * FROM `so-member` WHERE `so_status` = 'delete'";
        } else {
          $sql = "SELECT * FROM `so-member` WHERE `so_status` = 'enable'";
        }
        if (isset($_GET["keysearch"]) && $_GET["keysearch"] != "") {
          $sql .= " AND (`so_idpa_id` LIKE '" . $_GET["keysearch"] . "' OR `so_firstname` LIKE '%" . $_GET["keysearch"] . "%' OR `so_lastname` LIKE '%" . $_GET["keysearch"] . "%' OR `so_firstname_en` LIKE '%" . $_GET["keysearch"] . "%' OR `so_lastname_en` LIKE '%" . $_GET["keysearch"] . "%' OR `so_nickname` LIKE '" . $_GET["keysearch"] . "' OR `so_email` LIKE '%" . $_GET["keysearch"] . "%')";
        }
        if (isset($sql_order)) {
          $sql .= $sql_order;
        }
        $fnc->debug_console("table so list:", $sql);
        $so_array = $fnc->get_db_array($sql);
        if (!empty($so_array)) {
          foreach ($so_array as $row) {
            echo '<tr>
                                <td scope="row"><a href="https://www.idpa.com/members/' . $row["so_idpa_id"] . '/" target="_blank">' . $row["so_idpa_id"] . '</a></td>
                                <td nowarp><a href="?p=soinfo&soid=' . $row["so_id"] . '" target="_top">' . $row["so_firstname"] . ' ' . $row["so_lastname"] . '</a></td>
                                <td class="d-none d-md-table-cell" nowarp>' . $row["so_nickname"] . '</td>
                                <td class="d-none d-md-table-cell"><a href="tel:' . $row["so_phone"] . '"><i class="bi bi-telephone me-2"></i>' . $row["so_phone"] . '</a></td>
                                <td class="d-none d-lg-table-cell">' . $row["so_email"] . '</td>';
            // echo '<td class="text-center">' . '<a href="?p=so&act=soedit&soid=' . $row["so_id"] . '" target="_top" class="link-warning"><i class="bi bi-pencil-square"></i></a>' . '<a href="../db_mgt.php?p=so&&act=sodelete&soid=' . $row["so_id"] . '" target="_top" class="link-danger ps-2">' . '<i class="bi bi-trash-fill"></i>' . '</a></td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="8" class="text-center">SO not founded.</td></tr>';
        }
        ?>
      </tbody>
    </table>
    <script type="text/javascript">
      document.getElementById("num_of_data").innerHTML = <?= count($so_array); ?>;
    </script>

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

function so_info2($so_id)
{
  global $fnc;
?>
  <div class="mb-5">
    <h4 class="text-primary text-uppercase mt-4"><strong><a href="../admin/?p=so" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>SO Information</strong></h4>

    <?php $fnc->gen_member_card($_GET["soid"]); ?>

    <?php $fnc->gen_member_info($_GET["soid"]); ?>



  </div>
<?php
}

// * so on duty table show position order by priority
function so_on_duty($so_id)
{
  global $fnc;
?>
  <div class="mt-4 mb-5">
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

function so_form_add()
{
  global $fnc;
?>
  <div class="container mb-4">
    <h4 class="text-primary text-uppercase mt-4"><strong>NEW SO Register</strong></h4>
    <!-- <div class="container mt-4"> -->
    <div class="card p-3 mt-4">
      <form action="../db_mgt.php?p=so&act=soappend" method="post">
        <div class="row">
          <div class="col-12 col-md-6 mb-5">
            <div class="mb-3">
              <label for="firstname" class="form-label">ชื่อ - สกุล <span class="lbl_required">*</span></label>
              <div class="row gx-2">
                <div class="col">
                  <input type="text" class="form-control col" id="firstname" name="firstname" placholder="" maxlength="30" required>
                </div>
                <div class="col">
                  <input type="text" class="form-control col" id="lastname" name="lastname" placholder="" maxlength="30" required>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="firstname_en" class="form-label">Full Name <span class="lbl_required">*</span></label>
              <div class="row gx-2">
                <div class="col">
                  <input type="text" class="form-control col" id="firstname_en" name="firstname_en" placholder="" maxlength="30" required>
                </div>
                <div class="col">
                  <input type="text" class="form-control col" id="lastname_en" name="lastname_en" placholder="" maxlength="30" required>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="nickname" class="form-label">ชื่อเรียก / ชื่อเล่น</label>
              <input type="text" class="form-control col" id="nickname" name="nickname" placholder="" maxlength="20">
            </div>
          </div>

          <div class="col-12 col-md-6 mb-5">
            <div class="mb-3">
              <label for="citizen_id" class="form-label">หมายเลขบัตรประชาชน <span class="lbl_required">*</span></label>
              <input type="text" class="form-control" id="citizen_id" name="citizen_id" placholder="" maxlength="13" required>
            </div>
            <div class="mb-3">
              <label for="dob" class="form-label">วัน/เดือน/ปี เกิด <span class="lbl_required">*</span></label>
              <input type="date" class="form-control col" id="dob" name="dob" placholder="" required>
            </div>
            <div class="mb-3">
              <div class="row gx-2">
                <div class="col">
                  <label for="sex" class="form-label">เพศ</label>
                  <select id="sex" name="sex" class="form-select">
                    <?php
                    foreach ($fnc->opt_sex as $sex) {
                      echo '<option value="' . $sex . '">' . $sex . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col">
                  <label for="blood" class="form-label">หมู่เลือด</label>
                  <select id="blood" name="blood" class="form-select">
                    <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                    <?php
                    foreach ($fnc->opt_blood_type as $blood) {
                      echo '<option value="' . $blood . '">' . $blood . '</option>';
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
              <input type="text" class="form-control" id="phone" name="phone" placholder="" maxlength="30" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">อีเมล <span class="lbl_required">*</span></label>
              <input type="email" class="form-control col" id="email" name="email" placholder="" maxlength="50" required>
            </div>
            <div class="mb-3">
              <label for="line_id" class="form-label">LINE ID</label>
              <input type="text" class="form-control col" id="line_id" name="line_id" placholder="" maxlength="30">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">ที่อยู่</label>
              <input type="text" class="form-control col" id="address" name="address" placholder="" maxlength="50">
            </div>
            <div class="mb-3">
              <div class="row gx-2">
                <div class="col">
                  <label for="subdistrict" class="form-label">แขวง/ตำบล</label>
                  <input type="text" class="form-control col" id="subdistrict" name="subdistrict" placholder="" maxlength="30">
                </div>
                <div class="col">
                  <label for="district" class="form-label">เขต/อำเภอ</label>
                  <input type="text" class="form-control col" id="district" name="district" placholder="" maxlength="30">
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row gx-2">
                <div class="col">
                  <label for="province" class="form-label">จังหวัด</label>
                  <input type="text" class="form-control col" id="province" name="province" placholder="" maxlength="30">
                </div>
                <div class="col">
                  <label for="zip" class="form-label">รหัสไปรษณีย์</label>
                  <input type="text" class="form-control col" id="zip" name="zip" placholder="" maxlength="5">
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6 mb-3">
            <div class="mb-3">
              <label for="idpa_id" class="form-label">IDPA ID</label>
              <input type="text" class="form-control" id="idpa_id" name="idpa_id" placeholder="TH0000001 (ถ้ามี)" maxlength="12">
            </div>
            <div class="mb-3">
              <label for="club" class="form-label">CLUB</label>
              <input type="text" class="form-control" id="club" name="club" placeholder="(ถ้ามี)" maxlength="50">
            </div>
            <div class="mb-3">
              <label for="idpa_profile" class="form-label">IDPA Profile URL</label>
              <input type="url" class="form-control col" id="idpa_profile" name="idpa_profile" placeholder="(ถ้ามี)" maxlength="30">
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="idpa_exp" class="form-label">IDPA EXPIRE</label>
                <input type="date" class="form-control col" id="idpa_exp" name="idpa_exp">
              </div>
              <div class="col mb-3">
                <label for="so_exp" class="form-label">SO EXPIRE</label>
                <input type="date" class="form-control col" id="so_exp" name="so_exp">
              </div>
            </div>
            <div class="mb-3">
              <label for="idpa_profile" class="form-label">Enter Password <span class="lbl_required">*</span></label>
              <input type="password" class="form-control col" id="pwd" name="pwd" placeholder="อย่างน้อย 4 ตัวอักษร" maxlength="24" minlength="4" required>
            </div>
            <div class="row mt-5 align-items-end gx-5" style="padding-top: 2em;">
              <div class="col-6">
                <a href="../admin/?p=so" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
              </div>
              <div class="col-6">
                <input type="hidden" name="status" value="enable">
                <input type="hidden" name="fst" value="soappend">
                <input type="hidden" name="so_editor" value="<?= $_SESSION["member"]["so_firstname_en"] ?>">
                <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="append">
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
              <label for="firstname" class="form-label">ชื่อ - สกุล <span class="lbl_required">*</span></label>
              <div class="row gx-3">
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
              <div class="row gx-3">
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
              <div class="row gx-3">
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
              <?php if ($_SESSION["member"]["auth_lv"] >= 7) { ?>
                <div class="col mb-3">
                  <label for="so_level" class="form-label">SO LEVEL</label>
                  <select id="so_level" name="so_level" class="form-select">
                    <?php
                    foreach ($fnc->opt_so_level as $opt) {
                      echo '<option value="' . $opt . '"';
                      if ($row["so_level"] == $opt) {
                        echo ' selected';
                      }
                      echo '>' . $opt . '</option>';
                    }
                    ?>
                  </select>
                </div>
              <?php } ?>
            </div>
            <div class="mb-3">
              <label for="club" class="form-label">CLUB</label>
              <input type="text" class="form-control" id="club" name="club" value="<?= $row["so_club"] ?>" placeholder="(ถ้ามี)" maxlength="50">
            </div>
            <!-- <div class="mb-3">
              <label for="idpa_profile" class="form-label">IDPA Profile URL</label>
              <input type="url" class="form-control col" id="idpa_profile" name="idpa_profile" value="<?= $row["so_idpa_profile"] ?>" placeholder="(ถ้ามี)" maxlength="30">
            </div> -->
            <div class="row gx-3">
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
                <a href="../admin/?p=so" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
              </div>
              <div class="col-6">
                <input type="hidden" name="status" value="<?= $row["so_status"] ?>">
                <input type="hidden" name="fst" value="soupdate">
                <input type="hidden" name="so_id" value="<?= $_GET["soid"] ?>">
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

function so_admin_menu()
{
?>
  <div class="container bg-gradient pt-0 mt-0 text-end" style="background-color: #eeeeee;">
    <ul class="nav justify-content-end text-capitalize" style="font-size: 0.8rem; font-weight: bold;">
      <li class="nav-item">
        <a class="nav-link " aria-current="page" href="?p=so&act=soadd"><i class="bi bi-journal-plus me-2"></i>New SO Register</a>
      </li>
      <?php if (isset($_GET["soid"]) && $_GET["soid"] != "") {
        echo '<li class="nav-item">
          <a class="nav-link link-info" aria-current="page" href="?p=so&act=soedit&soid=' . $_GET["soid"] . '" target="_top"><i class="bi bi-pencil-square me-2"></i>Update SO</a>
        </li>';
        echo '<li class="nav-item">
          <a class="nav-link link-danger" aria-current="page" href="../db_mgt.php?p=so&&act=sodelete&soid=' . $_GET["soid"] . '" target="_top"><i class="bi bi-trash me-2"></i>delete SO</a>
        </li>';
      } else {
        if (isset($_GET["v"]) && $_GET["v"] == "delete") {
          echo '<li class="nav-item">
          <a class="nav-link link-success" aria-current="page" href="?p=so"><i class="bi bi-person me-2"></i>Activated SO</a>
          </li>';
        } else {
          echo '<li class="nav-item">
        <a class="nav-link link-danger" aria-current="page" href="?p=so&v=delete"><i class="bi bi-person-x me-2"></i>Deleted SO</a>
        </li>';
        }
      } ?>
    </ul>
  </div>
<?php
}

function match_admin_menu()
{
?>
  <div class="container bg-gradient pt-0 mt-0 text-end" style="background-color: #eeeeee;">
    <ul class="nav justify-content-end text-capitalize" style="font-size: 0.8rem; font-weight: bold;">
      <li class="nav-item">
        <?php if (isset($_GET["mid"]) && $_GET["mid"] != "") {
          echo '<li class="nav-item">
          <a class="nav-link " aria-current="page" href="?p=duty&mid=' . $_GET["mid"] . '"><i class="bi bi-person-badge me-2"></i>บันทึกการทำงานของ SO</a>
        </li>';
          echo '<li class="nav-item">
          <a class="nav-link link-info" aria-current="page" href="?p=match&act=matchedit&mid=' . $_GET["mid"] . '" target="_top"><i class="bi bi-pencil-square me-2"></i>Update Match</a>
        </li>';
          echo '<li class="nav-item">
          <a class="nav-link link-danger" aria-current="page" href="../db_mgt.php?p=match&act=matchdelete&mid=' . $_GET["mid"] . '" target="_top"><i class="bi bi-trash me-2"></i>delete Match</a>
        </li>';
        } else {
          echo '<li class="nav-item">
          <a class="nav-link " aria-current="page" href="?p=match&act=matchadd"><i class="bi bi-journal-text me-2"></i>ลงทะเบียน Match</a>
          </li>';
          if (isset($_GET["v"]) && $_GET["v"] == "delete") {
            echo '<li class="nav-item">
            <a class="nav-link link-success" aria-current="page" href="?p=match"><i class="bi bi-journal-check me-2"></i>Activated Match</a>
            </li>';
          } else {
            echo '<li class="nav-item">
          <a class="nav-link link-danger" aria-current="page" href="?p=match&v=delete"><i class="bi bi-journal-x me-2"></i>Deleted Match</a>
          </li>';
          }
        } ?>
      </li>
    </ul>
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
    <div class="card box_shadow">
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
            registered: <?= date("M d, Y", strtotime($row["match_regist_datetime"])) ?>
          </div>
          <div class="col text-end">
            lastupdate: <?= date("M d, Y", strtotime($row["match_lastupdate"])) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
}

function so_on_duty_table($m_id)
{
  global $fnc;
  $sql_order = NULL;
?>
  <div class="mt-4 mb-5">
    <h4 class="text-primary text-uppercase mt-4"><strong>SO ที่ร่วมปฏิบัติงาน</strong></h4>
    <!-- <div class="card"> -->
    <div class="card-body p-0">
      <!-- <div class="mt-5 mb-0"> -->
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
                echo '<td class="text-center d-none d-md-table-cell">' . '<a href="?p=duty&mid=' . $m_id . '&act=dutyedit&odid=' . $row["on-duty_id"] . '" target="_top" class="link-warning"><i class="bi bi-pencil-square"></i></a>' . '<a href="../db_mgt.php?p=duty&mid=' . $m_id . '&act=dutydelete&odid=' . $row["on-duty_id"] . '" target="_top" class="link-danger ps-3">' . '<i class="bi bi-trash-fill"></i>' . '</a></td>';
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
  </div>
<?php
}

function match_detail($m_id)
{
  global $fnc;
?>
  <div class="mt-4 mb-5">
    <div class="row">
      <div class="col">
        <h4 class="text-primary text-uppercase"><strong><a href="../admin/?p=match" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>Match Information</strong></h4>
      </div>
      <div class="col text-end align-self-end">

      </div>
      <div class="">
        <?php
        $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
        $row = $fnc->get_db_row($sql);
        $fnc->debug_console("match info sql: ", $sql);
        $fnc->debug_console("match info: ", $row);

        match_info($m_id);
        ?>
      </div>
      <div class="mt-3">
        <?php
        so_on_duty_table($m_id);
        ?>

      </div>

    </div>
  <?php
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
    <div class="mt-4 mb-5">
      <div class="row">
        <div class="col">
          <h4 class="text-primary text-uppercase"><strong><?php if (isset($_GET["filter"]) || isset($_GET["year"])) {
                                                            echo '<a href="../admin/?p=match" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>';
                                                          } ?>รายชื่อ Match <?php if (isset($_GET["v"]) && $_GET["v"] == "delete") {
                                                                              echo 'ที่ถูกลบไป';
                                                                            } else {
                                                                              echo 'ในระบบฐานข้อมูล';
                                                                            } ?> (<label id="num_of_data">0</label> รายการ)</strong></h4>
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
      <table class="table table-light table-striped table-hover mt-3">
        <thead>
          <tr class="table-primary">
            <th><?php $sql_order .= table_header_sorting("DATE", "match_begin", $sql_order); ?></th>
            <th><?php $sql_order .= table_header_sorting("TITLE", "match_name", $sql_order); ?></th>
            <th class="text-center"><?php $sql_order .= table_header_sorting("LEVEL", "match_level", $sql_order); ?></th>
            <th class="text-center"><?php $sql_order .= table_header_sorting("STAGES", "match_stages", $sql_order); ?></th>
            <th class="d-none d-lg-table-cell"><?php $sql_order .= table_header_sorting("MD", "match_md", $sql_order); ?></th>
            <!-- <th>IDPA Expr</th> -->
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($_GET["v"]) && $_GET["v"] == "delete") {
            $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'delete'" . $sql_year . $sql_filter;
          } else {
            $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable'" . $sql_year . $sql_filter;
          }
          if (isset($sql_order)) {
            $sql .= $sql_order;
          }
          $fnc->debug_console("table match list:", $sql);
          $dataset = $fnc->get_db_array($sql);
          if ($dataset) {
            foreach ($dataset as $row) {
              echo '<tr>
                                    <td scope="row" style="font-size:0.8em;">' . date("M d, Y", strtotime($row["match_begin"])) . '</td>
                                    <td><a href="?p=matchinfo&mid=' . $row["match_id"] . '" target="_top">' . $row["match_name"] . '</a></td>
                                    <td class="text-center">' . $row["match_level"] . '</td>
                                    <td class="text-center">' . $row["match_stages"] . '</td>                                    
                                    <td class="d-none d-lg-table-cell"><a href="?p=match&filter=match_md&key=' . $row["match_md"] . '" target="_top">' . $row["match_md"] . '</a></td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="6" class="text-center py-3">NO DATA</td></tr>';
          }
          ?>
        </tbody>
      </table>
      <script type="text/javascript">
        document.getElementById("num_of_data").innerHTML = <?= count($dataset); ?>;
      </script>

    </div>
  <?php
}

function duty_form_set($m_id)
{
  global $fnc;
  ?>
    <div class="mt-4 mb-3">
      <h4 class="text-primary text-uppercase"><strong><a href="index.php?p=matchinfo&mid=<?= $_GET["mid"] ?>" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>Match Information set SO</strong></h4>
      <div class="mt-4">
        <?php
        $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
        $row = $fnc->get_db_row($sql);
        $fnc->debug_console("match info sql: ", $sql);
        $fnc->debug_console("match info: ", $row);

        match_info($m_id);
        ?>

        <div class="mt-4 mb-3">
          <div class="">
            <div class="text-start">
              <h4 class="text-secondary my-1 text-uppercase" style="font-weight:bold;">เลือก SO และหน้าที่ (เลือกได้มากกว่า 1)</h4>
            </div>

            <div class="card-body p-0">
              <form method="post" action="../db_mgt.php?p=duty&mid=<?= $m_id; ?>">
                <div class="row gy-1">
                  <div class="col-12 col-md-7">
                    <select name="so_id[]" class="form-select" size="12" multiple aria-label="size 8 select example" required>
                      <?php
                      $sql_so_onduty = "Select `so_id` From v_on_duty Where `on-duty_status` = 'enable' AND `match_id` = " . $m_id;
                      $so_onduty = $fnc->get_db_array($sql_so_onduty);
                      if (!empty($so_onduty)) {
                        $so_except = "";
                        foreach ($so_onduty as $so_duty) {
                          $so_except .= " AND `so-member`.so_id <> " . $so_duty["so_id"];
                        }
                      }
                      $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`, `so_nickname` FROM `so-member` WHERE `so_status` = 'enable'" . $so_except . " Order by `so_firstname`";
                      $so_dataset = $fnc->get_db_array($sql_so);
                      $fnc->debug_console("SO available list: ", $sql_so);
                      foreach ($so_dataset as $so) {
                        echo '<option value="' . $so["so_id"] . '">' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . $so["so_idpa_id"] . '</option>';
                      }
                      ?>
                    </select>
                    <?php $fnc->debug_console("sq on duty sql:", $sql_so_onduty); ?>
                    <?php $fnc->debug_console("sq on duty:", $so_onduty); ?>
                  </div>
                  <div class="col-12 col-md-3 mt-2 mt-md-auto">
                    <select name="position[]" class="form-select col-3" size="12" multiple aria-label="size 8 select example" required>
                      <?php
                      $position = array("MD", "CSO", "Chrono", "Stat", "SO");
                      // array_push($position, "PSO Stage 1", "PSO Stage 2", "PSO Stage 3", "PSO Stage 4", "PSO Stage 5", "PSO Stage 6", "PSO Stage 7", "PSO Stage 8", "PSO Stage 9", "PSO Stage 10", "PSO Stage 11", "PSO Stage 12", "PSO Stage 13", "PSO Stage 14", "PSO Stage 15", "PSO Stage 16", "PSO Stage 17", "PSO Stage 18", "PSO Stage 19", "PSO Stage 20");
                      // array_push($position, "SO Stage 1", "SO Stage 2", "SO Stage 3", "SO Stage 4", "SO Stage 5", "SO Stage 6", "SO Stage 7", "SO Stage 8", "SO Stage 9", "SO Stage 10", "SO Stage 11", "SO Stage 12", "SO Stage 13", "SO Stage 14", "SO Stage 15");
                      $sql_postition = "SELECT * FROM `on-duty-position` WHERE `post_status` = 'enable' AND post_priority <= 15 ORDER BY `post_priority`";
                      $position = $fnc->get_db_array($sql_postition);

                      foreach ($position as $po) {
                        echo '<option value="' . $po["post_priority"] . ',' . $po["post_title"] . '">' . $po["post_title"] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-2 align-self-end text-end mt-2 mt-md-auto">
                    <input type="hidden" name="mid" value="<?= $m_id; ?>">
                    <input type="hidden" name="fst" value="ondutyadd">
                    <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase" value="SET">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <?php
        so_on_duty_table($m_id);
        ?>

      </div>

    </div>
  <?php
}

function duty_form_edit($m_id, $odid)
{
  global $fnc;
  ?>
    <div class="container mb-4">
      <h4 class="text-primary text-decoration-underline mt-4">Match Information update SO</h4>
      <div class="container mt-4">
        <?php
        $sql = "Select vod.so_id, vod.`on-duty_position`, vod.so_firstname, vod.so_lastname, vod.so_firstname_en, vod.so_lastname_en, vod.so_nickname, vod.so_idpa_id From v_on_duty vod Where vod.`on-duty_id` = " . $odid;
        $edit_info = $fnc->get_db_array($sql)[0];
        $fnc->debug_console("edit info : ", $edit_info);
        $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
        $row = $fnc->get_db_row($sql);
        $fnc->debug_console("match info sql: ", $sql);
        $fnc->debug_console("match info: ", $row);

        match_info($m_id);
        ?>

        <div class="mt-4 mb-3">
          <div class="card">
            <div class="card-header text-center">
              <h5 class="text-secondary my-1 text-uppercase" style="font-size:0.9em; font-weight:bold;">Form Edit on Duty</h5>
            </div>

            <div class="card-body p-0">
              <form method="post" action="../db_mgt.php?p=duty&mid=<?= $m_id; ?>">
                <div class="row gy-1">
                  <div class="col-12 col-md-7">
                    <select name="so_id" class="form-select" size="8" aria-label="size 8 select example" required>
                      <?php
                      $sql_so_onduty = "Select v_on_duty.so_id From v_on_duty Where `on-duty_status` = 'enable' AND v_on_duty.match_id = " . $m_id;
                      $so_onduty = $fnc->get_db_array($sql_so_onduty);
                      if (!empty($so_onduty)) {
                        $so_except = "";
                        foreach ($so_onduty as $so_duty) {
                          $so_except .= " AND `so-member`.so_id <> " . $so_duty["so_id"];
                        }
                      }
                      $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`, `so_nickname` FROM `so-member` WHERE `so_status` = 'enable'" . $so_except . " Order by `so_firstname`";
                      $so_dataset = $fnc->get_db_array($sql_so);
                      $fnc->debug_console("SO available list: ", $sql_so);
                      if (isset($edit_info)) {
                        echo '<option value="' . $edit_info["so_id"] . '" selected>' . $edit_info["so_firstname"] . ' ' . $edit_info["so_lastname"] . ' (' . $edit_info["so_nickname"] . ') ' . $edit_info["so_idpa_id"] . '</option>';
                      }
                      foreach ($so_dataset as $so) {
                        echo '<option value="' . $so["so_id"] . '">' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . $so["so_idpa_id"] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-3 mt-2 mt-md-auto">
                    <select name="position" class="form-select col-3" size="8" aria-label="size 8 select example" required>
                      <?php
                      $sql_postition = "SELECT * FROM `on-duty-position` WHERE `post_status` = 'enable' ORDER BY `post_priority`";
                      $position = $fnc->get_db_array($sql_postition);

                      foreach ($position as $po) {
                        echo '<option value="' . $po["post_priority"] . ',' . $po["post_title"] . '"';
                        if ($po["post_title"] == $edit_info["on-duty_position"]) {
                          echo ' selected';
                        }
                        echo '>' . $po["post_title"] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-2 align-self-end text-end mt-2 mt-md-auto">
                    <input type="hidden" name="odid" value="<?= $odid; ?>">
                    <input type="hidden" name="mid" value="<?= $m_id; ?>">
                    <input type="hidden" name="fst" value="ondutyupdate">
                    <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase" value="update">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <?php
        so_on_duty_table($m_id);
        ?>

      </div>

    </div>
  <?php
}

function match_form_add()
{
  global $fnc;
  ?>
    <div class="container mb-4">
      <h4 class="text-primary text-uppercase mt-4"><strong>Match Register</strong></h4>
      <!-- <div class="container mt-4"> -->
      <div class="card p-3 mt-4">
        <form action="../db_mgt.php?p=match&act=matchappend" method="post">
          <div class="row">
            <div class="col-12 col-md-6 mb-5 mb-md-2">
              <div class="mb-3">
                <label for="match_name" class="form-label">Match Name <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="match_name" name="match_name" placholder="" maxlength="120" required>
              </div>
              <div class="mb-3">
                <label for="match_location" class="form-label">Range / Location <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="match_location" name="match_location" placholder="" maxlength="80" required>
              </div>
              <div class="mb-3">
                <label for="match_md" class="form-label">Match Director <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="match_md" name="match_md" placholder="" maxlength="30" required>
              </div>
              <div class="mb-3">
                <label for="match_md_contact" class="form-label">M.D. Contact</label>
                <input type="text" class="form-control col" id="match_md_contact" name="match_md_contact" placholder="" maxlength="60">
              </div>
              <div class="mb-3">
                <label for="match_detail" class="form-label">Match Details</label>
                <textarea class="form-control" id="match_detail" name="match_detail" rows="3"></textarea>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-2">
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="match_level" class="form-label">LEVEL <span class="lbl_required">*</span></label>
                    <select id="match_level" name="match_level" class="form-select" required>
                      <?php
                      for ($i = 1; $i <= 5; $i++) {
                        echo '<option value="TIER ' . $i . '">TIER ' . $i . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col">
                    <label for="match_stages" class="form-label">Stages <span class="lbl_required">*</span></label>
                    <select id="match_stages" name="match_stages" class="form-select" required>
                      <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                      <?php
                      for ($i = 1; $i <= 15; $i++) {
                        echo '<option value="' . $i . '">' . $i . '&nbsp;&nbsp;Stage';
                        if ($i > 1) {
                          echo 's';
                        }
                        echo '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col">
                    <label for="match_rounds" class="form-label">Rounds <span class="lbl_required">*</span></label>
                    <input type="number" class="form-control col" id="match_rounds" name="match_rounds" placholder="" maxlength="3" min="1" max="300" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="match_begin" class="form-label">Match Begin <span class="lbl_required">*</span></label>
                  <input type="date" class="form-control col" id="match_begin" name="match_begin" required>
                </div>
                <div class="col mb-3">
                  <label for="match_finish" class="form-label">Match Finish</label>
                  <input type="date" class="form-control col" id="match_finish" name="match_finish">
                </div>
              </div>

              <div class="mb-3">
                <label for="match_coordinator" class="form-label">Co-Ordinator</label>
                <select id="match_coordinator" name="match_coordinator" class="form-select">
                  <?php
                  $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`, `so_nickname` FROM `so-member` WHERE `so_status` = 'enable' Order by `so_firstname`";
                  $so_dataset = $fnc->get_db_array($sql_so);
                  $fnc->debug_console("SO available list: ", $sql_so);
                  echo '<option value="">' . 'ไม่ระบุ' . '</option>';
                  if (!empty($so_dataset)) {
                    foreach ($so_dataset as $so) {
                      echo '<option value="' . $so["so_id"] . '">' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . $so["so_idpa_id"] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="row mt-5 align-items-end gx-5" style="padding-top: 7em;">
                <div class="col-6">
                  <a href="../admin/?p=match" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                </div>
                <div class="col-6">
                  <input type="hidden" name="fst" value="matchappend">
                  <input type="hidden" name="match_editor" value="<?= $_SESSION["member"]["so_firstname_en"] ?>">
                  <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="append">
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

function match_form_edit($mid)
{
  global $fnc;
  $sql = "SELECT * FROM `match-idpa` WHERE `match_id` = " . $mid;
  $match_info = $fnc->get_db_row($sql);
?>
  <div class="container mb-4">
    <h4 class="text-primary text-uppercase mt-4"><strong>Match Update</strong></h4>
    <!-- <div class="container mt-4"> -->
    <div class="card p-3 mt-4">
      <form action="../db_mgt.php?p=match&act=matchupdate" method="post">
        <div class="row">
          <div class="col-12 col-md-6 mb-5 mb-md-2">
            <div class="mb-3">
              <label for="match_name" class="form-label">Match Name <span class="lbl_required">*</span></label>
              <input type="text" class="form-control col" id="match_name" name="match_name" value="<?= $match_info["match_name"] ?>" placholder="" maxlength="120" required>
            </div>
            <div class="mb-3">
              <label for="match_location" class="form-label">Range / Location <span class="lbl_required">*</span></label>
              <input type="text" class="form-control col" id="match_location" name="match_location" value="<?= $match_info["match_location"] ?>" placholder="" maxlength="80" required>
            </div>
            <div class="mb-3">
              <label for="match_md" class="form-label">Match Director <span class="lbl_required">*</span></label>
              <input type="text" class="form-control col" id="match_md" name="match_md" value="<?= $match_info["match_md"] ?>" placholder="" maxlength="30" required>
            </div>
            <div class="mb-3">
              <label for="match_md_contact" class="form-label">M.D. Contact</label>
              <input type="text" class="form-control col" id="match_md_contact" name="match_md_contact" value="<?= $match_info["match_md_contact"] ?>" placholder="" maxlength="60">
            </div>
            <div class="mb-3">
              <label for="match_detail" class="form-label">Match Details</label>
              <textarea class="form-control" id="match_detail" name="match_detail" rows="3"><?= $match_info["match_detail"] ?></textarea>
            </div>
          </div>

          <div class="col-12 col-md-6 mb-2">
            <div class="mb-3">
              <div class="row gx-2">
                <div class="col">
                  <label for="match_level" class="form-label">LEVEL <span class="lbl_required">*</span></label>
                  <select id="match_level" name="match_level" class="form-select" required>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                      echo '<option value="TIER ' . $i . '"';
                      if ($match_info["match_level"] == "TIER " . $i) {
                        echo ' selected';
                      }
                      echo '>TIER ' . $i . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col">
                  <label for="match_stages" class="form-label">Stages <span class="lbl_required">*</span></label>
                  <select id="match_stages" name="match_stages" class="form-select" required>
                    <!-- <option value="ไม่ระบุ" selected>ไม่ระบุ</option> -->
                    <?php
                    for ($i = 1; $i <= 15; $i++) {
                      echo '<option value="' . $i . '"';
                      if ($match_info["match_stages"] == $i) {
                        echo ' selected';
                      }
                      echo '>' . $i . '&nbsp;&nbsp;Stage';
                      if ($i > 1) {
                        echo 's';
                      }
                      echo '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col">
                  <label for="match_rounds" class="form-label">Rounds <span class="lbl_required">*</span></label>
                  <input type="number" class="form-control col" id="match_rounds" name="match_rounds" value="<?= $match_info["match_rounds"] ?>" placholder="" maxlength="3" min="50" max="350" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="match_begin" class="form-label">Match Begin <span class="lbl_required">*</span></label>
                <input type="date" class="form-control col" id="match_begin" name="match_begin" value="<?php if (!empty($match_info["match_begin"])) {
                                                                                                          echo $match_info["match_begin"];
                                                                                                        } ?>" required>
              </div>
              <div class="col mb-3">
                <label for="match_finish" class="form-label">Match Finish</label>
                <input type="date" class="form-control col" id="match_finish" name="match_finish" value="<?php if ($match_info["match_finish"]) {
                                                                                                            echo $match_info["match_finish"];
                                                                                                          } ?>">
              </div>
            </div>

            <div class="mb-3">
              <label for="match_coordinator" class="form-label">Co-Ordinator</label>
              <select id="match_coordinator" name="match_coordinator" class="form-select">
                <?php
                $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`, `so_nickname` FROM `so-member` WHERE `so_status` = 'enable' Order by `so_firstname`";
                $so_dataset = $fnc->get_db_array($sql_so);
                $fnc->debug_console("SO available list: ", $sql_so);
                echo '<option value="">' . 'ไม่ระบุ' . '</option>';
                if (!empty($so_dataset)) {
                  foreach ($so_dataset as $so) {
                    echo '<option value="' . $so["so_id"] . '">' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . $so["so_idpa_id"] . '</option>';
                  }
                }
                ?>
              </select>
            </div>
            <div class="row mt-5 align-items-end gx-5" style="padding-top: 7em;">
              <div class="col-6">
                <a href="../admin/?p=matchinfo&mid=<?= $mid ?>" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
              </div>
              <div class="col-6">
                <input type="hidden" name="m_id" value="<?= $mid ?>">
                <input type="hidden" name="fst" value="matchupdate">
                <input type="hidden" name="match_editor" value="<?= $_SESSION["member"]["so_firstname_en"] ?>">
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

function match_form_edit_upload($mid)
{
  global $fnc;
  $sql = "SELECT * FROM `match-idpa` WHERE `match_id` = " . $mid;
  $match_info = $fnc->get_db_row($sql);
?>
  <div class="container mb-4">
    <h4 class="text-primary text-uppercase mt-4"><strong>Match Update + File</strong></h4>
    <!-- <div class="container mt-4"> -->
    <div class="card p-3 mt-4">
      <form action="../db_mgt.php?p=match&act=matchupdate" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12 col-md-6 mb-5 mb-md-2">
            <div class="mb-3">
              <label for="match_name" class="form-label">Match Name <span class="lbl_required">*</span></label>
              <input type="text" class="form-control col" id="match_name" name="match_name" value="<?= $match_info["match_name"] ?>" placholder="" maxlength="120" required>
            </div>
            <div class="mb-3">
              <label for="match_location" class="form-label">Range / Location <span class="lbl_required">*</span></label>
              <input type="text" class="form-control col" id="match_location" name="match_location" value="<?= $match_info["match_location"] ?>" placholder="" maxlength="80" required>
            </div>
            <div class="mb-3">
              <label for="match_md" class="form-label">Match Director <span class="lbl_required">*</span></label>
              <input type="text" class="form-control col" id="match_md" name="match_md" value="<?= $match_info["match_md"] ?>" placholder="" maxlength="30" required>
            </div>
            <div class="mb-3">
              <label for="match_md_contact" class="form-label">M.D. Contact</label>
              <input type="text" class="form-control col" id="match_md_contact" name="match_md_contact" value="<?= $match_info["match_md_contact"] ?>" placholder="" maxlength="60">
            </div>
            <div class="mb-3">
              <label for="match_detail" class="form-label">Match Details</label>
              <textarea class="form-control" id="match_detail" name="match_detail" rows="3"><?= $match_info["match_detail"] ?></textarea>
            </div>
          </div>

          <div class="col-12 col-md-6 mb-2">
            <div class="mb-3">
              <div class="row gx-2">
                <div class="col">
                  <label for="match_level" class="form-label">LEVEL <span class="lbl_required">*</span></label>
                  <select id="match_level" name="match_level" class="form-select" required>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                      echo '<option value="TIER ' . $i . '"';
                      if ($match_info["match_level"] == "TIER " . $i) {
                        echo ' selected';
                      }
                      echo '>TIER ' . $i . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col">
                  <label for="match_stages" class="form-label">Stages <span class="lbl_required">*</span></label>
                  <select id="match_stages" name="match_stages" class="form-select" required>
                    <!-- <option value="ไม่ระบุ" selected>ไม่ระบุ</option> -->
                    <?php
                    for ($i = 1; $i <= 15; $i++) {
                      echo '<option value="' . $i . '"';
                      if ($match_info["match_stages"] == $i) {
                        echo ' selected';
                      }
                      echo '>' . $i . '&nbsp;&nbsp;Stage';
                      if ($i > 1) {
                        echo 's';
                      }
                      echo '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col">
                  <label for="match_rounds" class="form-label">Rounds <span class="lbl_required">*</span></label>
                  <input type="number" class="form-control col" id="match_rounds" name="match_rounds" value="<?= $match_info["match_rounds"] ?>" placholder="" maxlength="3" min="50" max="350" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="match_begin" class="form-label">Match Begin <span class="lbl_required">*</span></label>
                <input type="date" class="form-control col" id="match_begin" name="match_begin" value="<?php if (!empty($match_info["match_begin"])) {
                                                                                                          echo $match_info["match_begin"];
                                                                                                        } ?>" required>
              </div>
              <div class="col mb-3">
                <label for="match_finish" class="form-label">Match Finish</label>
                <input type="date" class="form-control col" id="match_finish" name="match_finish" value="<?php if ($match_info["match_finish"]) {
                                                                                                            echo $match_info["match_finish"];
                                                                                                          } ?>">
              </div>
            </div>

            <div class="mb-3">
              <label for="match_coordinator" class="form-label">Co-Ordinator</label>
              <select id="match_coordinator" name="match_coordinator" class="form-select">
                <?php
                $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`, `so_nickname` FROM `so-member` WHERE `so_status` = 'enable' Order by `so_firstname`";
                $so_dataset = $fnc->get_db_array($sql_so);
                $fnc->debug_console("SO available list: ", $sql_so);
                echo '<option value="">' . 'ไม่ระบุ' . '</option>';
                if (!empty($so_dataset)) {
                  foreach ($so_dataset as $so) {
                    echo '<option value="' . $so["so_id"] . '">' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . $so["so_idpa_id"] . '</option>';
                  }
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="match_upload_file" class="form-label">Report Upload</label>
              <input type="file" name="match_upload_file" id="match_upload_file" accept=".pdf" class="form-control form-control-sm">
              <label for="match_upload_file" class="form-label text-end text-muted w-100">(รองรับเฉพาะไฟล์ .PDF)</label>
            </div>
            <div class="row mt-5 align-items-end gx-5" style="padding-top: 7em;">
              <div class="col-6">
                <a href="../admin/?p=matchinfo&mid=<?= $mid ?>" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
              </div>
              <div class="col-6">
                <input type="hidden" name="m_id" value="<?= $mid ?>">
                <input type="hidden" name="fst" value="matchupdate">
                <input type="hidden" name="match_editor" value="<?= $_SESSION["member"]["so_firstname_en"] ?>">
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
            <a class="nav-link" aria-current="page" href="../member/">home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../member/?p=jobs">Jobs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../member/?p=matchs">matchs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../member/?p=profile">Profile</a>
          </li>
          <?php if ($_SESSION["member"]["auth_lv"] >= 7) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">admin</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "so") {
                                              echo ' active" aria-current="page';
                                            } ?>" href="../admin/?p=so">SO Manager</a></li>
                <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "match") {
                                              echo ' active" aria-current="page';
                                            } ?>" href="../admin/?p=match">Match Manager</a></li>
                <!-- <li><a class="dropdown-item" href="#">Jobs Manager</a></li> -->
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="../admin/report.php">reports</a></li>
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
          case "so":
            if (isset($_GET["act"]) && $_GET["act"] == "soedit" && isset($_GET["soid"])) {
              $fnc->so_form_update_admin($_GET["soid"]);
            } elseif (isset($_GET["act"]) && $_GET["act"] == "soadd") {
              $fnc->so_form_add();
            } else {
              $fnc->so_admin_menu();
              $fnc->so_list();
            }
            break;
          case "soinfo":
            if (isset($_GET["soid"])) {
              if ($_SESSION["member"]["auth_lv"] >= 9) {
                $fnc->so_admin_menu();
              }
              $fnc->so_info($_GET["soid"]);
              $fnc->so_on_duty($_GET["soid"]);
            }
            break;
          case "match":
            if (isset($_GET["act"]) && $_GET["act"] == "matchedit" && isset($_GET["mid"])) {
              if ($_SESSION["member"]["auth_lv"] >= 9) {
                match_form_edit_upload($_GET["mid"]);
              } else {
                match_form_edit($_GET["mid"]);
              }
            } elseif (isset($_GET["act"]) && $_GET["act"] == "matchadd") {
              match_form_add();
            } else {
              if ($_SESSION["member"]["auth_lv"] >= 9) {
                $fnc->match_admin_menu();
              }
              match_list();
            }
            break;
          case "matchinfo":
            if (isset($_GET["mid"])) {
              if ($_SESSION["member"]["auth_lv"] >= 9) {
                match_admin_menu();
              }
              match_detail($_GET["mid"]);
            }
            break;
          case "duty":
            if (isset($_GET["mid"])) {
              if (isset($_GET["act"]) && $_GET["act"] == "dutyedit" && isset($_GET["odid"])) {
                duty_form_edit($_GET["mid"], $_GET["odid"]);
              } else {
                duty_form_set($_GET["mid"]);
              }
            }
            break;
        }
      } else {
        echo '<h1 class="mt-5">Template with fixed navbar</h1>';
        echo '<p class="lead">A starter template with a navbar HTML and CSS. A fixed navbar has been added with padding-top: 60px; on the main > .container.</p>';
      }

      /*if (isset($_GET["p"]) && $_GET["p"] == "so") {
        if (isset($_GET["act"]) && $_GET["act"] == "soedit" && isset($_GET["soid"])) {
          so_form_update($_GET["soid"]);
        } elseif (isset($_GET["act"]) && $_GET["act"] == "soadd") {
          so_form_add();
        } else {
          so_admin_menu();
          so_list();
        }
      } elseif (isset($_GET["p"]) && $_GET["p"] == "soinfo" && isset($_GET["soid"])) {
        if ($_SESSION["member"]["auth_lv"] >= 9) {
          so_admin_menu();
        }
        so_info($_GET["soid"]);
        so_on_duty($_GET["soid"]);
      } elseif (isset($_GET["p"]) && $_GET["p"] == "match") {
        if (isset($_GET["act"]) && $_GET["act"] == "matchedit" && isset($_GET["mid"])) {
          if ($_SESSION["member"]["auth_lv"] >= 9) {
            match_form_edit_upload($_GET["mid"]);
          } else {
            match_form_edit($_GET["mid"]);
          }
        } elseif (isset($_GET["act"]) && $_GET["act"] == "matchadd") {
          match_form_add();
        } else {
          if ($_SESSION["member"]["auth_lv"] >= 9) {
            match_admin_menu();
          }
          match_list();
        }
      } elseif (isset($_GET["p"]) && $_GET["p"] == "matchinfo" && isset($_GET["mid"])) {
        if ($_SESSION["member"]["auth_lv"] >= 9) {
          match_admin_menu();
        }
        match_detail($_GET["mid"]);
      } elseif (isset($_GET["p"]) && $_GET["p"] == "duty" && isset($_GET["mid"])) {
        if (isset($_GET["act"]) && $_GET["act"] == "dutyedit" && isset($_GET["odid"])) {
          duty_form_edit($_GET["mid"], $_GET["odid"]);
        } else {
          duty_form_set($_GET["mid"]);
        }
      } else {
      echo '<h1 class="mt-5">Template with fixed navbar</h1>';
        echo '<p class="lead">A starter template with a navbar HTML and CSS. A fixed navbar has been added with padding-top: 60px; on the main > .container.</p>';
      }*/ ?>
    </div>
  </main>



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</body>

</html>