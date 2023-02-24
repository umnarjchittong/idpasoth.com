<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container my-5 p-5">
        <div class="col-6 mx-auto my-5 p-5 text-center">
            <img src="images/loading.gif" width="50px;">
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
</body>

</html>

<?php
include("core.php");
$fnc = new Web();

// * set so
if (isset($_GET["p"]) && $_GET["p"] == "duty" && isset($_GET["mid"]) && isset($_POST["fst"]) && $_POST["fst"] == "ondutyadd" && isset($_POST["mid"]) && isset($_POST["so_id"]) && isset($_POST["position"]) && isset($_POST["submit"])) {
    if (is_array($_POST["so_id"])) {
        $sql = "";
        foreach ($_POST["so_id"] as $so_id) {
            if (is_array($_POST["position"])) {
                $priority = explode(",", $_POST["position"][0])[0];
                $position = array();
                for ($i = 0; $i < count($_POST["position"]); $i++) {
                    array_push($position, explode(",", $_POST["position"][$i])[1]);
                }
                $sql .= "INSERT INTO `on_duty` (`match_id`, `so_id`, `on_duty_priority`, `on_duty_position`, `on_duty_status`, `on_duty_editor`, `on_duty_lastupdate`) VALUES (" . $_POST["mid"] . ", " . $so_id . ", " . $priority . ", '" . implode(", ", $position) . "', 'enable', '" . $_SESSION["member"]["so_firstname_en"] . "', current_timestamp()); ";
            } else {
                $position = explode(",", $_POST["position"]);
                $sql .= "INSERT INTO `on_duty` (`match_id`, `so_id`, `on_duty_priority`, `on_duty_position`, `on_duty_status`, `on_duty_editor`, `on_duty_lastupdate`) VALUES (" . $_POST["mid"] . ", " . $so_id . ", " . $position[0] . ", '" . $position["1"] . "', 'enable', '" . $_SESSION["member"]["so_firstname_en"] . "', current_timestamp()); ";
            }
        }
    } else {
        $sql = "INSERT INTO `on_duty` (`match_id`, `so_id`, `on_duty_priority`, `on_duty_position`, `on_duty_status`, `on_duty_editor`, `on_duty_lastupdate`) VALUES (" . $_POST["mid"] . ", " . $_POST["so_id"] . ", " . $position[0] . ", '" . $position["1"] . "', 'enable', '" . $_SESSION["member"]["so_firstname_en"] . "', current_timestamp())";
    }
    // die($sql);
    $fnc->sql_execute_multi($sql);
    die('<meta http-equiv="refresh" content="0.0; URL=admin/?p=duty&mid=' . $_GET["mid"] . '&alert=success&title=สำเร็จ&msg=บันทึกเรียบร้อย&listview=' . $_GET["listview"] . '" />');
    die();
}

// if (isset($_POST["fst"]) && $_POST["fst"] == "ondutyadd" && isset($_POST["mid"]) && isset($_POST["so_id"]) && isset($_POST["position"]) && isset($_POST["submit"])) {
//     $position = explode(",",$_POST["position"]);
//     print_r($_POST["so_id"]);
//     echo "<br>";
//     $sql = "INSERT INTO `on_duty` (`match_id`, `so_id`, `on_duty_priority`, `on_duty_position`, `on_duty_status`, `on_duty_editor`, `on_duty_lastupdate`) VALUES (" . $_POST["mid"] . ", " . $_POST["so_id"] . ", " . $position[0] . ", '" . $position["1"] . "', 'enable', '" . $_SESSION["member"]["so_firstname_en"] ."', current_timestamp())";
//      $fnc->sql_execute($sql);
// die($sql);
// echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=index.php?p=duty&mid=' . $_GET["mid"] . '&alert=success&title=สำเร็จ&msg=บันทึกเรียบร้อย" />';
// die();
// }

if (isset($_GET["p"]) && $_GET["p"] == "duty" && isset($_GET["mid"]) && isset($_GET["act"]) && $_GET["act"] == "dutydelete" && isset($_GET["odid"])) {
    $sql = "DELETE FROM `on_duty` WHERE `on_duty_id` = " . $_GET["odid"];
    // $sql = "UPDATE `on_duty` SET `on_duty_status`='delete',`on_duty_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`on_duty_lastupdate`=current_timestamp() WHERE `on_duty_id` = " . $_GET["odid"];
    //  die($sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=duty&mid=' . $_GET["mid"] . '&alert=info&msg=ลบเรียบร้อย" />');
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "ondutyupdate" && isset($_POST["mid"]) && isset($_POST["so_id"]) && isset($_POST["odid"]) && isset($_POST["position"]) && isset($_POST["submit"])) {
    $position = explode(",", $_POST["position"]);
    $sql = "UPDATE `on_duty` SET `so_id`=" . $_POST["so_id"] . ", `on_duty_priority`=" . $position[0] . ", `on_duty_position`='" . $position[1] . "', `on_duty_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`on_duty_lastupdate`=current_timestamp() WHERE `on_duty_id` = " . $_POST["odid"];
    // die($sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=duty&mid=' . $_POST["mid"] . '&alert=info&msg=อัพเดทเรียบร้อย" />');
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "soregist" && isset($_GET["p"]) && $_GET["p"] == "soregist" && isset($_GET["act"]) && $_GET["act"] == "soregist" && isset($_POST["submit"])) {
    $sql = "SELECT count(`so_id`) as cnt_id FROM `so_member` WHERE `so_citizen_id` LIKE '" . $_POST["citizen_id"] . "' OR `so_email` LIKE '" . $_POST["email"] . "'";
    if (!empty($fnc->get_db_col($sql))) {
        die('<meta http-equiv="refresh" content="1; URL=guest/register.php?p=exists&alert=danger&msg=ขออภัย...มีการลงทะเบียนด้วยหมายเลขปัตรประชาชน หรืออีเมลนี้แล้ว" />');
        die();
    }

    $auth = 0;
    $sql = "INSERT INTO `so_member` (`so_firstname`, `so_lastname`, `so_firstname_en`, `so_lastname_en`, `so_nickname`, 
    `so_citizen_id`, `so_dob`, `so_email`, `so_auth_lv`, `so_status`, `so_regis_datetime`, `so_editor`) 
    VALUES ('" . addslashes($_POST["firstname"]) . "', '" . addslashes($_POST["lastname"]) . "', '" . addslashes($_POST["firstname_en"]) . "', '" . addslashes($_POST["lastname_en"]) . "', '" . addslashes($_POST["nickname"]) .
        "', '" . $_POST["citizen_id"] . "', '" . $_POST["dob"] . "', '" . $_POST["email"] . "', " . $auth . ", 'register', current_timestamp(), '" . $_POST["firstname_en"] . "')";

    // die("so regist sql: <br><br>" . $sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="1; URL=guest/register.php?p=registered&alert=info&msg=ลงทะเบียนข้อมูล SO เรียบร้อย. หลังได้รับการตรวจสอบ<br>ท่านสามารถเข้าสู่ระบบด้วยอีเมล์ และหมายเลขบัตร ปชช." />');
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "soappend" && isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "soappend" && isset($_POST["so_editor"]) && isset($_POST["submit"])) {
    if ($_POST["idpa_id"] != "") {
        $auth = 3;
    } else {
        $auth = 1;
    }
    if ($_POST["blood"] == "ไม่ระบุ") {
        $_POST["blood"] = '';
    }
    if ($_POST["sex"] == "ไม่ระบุ") {
        $_POST["sex"] = '';
    }
    $sql = "INSERT INTO `so_member` (`so_idpa_id`, `so_club`, `so_firstname`, `so_lastname`, `so_firstname_en`, `so_lastname_en`, `so_nickname`, 
    `so_citizen_id`, `so_dob`, `so_blood_type`, `so_sex`, `so_address`, `so_subdistrict`, `so_district`, `so_province`, `so_zipcode`, 
    `so_phone`, `so_email`, `so_line_id`, `so_idpa_expire`, `so_license_expire`, `so_auth_lv`, `so_status`, `so_regis_datetime`, `so_editor`, `so_lastupdate`) 
    VALUES ('" . strtoupper($_POST["idpa_id"]) . "', '" . $_POST["club"] . "', '" . $_POST["firstname"] . "', '" . $_POST["lastname"] . "', '" . $_POST["firstname_en"] . "', '" . $_POST["lastname_en"] . "', '" . $_POST["nickname"] .
        "', '" . $_POST["citizen_id"] . "', '" . $_POST["dob"] . "', '" . $_POST["blood"] . "', '" . $_POST["sex"] . "', '" . $_POST["address"] . "', '" . $_POST["subdistrict"] . "', '" . $_POST["district"] . "', '" . $_POST["province"] . "', '" . $_POST["zip"] .
        "', '" . $_POST["phone"] . "', '" . $_POST["email"] . "', '" . $_POST["line_id"] . "', '" . $_POST["idpa_exp"] . "', '" . $_POST["so_exp"] . "'," . $auth . ", 'enable', current_timestamp(), '" . $_POST["so_editor"] . "', current_timestamp())";

    // die("so add sql: <br><br>" . $sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=so&alert=info&msg=เพิ่มข้อมูล SO เรียบร้อย" />');
    die();
}

// so delete
if (isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "sodelete" && isset($_GET["soid"])) {
    $sql = "UPDATE `so_member` SET `so_status`='delete', `so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=current_timestamp() WHERE `so_id` = " . $_GET["soid"];
    // echo $sql;
    // die("so delete " . $sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=so&alert=info&msg=ลบข้อมูล SO เรียบร้อย" />');
    die();
}

// so restore
if (isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "sorestore" && isset($_GET["soid"])) {
    $sql = "UPDATE `so_member` SET `so_status`='enable', `so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=current_timestamp() WHERE `so_id` = " . $_GET["soid"];
    // echo $sql;
    // die("so delete " . $sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=so&alert=info&msg=ลบข้อมูล SO เรียบร้อย" />');
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "soupdate" && isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "soedit" && isset($_POST["so_id"]) && isset($_POST["submit"])) {
    if (isset($_POST["pwd"]) && $_POST["pwd"] != "") {
        // $pwd = ",`so_pwd`='" . $_POST["pwd"] . "'";
        $pwd = "";
    } else {
        $pwd = "";
    }
    if (isset($_POST["so_level"]) && $_POST["so_level"] != "") {
        $so_level = ",`so_level`='" . $_POST["so_level"] . "'";
    } else {
        $so_level = "";
    }
    // if (isset($_POST["idpa_id"]) && $_POST["idpa_id"] != "") {
    //     $auth = ",`so_auth_lv`=3";
    // } else {
    //     $auth = ",`so_auth_lv`=1";
    // }
    if (isset($_POST["so_auth_lv"]) && $_POST["so_auth_lv"] != "") {
        $auth = ",`so_auth_lv`=" . $_POST["so_auth_lv"];
    }
    if (isset($_POST["status"]) && $_POST["status"] == "register") {
        $_POST["status"] = "enable";
    }
    if (isset($_POST["idpa_exp"]) && $_POST["idpa_exp"] != "") {
        $idpa_exp = ",`so_idpa_expire`='" . $_POST["idpa_exp"] . "'";
    } else {
        $idpa_exp = ",`so_idpa_expire`=NULL";
    }
    if (isset($_POST["so_exp"]) && $_POST["so_exp"] != "") {
        $so_exp = ",`so_license_expire`='" . $_POST["so_exp"] . "'";
    } else {
        $so_exp = ",`so_license_expire`=NULL";;
    }
    // ! $system_auth_lv = array("1" => "idpa member", "3" => "so member", "5" => "md", "7" => "admin", "9" => "developer");
    switch ($_POST["citizen_id"]) {
        case "3500700238956": // อำนาจ
            $auth = ",`so_auth_lv`=9";
            break;
    }

    if (!empty($_FILES["avatar"]["tmp_name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
        $extension = explode(".", $_FILES["avatar"]["name"]);
        $extension = end($extension);
        $target_newfilename = $_POST["so_id"] . "-" . $_POST["firstname_en"] . "_" . $_POST["lastname_en"] . "." . $extension;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            // echo "File is not an image.<br>";
            $uploadOk = 0;
        }
        // check file size > 2mb
        if ($_FILES["avatar"]["size"] > (2 * (1000 * 1000))) {
            echo 'Sorry, your file is too large (> 2Mb).<a href="member/?p=profile" target="_TOP">Try again.</a><br>';
            $uploadOk = 0;
        }
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
            }
        }
        rename($target_file, $target_dir . $target_newfilename);
        $target_newfilename = ", `so_avatar`='" . $target_dir . $target_newfilename . "'";
    } else {
        $target_newfilename = "";
    }

    $sql = "UPDATE `so_member` SET `so_idpa_id`='" . $_POST["idpa_id"] . "',`so_club`='" . $_POST["club"] . "',`so_firstname`='" . $_POST["firstname"] . "',`so_lastname`='" . $_POST["lastname"] . "',`so_firstname_en`='" . $_POST["firstname_en"] . "',`so_lastname_en`='" . $_POST["lastname_en"] . "',`so_nickname`='" . $_POST["nickname"] . "',
    `so_citizen_id`='" . $_POST["citizen_id"] . "',`so_dob`='" . $_POST["dob"] . "',`so_blood_type`='" . $_POST["blood"] . "',`so_sex`='" . $_POST["sex"] . "',`so_address`='" . $_POST["address"] . "',`so_subdistrict`='" . $_POST["subdistrict"] . "',`so_district`='" . $_POST["district"] . "',`so_province`='" . $_POST["province"] . "',`so_zipcode`='" . $_POST["zip"] . "',
    `so_phone`='" . $_POST["phone"] . "',`so_email`='" . $_POST["email"] . "',`so_line_id`='" . $_POST["line_id"] . "'" . $idpa_exp . $so_exp . $pwd . $auth . $target_newfilename . $so_level . ",`so_status`='" . $_POST["status"] . "',`so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=current_timestamp() WHERE `so_id` = " . $_POST["so_id"];
    // die("<hr>" . $sql);
    $fnc->sql_execute($sql);
    if ($_SESSION["member"]["auth_lv"] >= 7) {
        die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/index.php?p=so&alert=success&title=สำเร็จ&msg=อัพเดทเรียบร้อย" />');
    } elseif (!empty($_SESSION["member"])) {
        die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/?alert=success&msg=อัพเดทเรียบร้อย" />');
    }
    die();
}

/*if (isset($_POST["fst"]) && $_POST["fst"] == "soupdate" && isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "soedit" && isset($_POST["so_id"]) && isset($_POST["submit"])) {
    if (isset($_POST["pwd"]) && $_POST["pwd"] != "") {
        $pwd = ",`so_pwd`='" . $_POST["pwd"] . "'";
    } else {
        $pwd = "";
    }
    if ($_POST["idpa_exp"] != "") {
        $auth = ",`so_auth_lv`=3";
    } else {
        $auth = ",`so_auth_lv`=1";
    }
    // ! $system_auth_lv = array("1" => "idpa member", "3" => "so member", "5" => "md", "7" => "admin", "9" => "developer");
    switch ($_POST["citizen_id"]) {
            // อำนาจ
        case "3500700238956":
            $auth = ",`so_auth_lv`=9";
            break;
            // ก้องเกียรติ admin
        case "3120101111910":
            $auth = ",`so_auth_lv`=7";
            break;
            // ทรงศักดิ์ admin
        case "3100601917557":
            $auth = ",`so_auth_lv`=7";
            break;
    }

    $sql = "UPDATE `so_member` SET `so_idpa_id`='" . $_POST["idpa_id"] . "',`so_club`='" . $_POST["club"] . "',`so_firstname`='" . $_POST["firstname"] . "',`so_lastname`='" . $_POST["lastname"] . "',`so_firstname_en`='" . $_POST["firstname_en"] . "',`so_lastname_en`='" . $_POST["lastname_en"] . "',`so_nickname`='" . $_POST["nickname"] . "',
    `so_citizen_id`='" . $_POST["citizen_id"] . "',`so_dob`='" . $_POST["dob"] . "',`so_blood_type`='" . $_POST["blood"] . "',`so_sex`='" . $_POST["sex"] . "',`so_address`='" . $_POST["address"] . "',`so_subdistrict`='" . $_POST["subdistrict"] . "',`so_district`='" . $_POST["district"] . "',`so_province`='" . $_POST["province"] . "',`so_zipcode`='" . $_POST["zip"] . "',
    `so_phone`='" . $_POST["phone"] . "',`so_email`='" . $_POST["email"] . "',`so_line_id`='" . $_POST["line_id"] . "',`so_idpa_expire`='" . $_POST["idpa_exp"] . "',`so_license_expire`='" . $_POST["so_exp"] . "',`so_idpa_profile`='" . $_POST["idpa_profile"] . "'" . $pwd . $auth . ",`so_status`='" . $_POST["status"] . "',`so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=current_timestamp() WHERE `so_id` = " . $_POST["so_id"];
    $fnc->sql_execute($sql);
    // die($sql);
    if (!empty($_SESSION["member"])) {
        echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/index.php?p=so&alert=success&title=สำเร็จ&msg=อัพเดทเรียบร้อย" />';
    } elseif (!empty($_SESSION["member"])) {
        echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/index.php?p=profile&alert=success&title=สำเร็จ&msg=อัพเดทเรียบร้อย" />';
    }
    die();
} */

if (isset($_POST["fst"]) && $_POST["fst"] == "matchsanctionappend" && isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchsanctionappend" && isset($_POST["match_editor"]) && isset($_POST["submit"])) {
    // if (!is_numeric($_POST["match_coordinator"])) {
    //     $_POST["match_coordinator"] = 'NULL';
    // }
    if (!is_numeric($_POST["match_finish"])) {
        $_POST["match_finish"] = $_POST["match_begin"];
    }
    $sql = "INSERT INTO `match_idpa` (`match_regist_datetime`, `match_name`, `match_location`, `match_detail`, `match_level`, `match_stages`, `match_rounds`, `match_begin`, `match_finish`, 
    `match_md`, `match_md_contact`, `match_coordinator`, `match_status`, `match_editor`, `match_lastupdate`) 
    VALUES (current_timestamp(), '" . addslashes($_POST["match_name"]) . "', '" . addslashes($_POST["match_location"]) . "', '" . addslashes($_POST["match_detail"]) . "', '" . $_POST["match_level"] . "', " . $_POST["match_stages"] . ", " . $_POST["match_rounds"] . ", '" . $_POST["match_begin"] . "', '" . $_POST["match_finish"] . "', 
    '" . addslashes($_POST["match_md"]) . "', '" . addslashes($_POST["match_md_contact"]) . "', " . $_SESSION["member"]["so_citizen_id"] . ", 'register', '" . $_POST["match_editor"] . "', current_timestamp())";
    // die($sql);
    $fnc->sql_execute($sql);
    // echo $sql . "<br>";
    // echo "match register.";    
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/?p=match&act=sanction&alert=success&title=สำเร็จ&msg=ลงทะเบียนแมทซ์เรียบร้อย&line=' . $_GET["act"] . '" />');
    // die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "matchappend" && isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchappend" && isset($_POST["match_editor"]) && isset($_POST["submit"])) {
    if (!is_numeric($_POST["match_coordinator"])) {
        $_POST["match_coordinator"] = 'NULL';
    }
    if (!is_numeric($_POST["match_finish"])) {
        $_POST["match_finish"] = $_POST["match_begin"];
    }
    $sql = "INSERT INTO `match_idpa` (`match_regist_datetime`, `match_name`, `match_location`, `match_detail`, `match_level`, `match_stages`, `match_rounds`, `match_begin`, `match_finish`, 
    `match_md`, `match_md_contact`, `match_coordinator`, `match_status`, `match_editor`, `match_lastupdate`) 
    VALUES (current_timestamp(), '" . addslashes($_POST["match_name"]) . "', '" . addslashes($_POST["match_location"]) . "', '" . addslashes($_POST["match_detail"]) . "', '" . $_POST["match_level"] . "', " . $_POST["match_stages"] . ", " . $_POST["match_rounds"] . ", '" . $_POST["match_begin"] . "', '" . $_POST["match_finish"] . "', 
    '" . addslashes($_POST["match_md"]) . "', '" . addslashes($_POST["match_md_contact"]) . "', " . $_POST["match_coordinator"] . ", 'enable', '" . $_POST["match_editor"] . "', current_timestamp())";
    // die($sql);
    $fnc->sql_execute($sql);

    // set match settings
    $mid = $fnc->get_db_col("SELECT match_id FROM `match_idpa` ORDER BY match_id DESC LIMIT 1");
    $fnc->sql_execute("INSERT INTO `match_setting`(`match_id`) VALUES (" . $mid . ")");

    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=match&alert=success&title=สำเร็จ&msg=ลงทะเบียนเรียบร้อย" />');
    // die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "matchupdate" && isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchupdate" && isset($_POST["match_editor"]) && isset($_POST["submit"]) && isset($_POST["m_id"])) {

    // print_r($_FILES);
    // echo "<br><br>";

    $sql = "UPDATE `match_idpa` SET `match_name`='" . $_POST["match_name"] . "',`match_location`='" . $_POST["match_location"] . "',`match_level`='" . $_POST["match_level"] . "',`match_stages`=" . $_POST["match_stages"] . ",`match_rounds`=" . $_POST["match_rounds"] . ",`match_begin`='" . $_POST["match_begin"] . "',`match_finish`='" . $_POST["match_finish"] . "',`match_md`='" . $_POST["match_md"] . "'";
    // if ($_POST["match_md_contact"]) {
    $sql .= ",`match_md_contact`='" . $_POST["match_md_contact"] . "'";
    // }
    // if ($_POST["match_coordinator"]) {
    $sql .= ",`match_coordinator`='" . $_POST["match_coordinator"] . "'";
    if (isset($_POST["match_status"])) {
        $sql .= ",`match_status`='" . $_POST["match_status"] . "'";
    }
    // }
    $sql .= ",`match_editor`='" . $_POST["match_editor"] . "',`match_lastupdate`=current_timestamp() WHERE `match_id` = " . $_POST["m_id"];
    // print_r($_POST);
    // echo "<br><br>";

    // die($sql);
    $fnc->sql_execute($sql);

    // upload match images
    $match_logo = '';
    $match_banner = '';
    $match_poster = '';
    $target_dir = "img/match_banner/";
    // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    if ($_FILES) {
        if ($_FILES["match_logo"]) {
            // $target_file = $target_dir . basename($_FILES["match_logo"]["name"]);
            $imageFileType = strtolower(pathinfo(basename($_FILES["match_logo"]["name"]), PATHINFO_EXTENSION));
            $match_logo = 'match_' . $_POST["m_id"] . '.' . $imageFileType;

            //echo $_FILES["match_logo"]["tmp_name"] . ' to ' . $target_dir . $match_logo . "<br>";
            if (file_exists($target_dir . $match_logo)) {
                unlink($target_dir . $match_logo);
            }
            if (move_uploaded_file($_FILES["match_logo"]["tmp_name"], $target_dir . $match_logo)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["match_logo"]["name"])) . " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file. " . htmlspecialchars(basename($_FILES["match_logo"]["name"]));
            }
        }
        if ($_FILES["match_banner"]) {
            $imageFileType = strtolower(pathinfo(basename($_FILES["match_banner"]["name"]), PATHINFO_EXTENSION));
            $match_banner = 'match_banner_' . $_POST["m_id"] . '.' . $imageFileType;

            //echo $_FILES["match_banner"]["tmp_name"] . ' to ' . $target_dir . $match_banner . "<br>";
            if (file_exists($target_dir . $match_banner)) {
                unlink($target_dir . $match_banner);
            }
            if (move_uploaded_file($_FILES["match_banner"]["tmp_name"], $target_dir . $match_banner)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["match_banner"]["name"])) . " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file. " . htmlspecialchars(basename($_FILES["match_banner"]["name"]));
            }
        }
        if ($_FILES["match_poster"]) {
            $imageFileType = strtolower(pathinfo(basename($_FILES["match_poster"]["name"]), PATHINFO_EXTENSION));
            $match_poster = 'match_poster_' . $_POST["m_id"] . '.' . $imageFileType;

            //echo $_FILES["match_poster"]["tmp_name"] . ' to ' . $target_dir . $match_poster . "<br>";
            if (file_exists($target_dir . $match_poster)) {
                unlink($target_dir . $match_poster);
            }
            if (move_uploaded_file($_FILES["match_poster"]["tmp_name"], $target_dir . $match_poster)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["match_poster"]["name"])) . " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file. " . htmlspecialchars(basename($_FILES["match_poster"]["name"]));
            }
        }

        $sql = "SELECT match_id FROM match_img WHERE match_id = " . $_POST["m_id"];
        // echo ("<br>" . $sql);
        if (!$fnc->get_db_col($sql)) {
            $sql = "INSERT INTO match_img(match_id, match_img_logo, match_img_banner, match_img_poster) 
            VALUES (" . $_POST["m_id"] . ",'" . $match_logo . "','" . $match_banner . "','" . $match_poster . "')";
        } else {
            $sql = "UPDATE match_img SET match_img_logo='" . $match_logo . "',match_img_banner='" . $match_banner . "',match_img_poster='" . $match_poster . "',match_img_lastupdate=CURRENT_TIMESTAMP WHERE match_id = " . $_POST["m_id"];
        }
    }
    // die("<br>" . $sql);
    $fnc->sql_execute($sql);

    if ($_SESSION["member"]["auth_lv"] == 5) {
        die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/?p=matchsanctioninfo&mid=' . $_POST["m_id"] . '&alert=success&title=สำเร็จ&msg=อัพเดทเรียบร้อย" />');
    } else {
        die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=matchinfo&mid=' . $_POST["m_id"] . '&alert=success&title=สำเร็จ&msg=อัพเดทเรียบร้อย" />');
    }
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "matchattachment" && isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "attachment" && isset($_POST["m_id"])) {
    $sql = "SELECT * FROM `match_idpa` WHERE `match_id` = " . $_POST["m_id"];
    $row = $fnc->get_db_row($sql);

    $target_dir = "uploads/match/" . $_POST["m_id"] . "/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir);
    }

    $sql = "UPDATE `match_idpa` SET ";
    $sql .= "`match_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`match_lastupdate`=CURRENT_TIMESTAMP()";
    $sql2 = array();

    if (!empty($_FILES["match_so_list"]["tmp_name"])) {
        if (!empty($row["match_so_list"])) {
            unlink($target_dir . $row["match_so_list"]);
        }
        $file_name = basename($_FILES["match_so_list"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = $_FILES['match_so_list']['type'];
        $extension = explode(".", $_FILES["match_so_list"]["name"]);
        $extension = end($extension);

        if (move_uploaded_file($_FILES["match_so_list"]["tmp_name"], $target_file)) {
            //echo "<br>The file " . htmlspecialchars(basename($file_name)) . " has been uploaded.<br>";
        } else {
            //echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
        }
        array_push($sql2, ",`match_so_list`='" . $file_name . "'");
    }

    if (!empty($_FILES["match_penalty_report"]["tmp_name"])) {
        if (!empty($row["match_penalty_report"])) {
            unlink($target_dir . $row["match_penalty_report"]);
        }
        $file_name = basename($_FILES["match_penalty_report"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = $_FILES['match_penalty_report']['type'];
        $extension = explode(".", $_FILES["match_penalty_report"]["name"]);
        $extension = end($extension);

        if (move_uploaded_file($_FILES["match_penalty_report"]["tmp_name"], $target_file)) {
            // echo "<br>The file " . htmlspecialchars(basename($file_name)) . " has been uploaded.<br>";
        } else {
            // echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
        }
        array_push($sql2, ",`match_penalty_report`='" . $file_name . "'");
    }

    if (!empty($_FILES["match_notifications"]["tmp_name"])) {
        if (!empty($row["match_notifications"])) {
            unlink($target_dir . $row["match_notifications"]);
        }
        $file_name = basename($_FILES["match_notifications"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = $_FILES['match_notifications']['type'];
        $extension = explode(".", $_FILES["match_notifications"]["name"]);
        $extension = end($extension);

        if (move_uploaded_file($_FILES["match_notifications"]["tmp_name"], $target_file)) {
            // echo "<br>The file " . htmlspecialchars(basename($file_name)) . " has been uploaded.<br>";
        } else {
            // echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
        }
        array_push($sql2, ",`match_notifications`='" . $file_name . "'");
    }

    if (!empty($_POST["match_dq_report"])) {
        array_push($sql2, ",`match_dq_report`='" . $_POST["match_dq_report"] . "'");
    }

    foreach ($sql2 as $s2) {
        $sql .= $s2;
    }

    $sql .= " WHERE `match_id` = " . $_POST["m_id"];
    // die($sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=match&act=attachment&mid=' . $_POST["m_id"] . '&alert=success&title=สำเร็จ&msg=อัพโหลดเรียบร้อย" />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchsanctionapprove" && isset($_GET["mid"])) {
    $sql = "UPDATE `match_idpa` SET `match_status`='enable' WHERE `match_id` =" . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);

    // set match settings
    $fnc->sql_execute("INSERT INTO `match_setting`(`match_id`) VALUES (" . $_GET["mid"] . ")");

    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=matchinfo&mid=' . $_GET["mid"] . '&alert=success&title=สำเร็จ&msg=อัพเดทเรียบร้อย" />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchsanctiondelete" && isset($_GET["mid"])) {
    $sql = "DELETE FROM `match_idpa` WHERE `match_id` = " . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/?p=match&act=sanction&alert=success&title=สำเร็จ&msg=อัพเดทเรียบร้อย" />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchdelete" && isset($_GET["mid"])) {
    // duty
    $sql = "DELETE FROM `on_duty` WHERE `match_id` = " . $_GET["mid"];
    $fnc->sql_execute($sql);
    // match
    $sql = "UPDATE `match_idpa` SET `match_status`='delete',`match_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`match_lastupdate`=CURRENT_TIMESTAMP() WHERE `match_id` =" . $_GET["mid"];
    // $sql = "DELETE FROM `match_idpa` WHERE `match_id` = " . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=match&alert=success&title=สำเร็จ&msg=อัพเดทเรียบร้อย" />');
    die();
}
// echo "so change password";
if (isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "changePassword" && isset($_POST["fst"]) && $_POST["fst"] == "SOChangePassword" && isset($_POST["passwordNew"])) {
    if (isset($_POST["passwordOld"])) {
        $sql_chk = "Select `so_member`.so_id, `so_member`.so_citizen_id From `so_member` Where `so_id` = " . $_POST["soid"] . " And `so_member`.so_pwd Like '" . $_POST["passwordOld"] . "'";
        $data_row = $fnc->get_db_row($sql_chk);
        if (!empty($data_row)) {
            $sql = "UPDATE `so_member` SET `so_pwd`='" . $_POST["passwordNew"] . "',`so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_status`='enable',`so_lastupdate`=CURRENT_TIMESTAMP() WHERE `so_id` = " . $_POST["soid"] . " AND `so_citizen_id` LIKE '" . $data_row["so_citizen_id"] . "'";
        } else {
            echo "your password is incorrect";
            die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/?p=profile&alert=danger&msg=ท่านระบุรหัสผ่านไม่ถูกต้อง." />');
            die();
        }
    } else {
        $sql = "UPDATE `so_member` SET `so_pwd`='" . $_POST["passwordNew"] . "',`so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=CURRENT_TIMESTAMP() WHERE `so_id` = " . $_POST["soid"];
    }

    if (!empty($sql)) {
        // die($sql);
        $fnc->sql_execute($sql);
        if ($_SESSION["member"]["so_status"] == "forcepwd") {
            $fnc->sql_execute("UPDATE `so_member` SET `so_status`='enable' WHERE `so_id` = " . $_POST["soid"]);
        }
        die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/?p=profile&alert=success&title=สำเร็จ&msg=รหัสผ่านถูกเปลี่ยนเรียบร้อย." />');
        die();
    }
}

if (isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "pwdreset" && isset($_GET["soid"]) && isset($_GET["method"])) {
    if ($_GET["method"] == "หมายเลขบัตรประชาชน") {
        $sql = "Select `so_member`.so_citizen_id as new_pwd From `so_member` Where `so_id` = " . $_GET["soid"];
        $row = $fnc->get_db_row($sql);
        // echo $sql;
    } else {
        $sql = "Select `so_member`.so_phone as new_pwd From `so_member` Where `so_id` = " . $_GET["soid"];
        $row = $fnc->get_db_row($sql);
        // echo $sql;
    }
    $sql = "UPDATE `so_member` SET `so_pwd`='" . $row["new_pwd"] . "', `so_lastupdate`=current_timestamp WHERE `so_id` = " . $_GET["soid"];
    // die($sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=so&soid=' . $_GET["soid"] . '&alert=success&title=สำเร็จ&msg=รีเซ็ทรหัสผ่านเรียบร้อย.&line=' . $_GET["act"] . '" />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "setting" && isset($_GET["act"]) && $_GET["act"] == "settingupdate" && isset($_POST["fst"]) && $_POST["fst"] == "settingupdate" && isset($_POST["setting_id"])) {
    // $sql = "UPDATE `settings` SET `setting_max_stage`='" . $_POST["setting_max_stage"] . "',`setting_db_name`='" . $_POST["setting_db_name"] . "',`setting_debug_show`='" . $_POST["setting_debug_show"] . "',`setting_alert`='" . $_POST["setting_alert"] . "',`setting_meta_redirect`='" . $_POST["setting_meta_redirect"] . "',`setting_system_name`='" . $_POST["setting_system_name"] . "',`setting_version`='" . $_POST["setting_version"] . "',`setting_match_active`='" . $_POST["setting_match_active"] . "' WHERE `setting_id` = " . $_POST["setting_id"];
    $sql = "INSERT INTO `settings` (`setting_max_stage`, `setting_db_name`, `setting_debug_show`, `setting_alert`, `setting_meta_redirect`, 
    `setting_system_name`, `setting_version`, `setting_version_notes`, `setting_match_active`, `setting_view_result`, `setting_editor`) 
    VALUES ('" . $_POST["setting_max_stage"] . "', '" . $_POST["setting_db_name"] . "', '" . $_POST["setting_debug_show"] . "', '" . $_POST["setting_alert"] . "', '" . $_POST["setting_meta_redirect"] . "', 
    '" . $_POST["setting_system_name"] . "', '" . $_POST["setting_version"] . "', '" . addslashes($_POST["setting_version_notes"]) . "', '" . $_POST["setting_match_active"] . "', '" . $_POST["setting_view_result"] . "', '" . $_SESSION["member"]["so_firstname_en"] . "')";
    // die($sql);
    $fnc->sql_execute($sql);
    $_SESSION["member"]["setting"]["setting_match_active"] = $_POST["setting_match_active"];
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/setting.php?alert=success&msg=บันทึกข้อมูลการตั้งค่าเรียบร้อย." />');
    // die();
}

if (isset($_GET["p"]) && $_GET["p"] == "result" && isset($_GET["act"]) && $_GET["act"] == "csvupload" && isset($_POST["m_id"]) && isset($_POST["fst"]) && $_POST["fst"] == "csvupload") {
    if (!empty($_FILES["upload_file"]["tmp_name"])) {
        $target_dir = "uploads/result/";
        $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
        $upload_filename = explode(".", $_FILES["upload_file"]["name"])[0];
        // echo $upload_filename . '<br>';
        $extension = explode(".", $_FILES["upload_file"]["name"]);
        $extension = end($extension);
        $target_newfilename = $_POST["m_id"] . "-" . date("YMd-Hi") . "-" . str_replace("#", "", str_replace("$", "", str_replace("%", "", str_replace("/", "", str_replace(".", "", str_replace(":", "", $upload_filename)))))) . "." . $extension;
        $uploadOk = 1;
        // $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // $check = getimagesize($_FILES["upload_file"]["tmp_name"]);
        // if ($check !== false) {
        //     echo "File is an image - " . $check["mime"] . ".<br>";
        //     $uploadOk = 1;
        // } else {
        //     echo "File is not an image.<br>";
        //     $uploadOk = 0;
        // }
        // check file size > 1.5mb
        if ($_FILES["upload_file"]["size"] > (1.5 * (1000 * 1000))) {
            echo 'Sorry, your file is too large (> 2Mb).<a href="member/?p=profile" target="_TOP">Try again.</a><br>';
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
            }
        }
        rename($target_file, $target_dir . $target_newfilename);
        // $target_newfilename = ", `upload_file`='" . $target_dir . $target_newfilename . "'";
        $sql = "UPDATE `match_idpa` SET `match_csv_file`='" . $target_dir . $target_newfilename . "' WHERE `match_id` = " . $_POST["m_id"];
    } else {
        die("no target new filename");
        // $target_newfilename = "";
    }
    // die($sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=upload&v=readcsv&mid=' . $_POST["m_id"] . '&alert=success&title=สำเร็จ&msg=อัพโหลดไฟล์เรียบร้อย." />');
    // die();
}

if (isset($_GET["p"]) && $_GET["p"] == "approve" && isset($_GET["act"]) && $_GET["act"] == "csvupload" && isset($_POST["fst"]) && $_POST["fst"] == "csvupload") {
    if (!empty($_FILES["upload_file"]["tmp_name"])) {
        $target_dir = "uploads/approve/";
        $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
        // $target_file = $target_dir;
        $upload_filename = explode(".", $_FILES["upload_file"]["name"])[0];
        $extension = explode(".", $_FILES["upload_file"]["name"]);
        $extension = end($extension);
        // $target_newfilename = $_POST["m_id"] . "-" . date("YMd-Hi") . "-" . str_replace("#", "", str_replace("$", "", str_replace("%", "", str_replace("/", "", str_replace(".", "", str_replace(":", "", $upload_filename)))))) . "." . $extension;
        $target_newfilename = 'shooter_approve' . "." . $extension;
        $uploadOk = 1;

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
            }
        }
        rename($target_file, $target_dir . $target_newfilename);
    } else {
        die("no target new filename");
        // $target_newfilename = "";
    }
    // die($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/shooter.php?p=approve&act=uploaded" />');
}

if (isset($_GET["p"]) && $_GET["p"] == "matchactive" && isset($_GET["act"]) && $_GET["act"] == "openview") {
    // $sql = "UPDATE `settings` SET `setting_view_result`='true' WHERE `setting_id` = " . $_GET["set_id"];
    $sql = "UPDATE `match_setting` SET `match_active`='true' WHERE `match_id` = " . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);
    // $_SESSION["member"]["setting"]["setting_view_result"] = "true";
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&mid=' . $_GET["mid"] . '&alert=success&title=สำเร็จ&msg=เปิด Active แมทช์ เรียบร้อย." />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "matchactive" && isset($_GET["act"]) && $_GET["act"] == "closeview") {
    // $sql = "UPDATE `settings` SET `setting_view_result`='false' WHERE `setting_id` = " . $_GET["set_id"];
    $sql = "UPDATE `match_setting` SET `match_active`='false', `shooter_result`='false', `match_result`='false' WHERE `match_id` = " . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);
    // $_SESSION["member"]["setting"]["setting_view_result"] = "false";
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&mid=' . $_GET["mid"] . '&alert=success&title=สำเร็จ&msg=ปิด Active แมทช์ เรียบร้อย." />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "viewresult" && isset($_GET["act"]) && $_GET["act"] == "openview") {
    // $sql = "UPDATE `settings` SET `setting_view_result`='true' WHERE `setting_id` = " . $_GET["set_id"];
    $sql = "UPDATE `match_setting` SET `shooter_result`='true' WHERE `match_id` = " . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);
    // $_SESSION["member"]["setting"]["setting_view_result"] = "true";
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&mid=' . $_GET["mid"] . '&alert=success&title=สำเร็จ&msg=เปิดการแสดงผล Shooter Score เรียบร้อย." />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "viewresult" && isset($_GET["act"]) && $_GET["act"] == "closeview") {
    // $sql = "UPDATE `settings` SET `setting_view_result`='false' WHERE `setting_id` = " . $_GET["set_id"];
    $sql = "UPDATE `match_setting` SET `shooter_result`='false' WHERE `match_id` = " . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);
    // $_SESSION["member"]["setting"]["setting_view_result"] = "false";
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&mid=' . $_GET["mid"] . '&alert=success&title=สำเร็จ&msg=ปิดการแสดงผล Shooter Score เรียบร้อย." />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "matchresult" && isset($_GET["act"]) && $_GET["act"] == "openview") {
    // $sql = "UPDATE `settings` SET `setting_match_result`='true' WHERE `setting_id` = " . $_GET["set_id"];
    $sql = "UPDATE `match_setting` SET `match_result`='true' WHERE `match_id` = " . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);
    // $_SESSION["member"]["setting"]["setting_match_result"] = "true";
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&mid=' . $_GET["mid"] . '&alert=success&title=สำเร็จ&msg=เปิดการแสดงผล Match Result เรียบร้อย." />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "matchresult" && isset($_GET["act"]) && $_GET["act"] == "closeview") {
    // $sql = "UPDATE `settings` SET `setting_match_result`='false' WHERE `setting_id` = " . $_GET["set_id"];
    $sql = "UPDATE `match_setting` SET `match_result`='false' WHERE `match_id` = " . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);
    // $_SESSION["member"]["setting"]["setting_match_result"] = "false";
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&mid=' . $_GET["mid"] . '&alert=success&title=สำเร็จ&msg=ปิดการแสดงผล Match Result เรียบร้อย." />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "approved" && isset($_GET["soid"])) {
    $sql = "SELECT `so_citizen_id` FROM `so_member` WHERE `so_id` = " . $_GET["soid"];
    $row = $fnc->get_db_row($sql);
    $sql = "UPDATE `so_member` SET `so_status`='enable',`so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_pwd`='" . $row["so_citizen_id"] . "',`so_lastupdate`=current_timestamp() WHERE `so_id` = " . $_GET["soid"];
    // die($sql);
    $fnc->sql_execute($sql);
    die('<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/report.php?p=rpt&v=newSO&order=Register&sort=z&alert=success&title=สำเร็จ&msg=activated new register completed." />');
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "line" && isset($_GET["linename"]) && isset($_GET["line_message"])) {
    if ($_GET["linename"] == "umnarj") {
    }
    $lineid = "U94b9c26beec046b69f2e5c3de8838bd0";
    $line_message = "แจ้งเตือน มีคำขอจัด Match ใหม่\n\nโปรดตรวจสอบ https://idpasoth.com/";
    echo '<script type="text/javascript">
    window.open("line/line-push.php?fst=linenoti&lineid=' . $lineid . '&line_message=' . $line_message . '","_blank");
    </script>';

    die();
}

echo "condition fails";
