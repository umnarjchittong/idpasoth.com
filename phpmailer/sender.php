<?php

$data = array(
    "receiver_address" => "umnarjchittong@gmail.com",
    "receiver_name" => "umnarj chittong",
    "from_address" => "archmaejo@gmail.com",
    "from_name" => "arch maejo",
    "reply_address" => "archmaejo@gmail.com",
    "reply_name" => "arch maejo",
    "cc_address" => "",
    "cc_name" => "",
    "cc_address1" => "",
    "cc_name1" => "",
    "cc_address2" => "",
    "cc_name2" => "",
    "cc_address3" => "",
    "cc_name3" => "",
    "subject" => "Test 5th Sending Email",
    "content" => "ทดสอบการส่ง email ด้วย phpmailer",
    "attachment" => "",
    "next_url" => "sender.php?action=completed"
);
// * "next_url" => "test.php", "close" is close sending email page
echo "data: <br>";
print_r($data);
echo "<br><br>";

// $data = json_encode($data);
// $data = implode(',', $data);

session_start();
$_SESSION["data"] = $data;
$_SESSION["data_json"] = json_encode($data, JSON_UNESCAPED_UNICODE);

echo "json data: <br>";
echo $_SESSION["data_json"];

echo '<br><br><hr><br><a href="mail.php?type=session&next=true" target="_blank">Mailer and comeback - OK</a>';
echo '<br><br><hr><br><a href="mail.php?type=session&next=close" target="_blank">Mailer new tab and close - OK</a>';
echo '<br><br><hr><br><a href="mail.php?type=json&next=true" target="_blank">Mailer by json - OK</a>';