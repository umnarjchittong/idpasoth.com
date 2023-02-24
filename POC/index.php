<!doctype html>
<?php
include("../core.php");
$fnc = new Web();

// if (isset($_POST["fst"]) && $_POST["fst"] == "ondutyadd" && isset($_POST["mid"]) && isset($_POST["so_id"]) && isset($_POST["position"]) && isset($_POST["submit"])) {
//     // $_POST["position"]
//     $position = explode(",",$_POST["position"]);
//     $sql = "INSERT INTO `on-duty` (`match_id`, `so_id`, `on-duty_priority`, `on-duty_position`, `on-duty_status`, `on-duty_editor`, `on-duty_lastupdate`) VALUES (" . $_POST["mid"] . ", " . $_POST["so_id"] . ", " . $position[0] . ", '" . $position["1"] . "', 'enable', 'TOM', current_timestamp())";
//     $fnc->sql_execute($sql);
//     // echo $sql;
//     echo '<meta http-equiv="refresh" content="0; URL=?p=duty&mid=' . $_GET["mid"] . '&alert=success&msg=บันทึกเรียบร้อย" />';
// }

// if (isset($_GET["p"]) && $_GET["p"] == "duty" && isset($_GET["mid"]) && isset($_GET["act"]) && $_GET["act"] == "dutydelete" && isset($_GET["odid"])) {
//     // $sql = "DELETE FROM `on-duty` WHERE `on-duty_id` = " . $_GET["odid"];
//     $sql = "UPDATE `on-duty` SET `on-duty_status`='delete',`on-duty_editor`='TOM',`on-duty_lastupdate`=CURRENT_TIMESTAMP WHERE `on-duty_id` = " . $_GET["odid"];
//     $fnc->sql_execute($sql);
//     // echo $sql;
//     echo '<meta http-equiv="refresh" content="0; URL=?p=duty&mid=' . $_GET["mid"] . '&alert=info&msg=ลบเรียบร้อย" />';
// }

// if (isset($_POST["fst"]) && $_POST["fst"] == "ondutyupdate" && isset($_POST["mid"]) && isset($_POST["so_id"]) && isset($_POST["odid"]) && isset($_POST["position"]) && isset($_POST["submit"])) {
//     $position = explode(",",$_POST["position"]);
//     $sql = "UPDATE `on-duty` SET `so_id`=" . $_POST["so_id"] . ", `on-duty_priority`=" . $position[0] . ", `on-duty_position`='" . $position[1] . "', `on-duty_editor`='TOM',`on-duty_lastupdate`=CURRENT_TIMESTAMP WHERE `on-duty_id` = " . $_POST["odid"];
//     $fnc->sql_execute($sql);
//     // echo $sql;
//     echo '<meta http-equiv="refresh" content="0; URL=?p=duty&mid=' . $_POST["mid"] . '&alert=info&msg=อัพเดทเรียบร้อย" />';
// }
?>
<html lang="en">

<head>
    <title>POC</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            size: 1rem;
            /* background-color: #FFF; */
        }

        a {
            text-decoration: none;
        }

        a:hover,
        a:focus {
            /* text-decoration: underline; */
            font-weight: bold;
            /* color: orangered; */
        }

        .info-label {
            font-weight: bold;
            color: #333;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <?php
        $apiURL = 'https://api.freegeoip.app/json/?apikey=83970ad0-3cc0-11ec-a621-01cc961293ab';
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $data = file_get_contents($apiURL, false, stream_context_create($arrContextOptions)); // put the contents of the file into a variable                   
        $array_data = json_decode($data, true);
        // * เก็บ $data เข้า database เป็น text
        // echo $data;
        // print_r($array_data);
        ?>
        <div class="container border-bottom mb-4">
            <div class="row">
                <div class="col">
                    <h2>SOTH Mockup</h2>
                </div>
                <div class="col text-end">
                    <nav class="nav justify-content-end">
                        <a class="nav-link" href="?p=so">SO</a>
                        <a class="nav-link" href="?p=match">Match</a>
                        <a class="nav-link" href="?p=duty">Regis Check</a>
                        <!-- <a class="nav-link disabled" href="#">Disabled link</a> -->
                    </nav>
                </div>
            </div>

            <?php
            if ($fnc->system_alert && isset($_GET["alert"]) && isset($_GET["msg"])) {
                echo '<div class="alert alert-' . $_GET["alert"] . ' text-center" role="alert">';
                echo '<h3 class="my-4">' . $_GET["msg"] . '</h3>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }
            ?>

            <?php
            if (isset($_GET["p"])) {
                switch ($_GET["p"]) {
                    case "so":
                        if (isset($_GET["act"]) && $_GET["act"] == "soedit" && isset($_GET["soid"])) {
                            so_form_update($_GET["soid"]);
                        } else {
                            so_list();
                        }
                        break;
                    case "match";
                        match_list();
                        break;
                    case "soinfo";
                        if (isset($_GET["soid"])) {
                            so_info($_GET["soid"]);
                            so_on_duty($_GET["soid"]);
                        }
                        break;
                    case "matchinfo";
                        if (isset($_GET["mid"])) {
                            match_detail($_GET["mid"]);
                        }
                        break;
                    case "duty";
                        if (isset($_GET["mid"])) {
                            if (isset($_GET["act"]) && $_GET["act"] == "dutyedit" && isset($_GET["odid"])) {
                                duty_form_edit($_GET["mid"], $_GET["odid"]);
                            } else {
                                duty_form_set($_GET["mid"]);
                            }
                        }
                        break;
                }
            }
            ?>
        </div>

        <?php
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

        function so_form_add()
        {
            global $fnc;
        ?>
            <div class="container mb-4">
                <h4 class="text-primary text-uppercase mt-4">SO Information Add</h4>
                <div class="container mt-4">
                    <form action="db_mgt.php" method="post">
                        <div class="row mt-5">
                            <div class="col-12 col-md-6 mb-5">
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">ชื่อ - สกุล *</label>
                                    <div class="row gx-2">
                                        <div class="col">
                                            <input type="text" class="form-control col" id="firstname" name="firstname" placeholder="ชื่อ" maxlength="30" required>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control col" id="lastname" name="lastname" placeholder="นามสกุล" maxlength="30" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="firstname_en" class="form-label">Full Name *</label>
                                    <div class="row gx-2">
                                        <div class="col">
                                            <input type="text" class="form-control col" id="firstname_en" name="firstname_en" placeholder="First Name" maxlength="30" required>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control col" id="lastname_en" name="lastname_en" placeholder="Last Name" maxlength="30" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nickname" class="form-label">ชื่อเรียก / ชื่อเล่น *</label>
                                    <input type="text" class="form-control col" id="nickname" name="nickname" placeholder="" maxlength="20" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-5">
                                <div class="mb-3">
                                    <label for="citizen_id" class="form-label">หมายเลขบัตรประชาชน *</label>
                                    <input type="text" class="form-control" id="citizen_id" name="citizen_id" placeholder="" maxlength="13" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dob" class="form-label">วัน/เดือน/ปี เกิด *</label>
                                    <input type="date" class="form-control col" id="dob" name="dob" placeholder="" required>
                                </div>
                                <div class="mb-3">
                                    <div class="row gx-2">
                                        <div class="col">
                                            <label for="sex" class="form-label">เพศ *</label>
                                            <select id="sex" name="sex" class="form-select" required>
                                                <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                                                <option value="ชาย">ชาย</option>
                                                <option value="หญิง">หญิง</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="blood" class="form-label">หมู่เลือด *</label>
                                            <select id="blood" name="blood" class="form-select" required>
                                                <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                                                <?php
                                                foreach ($fnc->blood_type as $blood) {
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
                                    <label for="phone" class="form-label">เบอร์โทร *</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="" maxlength="30" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">อีเมล *</label>
                                    <input type="email" class="form-control col" id="email" name="email" placeholder="example@email.com" maxlength="50" required>
                                </div>
                                <div class="mb-3">
                                    <label for="line_id" class="form-label">LINE ID</label>
                                    <input type="text" class="form-control col" id="line_id" name="line_id" placeholder="(ถ้ามี)" maxlength="30">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">ที่อยู่</label>
                                    <input type="text" class="form-control col" id="address" name="address" maxlength="50" required>
                                </div>
                                <div class="mb-3">
                                    <div class="row gx-2">
                                        <div class="col">
                                            <label for="subdistrict" class="form-label">แขวง/ตำบล *</label>
                                            <input type="text" class="form-control col" id="subdistrict" name="subdistrict" maxlength="30" required>
                                        </div>
                                        <div class="col">
                                            <label for="district" class="form-label">เขต/อำเภอ *</label>
                                            <input type="text" class="form-control col" id="district" name="district" maxlength="30" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row gx-2">
                                        <div class="col">
                                            <label for="subdistrict" class="form-label">จังหวัด *</label>
                                            <input type="text" class="form-control col" id="subdistrict" name="subdistrict" maxlength="30" required>
                                        </div>
                                        <div class="col">
                                            <label for="district" class="form-label">รหัสไปรษณีย์ *</label>
                                            <input type="text" class="form-control col" id="district" name="district" maxlength="5" required>
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
                                    <label for="idpa_profile" class="form-label">IDPA Profile URL</label>
                                    <input type="url" class="form-control col" id="idpa_profile" name="idpa_profile" placeholder="(ถ้ามี)" maxlength="30">
                                </div>
                                <div class="mb-3">
                                    <label for="idpa_exp" class="form-label">IDPA EXPIRE</label>
                                    <input type="date" class="form-control col" id="idpa_exp" name="idpa_exp">
                                </div>
                                <div class="mb-3">
                                    <label for="so_exp" class="form-label">SO EXPIRE</label>
                                    <input type="date" class="form-control col" id="so_exp" name="so_exp">
                                </div>
                                <div class="row mt-5 align-items-end gx-5" style="padding-top: 4em;">
                                    <div class="col-6">
                                        <a href="index.php?p=so" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                                    </div>
                                    <div class="col-6">
                                        <input type="hidden" name="fst" value="soadd">
                                        <input type="hidden" name="so_id" value="<?= $_GET['soid'] ?>">
                                        <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="update">
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
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
        <h4 class="text-primary text-uppercase mt-4">SO Information Update</h4>
        <div class="container mt-4">
            <?php
            $sql = "SELECT * FROM `so-member` WHERE `so_id` = " . $so_id;
            $row = $fnc->get_db_row($sql);
            $fnc->debug_console("so info sql: ", $sql);
            $fnc->debug_console("so info: ", $row);
            ?>
            <form action="db_mgt.php?p=so&act=soedit" method="post">
                <div class="row mt-5">
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
                            <input type="text" class="form-control" id="citizen_id" name="citizen_id" value="<?= $row["so_citizen_id"] ?>" maxlength="13" required>
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
                        <div class="mb-3 align-self-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input " name="status" value="enable" type="checkbox" role="switch" id="status" <?php if ($row["so_status"] == "enable") {
                                                                                                                                            echo ' checked';
                                                                                                                                        } ?>>
                                <label class="form-check-label text-uppercase" for="status">Checked to ENABLE PROFILE</label>

                            </div>
                        </div>
                        <div class="row mt-5 align-items-end gx-5" style="padding-top: 2em;">
                            <div class="col-6">
                                <a href="index.php?p=so" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                            </div>
                            <div class="col-6">
                                <input type="hidden" name="fst" value="soupdate">
                                <input type="hidden" name="so_id" value="<?= $_GET['soid'] ?>">
                                <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="update">
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        </form>

        <hr>
        <div class="row mb-2">
            <div class="col">
                <a href="#" target="_top" class="btn btn-info text-uppercase">dupplicate check</a>
                <a href="#" target="_top" class="btn btn-danger text-uppercase ms-4">delete</a>
            </div>
        </div>
    </div>

    </div>
<?php
        }

        function so_info($so_id)
        {
            global $fnc;
?>
    <div class="container mb-4">
        <h4 class="mt-4 mb-0 pb-0">SO Information</h4>
        <hr class="p-0">
        <div class="container mt-4" style="font-size: 1em;">
            <?php
            $sql = "SELECT * FROM `so-member` WHERE `so_id` = " . $so_id;
            $row = $fnc->get_db_row($sql);
            $fnc->debug_console("so info sql: ", $sql);
            $fnc->debug_console("so info: ", $row);
            ?>
            <div class="row mt-2 mb-3">
                <div class="col-12 col-md-6">
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            CITIZEN ID:
                        </div>
                        <div class="col"><?= $row["so_citizen_id"]; ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            Name:
                        </div>
                        <div class="col">
                            <p class="my-0"><?= $row["so_firstname"] . " " . $row["so_lastname"] . " (" . $row["so_nickname"] . ")"; ?></p>
                            <p class="my-0"><?= $row["so_firstname_en"] . " " . $row["so_lastname_en"]; ?></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            DOB:
                        </div>
                        <div class="col"><?= date("d M Y", strtotime($row["so_dob"])); ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            SEX:
                        </div>
                        <div class="col"><?= $row["so_sex"] . " / Blood: " . $row["so_blood_type"] . ""; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-md-0 mt-4">
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            IDPA ID:
                        </div>
                        <div class="col"><?= $row["so_idpa_id"]; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            CLUB:
                        </div>
                        <div class="col"><?= $row["so_club"]; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            IDPA PROFILE:
                        </div>
                        <div class="col">
                            <?= '<a href="https://www.idpa.com/members/' . $row["so_idpa_id"] . '/" target="_blank">' . 'www.idpa.com' . '</a>' ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            IDPA EXP:
                        </div>
                        <div class="col">
                            <?= date("d M Y", strtotime($row["so_idpa_expire"])); ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            SO EXP:
                        </div>
                        <div class="col">
                            <?= date("d M Y", strtotime($row["so_license_expire"])); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <hr class="mb-4">
            </div>

            <div class="row mt-2 mb-3">
                <div class="col-12 col-md-6 mt-md-0 mt-4">
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            PHONE:
                        </div>
                        <div class="col">
                            <?= $row["so_phone"]; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            EMAIL:
                        </div>
                        <div class="col">
                            <?= $row["so_email"]; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            LINE ID:
                        </div>
                        <div class="col">
                            <?= $row["so_line_id"]; ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row mb-2">
                        <div class="col-4 col-md-4 info-label">
                            ADDRESS:
                        </div>
                        <div class="col">
                            <p class="my-0"><?= $row["so_address"]; ?></p>
                            <p class="my-0"><?= $row["so_subdistrict"] . " " . $row["so_district"]; ?></p>
                            <p class="my-0"><?= $row["so_province"] . " " . $row["so_zipcode"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <hr class="mb-1">
            </div>
            <div class="row mb-2">
                <div class="col text-end" style="font-size: 0.75em;">
                    <?= "Last Update: " . $row["so_lastupdate"] . "<br>By " . $row["so_editor"]; ?>
                </div>
            </div>
        </div>

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
                <h5 class="text-secondary my-2"><?= $row["match_name"] ?></h5>
            </div>
            <div class="card-body row">
                <div class="col-12 col-md-6">
                    <p class="card-title"><?= "RANGE: " . $row["match_location"] ?></p>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <p class="card-text"><?= "DATE: " . $row["match_begin"] . ' - ' . $row["match_finish"] ?></p>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text"><?= $row["match_detail"] ?></p>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- <div class="col-12 col-md-6">
                                <? //= "DATE: " . $row["match_begin"] . ' - ' . $row["match_finish"] 
                                ?>
                            </div> -->
                    <div class="col-4 col-md-4">
                        <?= "LV: " . $row["match_level"] ?>
                    </div>
                    <div class="col-4 col-md-4 text-center">
                        <?= "STAGES: " . $row["match_stages"] ?>
                    </div>
                    <div class="col-4 col-md-4 text-end">
                        <?= "ROUNDS: " . $row["match_rounds"] ?>
                    </div>
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
                        registered: date
                    </div>
                    <div class="col text-end">
                        lastupdate: date
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
        }

        // * so on duty table show position order by priority
        function so_on_duty_table($m_id)
        {
            global $fnc;
?>
    <div class="mt-4 mb-3">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <?php
                    $sql = "Select v_on_duty.`on-duty_id`, v_on_duty.so_id, v_on_duty.so_idpa_id, v_on_duty.so_firstname, v_on_duty.so_lastname, v_on_duty.so_firstname_en, v_on_duty.so_lastname_en, v_on_duty.so_nickname, v_on_duty.`on-duty_priority`, v_on_duty.`on-duty_position`, v_on_duty.`on-duty_notes` From v_on_duty Where v_on_duty.`on-duty_status` = 'enable' And v_on_duty.match_id = " . $m_id . " order by v_on_duty.`on-duty_priority`, v_on_duty.`on-duty_position`, v_on_duty.`so_firstname`";
                    $fnc->debug_console("on duty table: ", $sql);
                    $dataset = $fnc->get_db_array($sql);
                    ?>
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
            <div class="card-footer text-muted" style="font-size: 0.75em;">
                <div class="row">
                    <div class="col">
                        registered: date
                    </div>
                    <div class="col text-end">
                        lastupdate: date
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
        }

        // * so on duty table show position order by priority
        function so_on_duty($so_id)
        {
            global $fnc;
?>
    <div class="mt-4 mb-3">
        <h4>ประวัติการทำงาน</h4>
        <div class="card">
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
        </div>
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
                <h4 class="text-primary text-uppercase mt-4"><a href="index.php?p=match" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>Match Information</h4>
            </div>
            <div class="col text-end align-self-end">
                <div><a href="?p=duty&mid=<?= $_GET["mid"] ?>" target="_top" class="btn btn-primary text-uppercase">Set Duty</a></div>
            </div>
            <div class="container mt-4">
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

        function duty_form_set($m_id)
        {
            global $fnc;
    ?>
        <div class="container mb-4">
            <h4 class="text-primary text-uppercase mt-4"><a href="index.php?p=matchinfo&mid=<?= $_GET["mid"] ?>" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>Match Information set SO</h4>
            <div class="container mt-4">
                <?php
                $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
                $row = $fnc->get_db_row($sql);
                $fnc->debug_console("match info sql: ", $sql);
                $fnc->debug_console("match info: ", $row);

                match_info($m_id);
                ?>

                <div class="mt-4 mb-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="text-secondary my-1 text-uppercase" style="font-size:0.9em; font-weight:bold;">Form Set on Duty</h5>
                        </div>

                        <div class="card-body p-0">
                            <form method="post" action="db_mgt.php?p=duty&mid=<?= $m_id; ?>">
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

        function duty_form_set_v1($m_id)
        {
            global $fnc;
    ?>
        <div class="container mb-4">
            <h4 class="text-primary text-uppercase mt-4"><a href="index.php?p=match" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>Match Information set SO</h4>
            <div class="container mt-4">
                <?php
                $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
                $row = $fnc->get_db_row($sql);
                $fnc->debug_console("match info sql: ", $sql);
                $fnc->debug_console("match info: ", $row);

                match_info($m_id);
                ?>

                <div class="mt-4 mb-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="text-secondary my-1 text-uppercase" style="font-size:0.9em; font-weight:bold;">Form Set on Duty</h5>
                        </div>

                        <div class="card-body p-0">
                            <form method="post" action="db_mgt.php?p=duty&mid=<?= $m_id; ?>">
                                <div class="row gy-1">
                                    <div class="col-12 col-md-7">
                                        <select name="so_id" class="form-select" size="12" aria-label="size 8 select example" required>
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
                                        <select name="position" class="form-select col-3" size="12" aria-label="size 8 select example" required>
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
                            <form method="post" action="db_mgt.php?p=duty&mid=<?= $m_id; ?>">
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

        function so_list()
        {
            global $fnc;
            $sql_order = NULL;
    ?>
        <div class="container mb-4">
            <div class="row">
                <div class="col">
                    <h4 class="text-primary text-uppercase mt-4">รายชื่อ SO ในระบบฐานข้อมูล <?= "(" . $fnc->get_db_col("SELECT count(`so_id`) as cnt_so FROM `so-member` WHERE `so_status` = 'enable'") . " คน)"; ?></h4>
                </div>
                <div class="col align-self-end text-end">
                    ค้นหา
                </div>
            </div>
            <div>
                <p class="text-mute my-0 py-0" style="font-size: 0.75em;">คลิกหมายเลข idpa เพื่อแสดงข้อมูลสมาชิก idpa.com / คลิกชื่อ เพื่อแสดงรายละเอียดและประวัติการทำงาน / คลิกหัวข้อตารางเพื่อเรียงลำดับ</p>
            </div>
            <table class="table table-light table-striped table-hover">
                <thead>
                    <tr class="table-primary">
                        <th><?php $sql_order .= table_header_sorting("IDPA ID", "so_idpa_id", $sql_order); ?></th>
                        <th><?php $sql_order .= table_header_sorting("FULL NAME", "so_firstname", $sql_order); ?></th>
                        <th><?php $sql_order .= table_header_sorting("NICK", "so_nickname", $sql_order); ?></th>
                        <th><?php $sql_order .= table_header_sorting("PHONE", "so_phone", $sql_order); ?></th>
                        <th class="d-none d-lg-table-cell"><?php $sql_order .= table_header_sorting("EMAIL", "so_email", $sql_order); ?></th>
                        <!-- <th><?php //$sql_order .= table_header_sorting("LINE ID", "so_line_id", $sql_order); 
                                    ?></th> -->
                        <th class="d-none d-lg-table-cell"><?php $sql_order .= table_header_sorting("SO Expr", "so_license_expire", $sql_order); ?></th>
                        <th class="d-none d-md-table-cell text-end">
                            <div><a href="?p=so&act=soadd" target="_top" class="btn btn-primary text-uppercase w-100"><i class="bi bi-person-plus-fill"></i></a></div>
                        </th>
                        <!-- <th>IDPA Expr</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `so-member` WHERE `so_status` = 'enable'";
                    if (isset($sql_order)) {
                        $sql .= $sql_order;
                    }
                    $fnc->debug_console("table so list:", $sql);
                    foreach ($fnc->get_db_array($sql) as $row) {
                        echo '<tr>
                                <td scope="row"><a href="https://www.idpa.com/members/' . $row["so_idpa_id"] . '/" target="_blank">' . $row["so_idpa_id"] . '</a></td>
                                <td><a href="?p=soinfo&soid=' . $row["so_id"] . '" target="_top">' . $row["so_firstname"] . ' ' . $row["so_lastname"] . '</a></td>
                                <td>' . $row["so_nickname"] . '</td>
                                <td>' . $row["so_phone"] . '</td>
                                <td class="d-none d-lg-table-cell">' . $row["so_email"] . '</td>';
                        // echo '<td>' . $row["so_line_id"] . '</td>';
                        // echo '<td>' . $row["so_idpa_expire"] . '</td>';
                        echo '<td style="font-size:0.8em;" class="d-none d-lg-table-cell">';
                        // echo $row["so_license_expire"];
                        if (isset($row["so_license_expire"])) {
                            echo date("M, Y", strtotime($row["so_license_expire"]));
                        }
                        echo '</td>';
                        echo '<td class="text-center d-none d-md-table-cell">' . '<a href="?p=so&act=soedit&soid=' . $row["so_id"] . '" target="_top" class="link-warning"><i class="bi bi-pencil-square"></i></a>' . '<a href="?p=so&&act=sodelete&soid=' . $row["so_id"] . '" target="_top" class="link-danger ps-2">' . '<i class="bi bi-trash-fill"></i>' . '</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>

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
        <div class="container mb-4">
            <div class="row">
                <div class="col">
                    <h4 class="text-primary text-uppercase mt-4">รายชื่อ Match ในระบบฐานข้อมูล <?= "(" . $fnc->get_db_col("SELECT count(`match_id`) as cnt_so FROM `match-idpa` WHERE `match_status` = 'enable'" . $sql_year . $sql_filter) . " รายการ)"; ?></h4>
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
                        echo '<select name="year" class="form-select" aria-label="Default select example" onchange="this.form.submit();">';
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
                                    <td class="d-none d-lg-table-cell"><a href="?p=match&filter=match_md&key=' . $row["match_md"] . '" target="_top">' . $row["match_md"] . '</a></td>
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
    ?>




    </div>

    <script>
        var x = document.getElementById("ip");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "GeoLocation is no supported by this browser.";
            }
        }

        function showPosition(position) {
            x.innerHTML = "Lat: " + position.coords.latitude + "<br>Long: " + position.coords.longitude;
        }
    </script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>