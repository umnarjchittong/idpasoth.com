<!doctype html>
<?php
include("../core.php");
$fnc = new Web();
$MJU_API = new MJU_API();
$api_person_faculty = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/21000";
$api_person = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/";
?>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">

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
            text-decoration: underline;
            font-weight: bold;
            color: orangered;
        }
    </style>

</head>

<body>
    <div class="wrapper">

        <?php
        function cap_append()
        {
            global $fnc;
            $course_info = $fnc->course_info_extract($_POST["course"]);
            $sql = "SELECT count(cap_id) as cnt FROM course_active_primary WHERE cap_semester = " . $_POST["semester"] . " AND cap_year LIKE '" . $_POST["edu_year"] . "' AND course_id = " . $course_info["id"] . " AND cap_citizenid LIKE '" . $_POST["teacher"] . "'";
            $fnc->debug_console("sql find existing data: ", $sql);
            $cnt = $fnc->get_db_col($sql);

            echo '<div class="container border-bottom mb-4">';
            if ($fnc->get_db_col($sql) > 0) {
                echo '<h2 class="alrert alert-info p-4 text-center">วิชา' . $course_info["code"] . ' ' . $course_info["name"] . '<br>ได้เปิดในภาคการศึกษา ' . $_POST["semester"] . '/' . $_POST["edu_year"] . ' แล้ว</h2>';
            } else {
                $sql = "INSERT INTO course_active_primary (cap_semester, cap_year, course_id, cap_citizenid, cap_status, cap_editor, cap_lastupdate) 
                    VALUES (" . $_POST["semester"] . ", '" . $_POST["edu_year"] . "', " . $course_info["id"] . ", '" . $_POST["teacher"] . "', 'enable', 'TOM', current_timestamp())";
                $fnc->debug_console("sql append new open course: ", $sql);
                $fnc->sql_execute($sql);
                echo "<meta http-equiv='refresh' content='0; URL=cap.php?cap_id=" . $fnc->get_last_id("course_active_primary", "cap_id") . "'>";
                die();
            }
            echo '</div>';
        }

        function cas_append()
        {
            global $fnc;
            $sql = "SELECT count(cas_id) FROM course_active_secondary WHERE cap_id = " . $_POST["cap_id"] . " AND cas_citizenid LIKE '" . $_POST["teacher"] . "' AND cas_status = 'enable'";
            $fnc->debug_console("sql find existing data: ", $sql);
            $cnt = $fnc->get_db_col($sql);

            echo '<div class="container border-bottom mb-4">';
            if ($fnc->get_db_col($sql) > 0) {
                echo '<h2 class="alrert alert-info p-4 text-center">วิชา' . $course_info["code"] . ' ' . $course_info["name"] . '<br>ได้เปิดในภาคการศึกษา ' . $_POST["semester"] . '/' . $_POST["edu_year"] . ' แล้ว</h2>';
            } else {
                $sql = "INSERT INTO course_active_secondary (cap_id, cas_citizenid, cas_lecture_hours, cas_lab_hours, cas_self_hours, cas_status, cas_editor, cas_lastupdate) 
                    VALUES (" . $_POST["cap_id"] . ", '" . $_POST["teacher"] . "', 0, 0, 0, 'enable', 'TOM', current_timestamp())";
                $fnc->debug_console("sql append ta: ", $sql);
                $fnc->sql_execute($sql);
                echo "<meta http-equiv='refresh' content='0; URL=cap.php?p=courseview&cap_cid=" . $_POST["course_id"] . "'>";
                die();
            }
            echo '</div>';
        }
        ?>

        <?php
        // * display table cap
        function view_user()
        {
            $fnc = new Web_Object();
            $MJU_API = new MJU_API();
            global $api_person;

            $sql = "SELECT * FROM v_cap WHERE cap_citizenid LIKE '" . $_GET["cap_uid"] . "'";
            $cap_info = $fnc->get_db_array($sql)[0];
            $fnc->debug_console("cap_info filter sql: ", $cap_info);
            $user_info = $MJU_API->GetAPI_array($api_person . $cap_info["cap_citizenid"])[0];
            $fnc->debug_console("user_info: ", $user_info);

            if (isset($_GET["semester"])) {
                $cap_info["cap_semester"] = $_GET["semester"];
            }
            if (isset($_GET["edu_year"])) {
                $cap_info["cap_year"] = $_GET["edu_year"];
            }


        ?>
            <div class="container border-bottom mb-4">
                <h2 class="text-info">User View</h2>
                <form action="?" method="get" class="mt-4">
                    <div class="row">
                        <div class="col-4 col-md-7 title h3 text-primary">
                            <?= $user_info["titlePosition"] . ' ' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <select id="semester" name="semester" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
                                        <?php
                                        for ($i = 1; $i <= 3; $i++) {
                                            echo '<option value="' . $i . '"';
                                            if ($cap_info["cap_semester"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>ภาคการศึกษา ' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6 form-group">
                                    <select id="edu_year" name="edu_year" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
                                        <?php
                                        for ($i = date("Y") + 543 + 1; $i >= 2563; $i--) {
                                            echo '<option value="' . $i . '"';
                                            if ($cap_info["cap_year"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>ปีการศึกษา ' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="cap_uid" value="<?= $_GET["cap_uid"]; ?>">
                </form>

                <div class="table mb-3">
                    <table class="table table-bordered mt-4">
                        <!-- table table-striped table-bordered table-hover table-responsive"> -->
                        <thead class="thead-inverse">
                            <tr class="">
                                <th>วิชา / หน่วยกิต</th>
                                <th>ผู้สอน</th>
                                <th>ภาระงานสอน (ชม.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM v_cap WHERE cap_citizenid LIKE '" . $cap_info["cap_citizenid"] . "' ORDER BY cap_year Desc, cap_semester Desc, course_code_th Asc";
                            $cap_list = $fnc->get_dataset_array($sql);
                            foreach ($cap_list as $cap) {
                            ?>
                                <tr class="">
                                    <td scope="row"><a href="cap.php?p=courseview&cap_cid=<?= $cap["course_id"]; ?>"><?= $cap["course_code_th"] . ' ' . $cap["course_name_th"]; ?></a></td>
                                    <?php
                                    $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                                    ?>
                                    <td><a href="cap.php?p=userview&cap_uid=<?= $cap["cap_citizenid"]; ?>"><?= $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></a></td>
                                    <td><?= $cap["cap_lecture_hours"] . ' , ' . $cap["cap_lab_hours"] . ' , ' . $cap["cap_self_hours"]; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-2 offset-10 text-right float-none mb-5">
                    <a href="cap.php" target="_top" class="btn btn-secondary text-uppercase px-4 w-100">close</a>
                </div>

            </div>
        <?php } ?>

        <?php
        // * display table cap
        function view_course_primary()
        {
            $fnc = new Web_Object();
            $MJU_API = new MJU_API();
            global $api_person;

            $sql = "SELECT * FROM v_cap WHERE course_id = " . $_GET["cap_cid"];
            $fnc->debug_console("view course primary sql: ", $sql);
            $cap_info = $fnc->get_db_array($sql)[0];
            $fnc->debug_console("cap_info filter: ", $cap_info);
            $user_info = $MJU_API->GetAPI_array($api_person . $cap_info["cap_citizenid"])[0];
            $fnc->debug_console("user_info: ", $user_info);

            if (isset($_GET["semester"])) {
                $cap_info["cap_semester"] = $_GET["semester"];
            }
            if (isset($_GET["edu_year"])) {
                $cap_info["cap_year"] = $_GET["edu_year"];
            }

        ?>
            <div class="container border-bottom mb-4">
                <h2 class="" style="color: lightgreen;">Course View</h2>
                <form action="?" method="get" class="mt-4">
                    <div class="row">
                        <div class="col-4 col-md-7 title h3 text-primary">
                            <?= $cap_info["course_code_th"] . ' ' . $cap_info["course_name_th"]; ?>
                            <?= '<br><span style="font-size: 0.75em;">' . $cap_info["course_credit"] . ' หน่วยกิต (' . $cap_info["course_lecture"] . ' , ' . $cap_info["course_lab"] . ' , ' . $cap_info["course_self"] . ' )</span>'; ?>
                            ?>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <select id="semester" name="semester" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
                                        <?php
                                        for ($i = 1; $i <= 3; $i++) {
                                            echo '<option value="' . $i . '"';
                                            if ($cap_info["cap_semester"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>ภาคการศึกษา ' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6 form-group">
                                    <select id="edu_year" name="edu_year" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
                                        <?php
                                        for ($i = date("Y") + 543 + 1; $i >= 2563; $i--) {
                                            echo '<option value="' . $i . '"';
                                            if ($cap_info["cap_year"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>ปีการศึกษา ' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="cap_cid" value="<?= $_GET["cap_cid"]; ?>">
                </form>

                <div class="table mb-3">
                    <table class="table table-bordered mt-4">
                        <!-- table table-striped table-bordered table-hover table-responsive"> -->
                        <thead class="thead-inverse">
                            <tr class="">
                                <th>ผู้สอน</th>
                                <th>ภาระงานสอน (ชม.)</th>
                                <th class="text-end"><?php if (!isset($_GET["ta"])) {
                                                            echo '<a href="?' . $_SERVER["QUERY_STRING"] . '&ta=form" class="btn btn-sm btn-primary">แก้ไขผู้สอนร่วม</a>';
                                                        } ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM v_cap WHERE course_id = " . $_GET["cap_cid"];
                            $sql .= " AND cap_semester = " . $cap_info["cap_semester"] . " AND cap_year = '" . $cap_info["cap_year"] . "'";
                            $sql .= " ORDER BY cap_year Desc, cap_semester Desc, course_code_th Asc";
                            $cap_list = $fnc->get_db_array($sql);
                            $fnc->debug_console("course view table:", $cap_list);

                            if ($cap_list) {
                                foreach ($cap_list as $cap) {
                                    $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                            ?>
                                    <tr class="">
                                        <td scope="row"><a href="cap.php?p=userview&cap_uid=<?= $cap["cap_citizenid"]; ?>"><?= $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></a></td>
                                        <td><?= $cap["cap_lecture_hours"] . ' , ' . $cap["cap_lab_hours"] . ' , ' . $cap["cap_self_hours"]; ?></td>
                                        <td class="text-end"><a href="#" class="btn btn-sm btn-warning">แก้ไขภาระงานสอน</a></td>
                                    </tr>
                                    <?php
                                }
                                // * get teacher assistant list adn display as table here
                                $sql = "get teacher assistant";

                                if ($cap_list) {
                                    foreach ($cap_list as $cap) {
                                        $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                                    ?>
                                        <tr class="">
                                            <td scope="row"><a href="cap.php?p=userview&cap_uid=<?= $cap["cap_citizenid"]; ?>"><?= $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></a></td>
                                            <td><?= $cap["cap_lecture_hours"] . ' , ' . $cap["cap_lab_hours"] . ' , ' . $cap["cap_self_hours"]; ?></td>
                                            <td class="text-end"><a href="#" class="btn btn-sm btn-warning">แก้ไขภาระงานสอน</a></td>
                                        </tr>
                            <?php
                                    }
                                }
                            } else {
                                echo '<tr class="">
                                        <td colspan="3" class="text-secondary text-center my-2">ไม่พบรายวิชานี้ ในภาคการศึกษา ' . $cap_info["cap_semester"] . '/' . $cap_info["cap_year"] . '</td>
                                    </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-2 offset-10 text-right float-none mb-5">
                    <a href="cap.php" target="_top" class="btn btn-secondary text-uppercase px-4 w-100">close</a>
                </div>

            </div>

        <?php
            if (isset($_GET["ta"]) && $_GET["ta"] == "form") {
                cas_form($cap_info, $user_info);
                // cas_table();
            }
        }
        ?>

        <?php
        // * display course assignment to teacher or open course activation primary teacher
        function cap_form()
        {
            $fnc = new Web_Object();
            $MJU_API = new MJU_API();
            global $api_person_faculty;
        ?>
            <div class="container border-bottom mb-4">
                <h2 class="text-primary">Course Assign to Teacher</h2>
                <?php
                if (isset($_GET["cap_id"])) {
                    $sql = "SELECT * FROM v_cap WHERE cap_id = " . $_GET["cap_id"];
                    $cap_info = $fnc->get_db_array($sql)[0];
                    $fnc->debug_console("cap filter sql: ", $cap_info);
                    // if (isset($cap_info["cap_semester"])) { echo " value='" . $cap_info["cap_semester"] . "'"; }
                }
                ?>
                <form action="?" method="post" class="mt-4">
                    <div class="row g-3 mb-4">
                        <div class="col-4 offset-4 col-md-3 offset-md-6 form-group">
                            <label for="semester" class="form-label">ภาคการศึกษา</label>
                            <select id="semester" name="semester" class="form-select" aria-label="Default select example">
                                <?php
                                for ($i = 1; $i <= 3; $i++) {
                                    echo '<option value="' . $i . '"';
                                    if (isset($cap_info["cap_semester"]) && $cap_info["cap_semester"] == $i) {
                                        echo " selected";
                                    }
                                    echo '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-4 col-md-3 form-group">
                            <label for="edu_year" class="form-label">ปีการศึกษา</label>
                            <select id="edu_year" name="edu_year" class="form-select" aria-label="Default select example">
                                <?php
                                for ($i = date("Y") + 543 + 1; $i >= 2563; $i--) {
                                    echo '<option value="' . $i . '"';
                                    if (isset($cap_info["cap_year"]) && $cap_info["cap_year"] == $i) {
                                        echo " selected";
                                    }
                                    echo '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-7 form-group">
                            <?php
                            $sql = "SELECT course_id,course_code_th,course_name_th,course_credit,course_lecture,course_lab,course_self FROM course WHERE course_status = 'enable'";
                            $course_list = $fnc->get_dataset_array($sql);
                            ?>
                            <label for="course" class="form-label">เลือกรายวิชา</label>
                            <select id="course" name="course" class="form-select" size="10" aria-label="size 3 select example" required>
                                <!-- <option selected>Open this select menu</option> -->
                                <?php
                                foreach ($course_list as $c_list) {
                                    echo '<option value="' . $c_list["course_id"] . '-' . $c_list["course_code_th"] . ' ' . $c_list["course_name_th"] . '"';
                                    if (isset($cap_info["course_id"]) && $cap_info["course_id"] == $c_list["course_id"]) {
                                        echo " selected";
                                    }
                                    echo '>' . $c_list["course_code_th"] . ' ' . $c_list["course_name_th"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-5 form-group">
                            <?php
                            $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
                            ?>
                            <label for="teacher" class="form-label">เลือกผู้รับผิดชอบวิชา</label>
                            <select id="teacher" name="teacher" class="form-select" size="10" aria-label="size 3 select example" required>
                                <!-- <option selected>Open this select menu</option> -->
                                <?php
                                foreach ($teacher_list as $t_list) {
                                    echo '<option value="' . $t_list["citizenId"] . '"';
                                    if (isset($cap_info["cap_citizenid"]) && $cap_info["cap_citizenid"] == $t_list["citizenId"]) {
                                        echo " selected";
                                    }
                                    echo '>' . $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                    </div>

                    <div class="col-2 offset-10 text-right float-none mb-5">
                        <button type="submit" name="submit" class="btn btn-primary text-uppercase px-4 w-100">ลงทะเบียน</button>
                    </div>

                </form>
            </div>
        <?php
        }
        ?>

        <?php
        // * display course assignment to teacher or open course activation secondary teacher
        function cas_form($cap_info, $user_info)
        {
            $fnc = new Web_Object();
            $MJU_API = new MJU_API();
            global $api_person_faculty;
        ?>
            <div class="container border-bottom mb-4">
                <h2 class="text-primary bold my-5">Course Assign Teacher Assistant</h2>
                <form action="?" method="post" class="mt-4">
                    <div class="row g-3 mb-4">
                        <div class="col-5 col-md-6 title h3 text-primary">
                            <?= '<p class="h3 text-secondary">' . $cap_info["course_code_th"] . ' ' . $cap_info["course_name_th"] . '</p>'; ?>
                            <?= '<p class="mb-2" style="font-size: 0.65em;">' . $cap_info["course_credit"] . ' หน่วยกิต (' . $cap_info["course_lecture"] . ' , ' . $cap_info["course_lab"] . ' , ' . $cap_info["course_self"] . ' )</p>'; ?>
                            <?= '<p style="font-size: 0.65em;">ภาคการศึกษาที่ ' . $cap_info["cap_semester"] . '/' . $cap_info["cap_year"] . '</p>'; ?>
                            <?= '<p class="h4 mt-5 text-secondary">อาจารย์เจ้าของวิชา</p>'; ?>
                            <!-- <?= '<p style="font-size: 0.75em;">ภาคการศึกษาที่ ' . $cap_info["cap_semester"] . '/' . $cap_info["cap_year"] . '</p>'; ?> -->
                            <?= '<p style="font-size: 0.65em;">' . $user_info["titlePosition"] . ' ' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"] . '</p>'; ?>
                        </div>
                        <div class="col-7 col-md-6 form-group">
                            <?php
                            $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
                            ?>
                            <label for="teacher" class="form-label">เลือกผู้สอนร่วม</label>
                            <select id="teacher" name="teacher" class="form-select" size="10" aria-label="size 3 select example" required>
                                <!-- <option selected>Open this select menu</option> -->
                                <?php
                                // * get teacher assistant list
                                $sql_cas = "SELECT cas_citizenid FROM course_active_secondary WHERE cap_id = " . $cap_info["cap_id"] . " AND cas_status like 'enable'";
                                $cas_ta = $fnc->get_db_array($sql_cas);
                                $fnc->debug_console("cas form - cas_ta: ", $cas_ta);
                                foreach ($teacher_list as $t_list) {
                                    if ($cap_info["cap_citizenid"] != $t_list["citizenId"]) {
                                        if (is_array($cas_ta)) {
                                            foreach ($cas_ta as $ta) {
                                                if ($ta["cas_citizenid"] != $t_list["citizenId"]) {
                                                    echo '<option value="' . $t_list["citizenId"] . '"';
                                                    echo '>' . $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . '</option>';
                                                }
                                            }
                                        } else {
                                            echo '<option value="' . $t_list["citizenId"] . '"';
                                            echo '>' . $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">


                    </div>

                    <div class="row">
                        <div class="col-3 offset-6 text-right mb-5">
                            <a href="?p=courseview&cap_cid=<?= $cap_info["course_id"] ?>" target="_top" class="btn btn-secondary text-uppercase px-2 w-100">close</a>
                        </div>
                        <div class="col-3 text-right mb-5">
                            <input type="hidden" name="cap_id" value="<?= $cap_info["cap_id"] ?>">
                            <input type="hidden" name="course_id" value="<?= $cap_info["course_id"] ?>">

                            <button type="submit" name="ta_submit" value="ta_submit" class="btn btn-primary text-uppercase px-2 w-100">ลงทะเบียนสอนร่วม</button>
                        </div>
                    </div>

                </form>
            </div>
        <?php
        }
        ?>

        <?php
        // * display table cap
        function cap_table()
        {
            $fnc = new Web_Object();
            $MJU_API = new MJU_API();
            global $api_person;
        ?>
            <div class="container border-bottom mb-4">
                <table class="table table-striped table-bordered table-hover responsive">
                    <thead class="thead-inverse">
                        <tr class="">
                            <th>ภาคการศึกษา</th>
                            <th>ชื่อวิชา</th>
                            <th>เจ้าของวิชา</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM v_cap order by cap_year Desc, cap_semester Desc, course_code_th Asc";
                        $cap_list = $fnc->get_dataset_array($sql);
                        foreach ($cap_list as $cap) {
                        ?>
                            <tr class="" onclick="window.open('?cap_id=<?= $cap['cap_id'] ?>','_top');">
                                <td scope="row"><?= $cap["cap_semester"] . '/' . $cap["cap_year"]; ?></td>
                                <td><a href="cap.php?p=courseview&cap_cid=<?= $cap["course_id"]; ?>"><?= $cap["course_code_th"] . ' ' . $cap["course_name_th"]; ?></a></td>
                                <?php
                                $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                                ?>
                                <td><a href="cap.php?p=userview&cap_uid=<?= $cap["cap_citizenid"]; ?>"><?= $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>


        <?php
        if (isset($_POST["submit"])) {
            cap_append();
        } elseif (isset($_POST["ta_submit"])) {
            cas_append();
        } elseif (isset($_GET["cap_uid"])) {
            view_user();
        } elseif (isset($_GET["cap_cid"])) {
            view_course_primary();
        } else {
            cap_form();
            cap_table();
        }

        ?>




    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>