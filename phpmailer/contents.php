<!doctype html>
<html lang="en">
<?php
// email html content generator

if (!isset($_GET["m_id"])) {
    // die("<br>No message id founded!<br>");
} else {
    $m_id = 39;
}
$m_id = 39;


require("../core.php");
$fnc = new CommonFnc();
$fnc_db = new database();

$sql = "select * from message where message_id = " . $m_id;
$row = $fnc_db->get_db_row($sql);
$m_created = $fnc->get_date_semi_th($row["message_created"]);

$data = array(
    "title" => '<div class="mb-2"><strong class="mb-2">เรียน คุณ' . $row["message_username"] . '</strong></div>',
    "subject" => '<div class="mb-4"><strong class="mb-2">เรื่อง ตอบกลับสายตรงคณบดี</strong></div>',
    "content_intro" => 'ตามที่ท่านได้เขียนข้อความสายตรงคณบดี คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม เมื่อวันที่ ' . $m_created . ' ความว่า',
    "content_m_memo" => $row["message_memo"],
    "content_then" => 'ในการนี้ ทางคณะฯ พิจารณาข้อความดังกล่าว และขอเรียนตอบท่าน ดังนี้',
    "content_reply" => $row["message_replytext"],
    "reply_by" => $row["message_replyuser"],
    "reply_by_fullname" => ""
);

// find full name by board postion

// foreach ($fnc->board as $board) {    
for ($i = 1; $i <= count($fnc->board); $i++) {
    if ($fnc->board[$i] == $data["reply_by"]) {
        $data["reply_by_fullname"] = $fnc->board_fullname[$i];
        break;
    }
}

?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <title></title>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 1rem;
            letter-spacing: 0.075em;
        }

        .footer-text {
            letter-spacing: 0.1em;
        }
    </style>

</head>

<body>
    <div class="container col-10 col-lg-8 p-2">
        <div id="title">
            <?= $data["title"] . $data["subject"]; ?>
        </div>

        <div id="content" class="text-black">
            <p class="mb-0" style="text-indent: 50px;">
                <?= $data["content_intro"] ?>
            </p><br>
            <p class="mb-2" style="text-indent: 50px;">
                "<?= $data["content_m_memo"] ?>"
            </p><br>
            <p class="mb-0" style="text-indent: 50px;">
                <?= $data["content_then"] ?>
            </p><br>
            <p class="mb-2" style="text-indent: 50px;">
                "<?= $data["content_reply"] ?>"
            </p>
        </div>

        <div id="footer" class="mt-3 text-black">
            <br><br>
            <div class="mt-2 col-auto offset-6">
                <div>
                    <?= $data["reply_by_fullname"] ?>
                </div>
                <div>
                    <?= $data["reply_by"] ?>
                </div>
            </div>
        </div>

        <hr class="my-4">
        <div class="row mt-1 p-2" style="">
            <div class="col-auto"><img src="https://arch.mju.ac.th/img/mju_logo.jpg" width="75px"></div>
            <div class="col text-black-50 pt-1">
                <p class="footer-text" style="font-size: 0.8em;">คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม
                    มหาวิทยาลัยแม่โจ้<br>
                    <sapn>63/4 ถ.เชียงใหม่-พร้าว อ.สันทราย จ.เชียงใหม่ 50290</sapn><br>
                    <span>โทร 053873350</span><span class="ms-2">Email: <a href="mailto:arch@mju.ac.th">arch@mju.ac.th</a></span><br><span><a href="https://arch.mju.ac.th" target="_blank">arch.mju.ac.th</a></span><span class="ms-2"><a href="https://www.facebook.com/ArchMaejo/" target="_blank">FB: fb.com/archmaejo</a></span>
                </p>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous">
    </script>
</body>

</html>