<?php

session_start();
// echo '<meta charset="UTF-8">';
date_default_timezone_set("Asia/Bangkok");



class settings
{
    // * LINE Bot Configures
    public $line_setting = array(
        "ChannelID" => "1655453169",
        "ChannelName" => "SOTH",
        "BotBasicID" => "@674lsmcs",
        "YourUserID" => "U94b9c26beec046b69f2e5c3de8838bd0",
        "ChannelSecret" => "d6efe68166e8bb6cf8cbc445be0efdf6",
        "ChannelAccessToken" => "Ii5m9kZAkix1Noh0PmAlbTo3mPMXbq1rhOtQ9STkaAo13nHJpjQxtRO7JMhUht2FeA6YTE41o8jAHvNcNJlrTj7ebbmuwUw0w/C0m1VaJAJ6/iTafor22GLjU1YxmhKDNkI2DAGkNE6U1wC0zMY87wdB04t89/1O/w1cDnyilFU="
    );

    // Configures
    public $user_chk_first = false;

    // Constants
    // public $message_text = array();
    public $line_userid = array(
        "umnarj" => "U94b9c26beec046b69f2e5c3de8838bd0",
        "test" => "U38a2a50b9b25da532e46c0181c66d826"
    );

}

class CommonFnc extends settings
{
    public function debug_console($val1, $val2 = null)
    {
        if ($this->system_debug) {
            if (is_array($val1)) {
                // $val1 = implode(',', $val1);
                $val1 = str_replace(
                    chr(34),
                    '',
                    json_encode($val1, JSON_UNESCAPED_UNICODE)
                );
                $val1 = str_replace(chr(58), chr(61), $val1);
                $val1 = str_replace(chr(44), ', ', $val1);
                $val1 = 'Array:' . $val1;
            }
            if (is_array($val2)) {
                // $val2 = implode(',', $val2);
                $val2 = str_replace(
                    chr(34),
                    '',
                    json_encode($val2, JSON_UNESCAPED_UNICODE)
                );
                $val2 = str_replace(chr(58), chr(61), $val2);
                $val2 = str_replace(chr(44), ', ', $val2);
                $val2 = 'Array:' . $val2;
            }
            if (isset($val1) && isset($val2) && !is_null($val2)) {
                echo '<script>console.log("' .
                    $val1 .
                    '\\n' .
                    $val2 .
                    '");</script>';
            } else {
                echo '<script>console.log("' . $val1 . '");</script>';
            }
        }
    }

    public function get_client_info()
    {
        $data = array();
        foreach ($_SERVER as $key => $value) {
            // $data .= '$_SERVER["' . $key . '"] = ' . $value . '<br />';
            array_push($data, '$_SERVER["' . $key . '"] = ' . $value);
        }
        return $data;
    }

    public function get_page_info($parameter = null)
    {
        if (!$parameter) {
            $indicesServer = [
                'PHP_SELF',
                'argv',
                'argc',
                'GATEWAY_INTERFACE',
                'SERVER_ADDR',
                'SERVER_NAME',
                'SERVER_SOFTWARE',
                'SERVER_PROTOCOL',
                'REQUEST_METHOD',
                'REQUEST_TIME',
                'REQUEST_TIME_FLOAT',
                'QUERY_STRING',
                'DOCUMENT_ROOT',
                'HTTP_ACCEPT',
                'HTTP_ACCEPT_CHARSET',
                'HTTP_ACCEPT_ENCODING',
                'HTTP_ACCEPT_LANGUAGE',
                'HTTP_CONNECTION',
                'HTTP_HOST',
                'HTTP_REFERER',
                'HTTP_USER_AGENT',
                'HTTPS',
                'REMOTE_ADDR',
                'REMOTE_HOST',
                'REMOTE_PORT',
                'REMOTE_USER',
                'REDIRECT_REMOTE_USER',
                'SCRIPT_FILENAME',
                'SERVER_ADMIN',
                'SERVER_PORT',
                'SERVER_SIGNATURE',
                'PATH_TRANSLATED',
                'SCRIPT_NAME',
                'REQUEST_URI',
                'PHP_AUTH_DIGEST',
                'PHP_AUTH_USER',
                'PHP_AUTH_PW',
                'AUTH_TYPE',
                'PATH_INFO',
                'ORIG_PATH_INFO',
            ];

            // $data = '<table cellpadding="10">';
            $val = "page info : \\n";
            foreach ($indicesServer as $arg) {
                if (isset($_SERVER[$arg])) {
                    // $data .= '<tr><td>' .
                    //     $arg .
                    //     '</td><td>' .
                    //     $_SERVER[$arg] .
                    //     '</td></tr>';
                    // $this->debug_console($arg . " = " . $_SERVER[$arg]);
                    $val .= $arg . ' = ' . $_SERVER[$arg] . "\\n";
                } else {
                    // $data .= '<tr><td>' . $arg . '</td><td>-</td></tr>';
                    // $this->debug_console($arg . " = -");
                    $val .= $arg . ' = -' . "\\n";
                }
            }
            // $data .= '</table>';            
            $this->debug_console($val);
            return $val;
        } else {
            switch ($parameter) {
                case 'thisfilename':
                    if (strripos($_SERVER['PHP_SELF'], '/')) {
                        $data = substr(
                            $_SERVER['PHP_SELF'],
                            strripos($_SERVER['PHP_SELF'], '/') + 1
                        );
                    } else {
                        $data = substr(
                            $_SERVER['PHP_SELF'],
                            strripos($_SERVER['PHP_SELF'], '/')
                        );
                    }
                    // $this->debug_console("this file name = " . $data);
                    return $data;
                    break;
                case 'parameter':
                    if (strripos($_SERVER['REQUEST_URI'], '?')) {
                        parse_str(
                            substr(
                                $_SERVER['REQUEST_URI'],
                                strripos($_SERVER['REQUEST_URI'], '?') + 1
                            ),
                            $data
                        );
                    } else {
                        parse_str(substr($_SERVER['REQUEST_URI'], 0), $data);
                    }
                    // print_r($data);
                    return $data;
                    break;
            }
        }
    }

    public function get_url_filename($val = true)
    {
        if ($val === true) {
            $val = $_SERVER['PHP_SELF'];
        }
        if (isset($val)) {
            if (strpos($val, '?')) {
                $val = substr($val, 0, strpos($val, '?'));
            }

            if (stristr($val, '/')) {
                $val = substr($val, strripos($val, '/') + 1);
            } else {
                $val = substr($val, strripos($val, '/'));
            }
            return $val;
        }
    }

    public function get_url_parameter($val = true, $data_array = false)
    {
        if ($val === true) {
            $val = $_SERVER['REQUEST_URI'];
        }
        if (isset($val) && stristr($val, '?')) {
            if (isset($data_array) && $data_array === true) {
                parse_str(substr($val, strpos($val, '?') + 1), $data);
                // print_r($data);
            } else {
                $data = substr($val, strpos($val, '?') + 1);
            }
            return $data;
        }
    }

    public function goBack()
    {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    public function gen_google_analytics($id = null)
    {
        if (!isset($id) || $id != '') {
            $id = $this->google_analytic_id;
        }
        echo '<!-- Global site tag (gtag.js) - Google Analytics -->';
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' .
            $id .
            '"></script>';
        echo '<script>';
        echo '  window.dataLayer = window.dataLayer || [];';
        echo '  function gtag(){dataLayer.push(arguments);}';
        echo '  gtag("js", new Date());';
        echo '  gtag("config", "' . $id . '");';
        echo '</script>';
    }

    public function get_time_th($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = getdate(date("U"));
        }
        return $current_date["hours"] . ":" . $current_date["minutes"] . ":" . $current_date["seconds"] . " น.";
    }

    public function get_date_semi_th($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = getdate(date("U"));
        }
        return $current_date["mday"] . " " . $this->month_name[(int) $current_date["mon"]] . " " . substr(($current_date["year"] + 543), 2);
    }

    public function gen_date_full_thai($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = getdate(date("U"));
        }
        echo date("j", strtotime($current_date));
        echo " ";
        echo $this->month_fullname[(int) date("m", strtotime($current_date))];
        echo " ";
        echo (date("Y", strtotime($current_date)) + 543);
    }

    public function get_fiscal_year($date = NULL)
    {
        if ($date == NULL) {
            $date = date('Y-m-d H:i:s');
        }
        // echo "date= " . $date;
        // echo ", month= " . $date_m = date("m", strtotime($date));
        // echo ", year= " . $date_y = (date("Y", strtotime($date))+543);
        if (date("m", strtotime($date)) >= 10) {
            return (date("Y", strtotime($date)) + 543) + 1;
        }
        return (date("Y", strtotime($date)) + 543);
    }

    public function gen_alert($alert_sms, $alert_title = 'Alert!!', $alert_style = 'danger')
    {
        // echo '<div class="app-wrapper">';
        echo '<div class="container col-12 mt-3">';
        // echo '<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">';
        echo '<div class="alert alert-' . $alert_style . ' alert-dismissible fade show" role="alert">';
        echo '<div class="inner">';
        echo '<div class="app-card-body p-3 p-lg-4">';
        echo '<h3 class="mb-3 text-' .
            $alert_style .
            '">' .
            $alert_title .
            '</h3>';
        echo '<div class="row gx-5 gy-3">';
        echo '<div class="col-12">';
        echo '<div class="text-center">' . $alert_sms . '</div>';
        echo '</div>';
        echo '</div>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        // echo '</div>';
        $this->debug_console($alert_sms);
    }

    public function get_alert($method)
    {
        switch ($method) {
            case "replied":
                $this->gen_alert("ทำการส่งอีเมลตอบกลับเรียบร้อย.", "Email Sent", "info");
        }
    }

    public function date_diff($date1)
    {
        $date1 = date_create($date1);
        $date2 = date_create(date("Y") . "-" . date("m") . "-" . date("d"));
        $diff = date_diff($date2, $date1);
        //echo $diff->format("%R%a days");
        //        $this->debug_console($diff->format("%R%a"));
        if ($diff->format("%R%a") < 0) {
            //            $this->debug_console("false");
            // return false;
        } else {
            // $this->debug_console("true: " . $diff->format("%R%a"));
            //            $this->debug_console("true");
            // return $diff->format("%R%a");
            return true;
        }
    }

    public function get_time_ago($time)
    {
        $time_difference = time() - $time;

        if ($time_difference < 1) {
            return 'less than 1 second ago';
        }
        // $condition = array(
        //     12 * 30 * 24 * 60 * 60 =>  'year',
        //     30 * 24 * 60 * 60       =>  'month',
        //     24 * 60 * 60            =>  'day',
        //     60 * 60                 =>  'hour',
        //     60                      =>  'minute',
        //     1                       =>  'second'
        // );
        $condition = array(
            12 * 30 * 24 * 60 * 60 =>  'yr',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hr',
            60                      =>  'min',
            1                       =>  'sec'
        );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;

            if ($d >= 1) {
                $t = round($d);
                // return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
                return '' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
            }
        }
    }

    public function gen_titlePosition_short($titlePosition)
    {
        $titlePosition = str_replace('รองศาสตราจารย์ ', 'รศ.', $titlePosition);
        $titlePosition = str_replace('รองศาสตราจารย์', 'รศ.', $titlePosition);
        $titlePosition = str_replace('ผู้ช่วยศาสตราจารย์ ', 'ผศ.', $titlePosition);
        $titlePosition = str_replace('ผู้ช่วยศาสตราจารย์', 'ผศ.', $titlePosition);
        $titlePosition = str_replace('ศาสตราจารย์ ', 'ศ.', $titlePosition);
        $titlePosition = str_replace('ศาสตราจารย์', 'ศ.', $titlePosition);
        $titlePosition = str_replace('อาจารย์ ', 'อ.', $titlePosition);
        $titlePosition = str_replace('อาจารย์', 'อ.', $titlePosition);
        return trim($titlePosition);
    }
}

class database extends CommonFnc
{
    private $db = array("server" => "localhost", "user" => "idpasoth", "pass" => "Chittong-23", "name" => "idpasoth_soth");

    public function open_conn()
    {
        $conn = new mysqli($this->db["server"], $this->db["user"], $this->db["pass"], $this->db["name"]);
        if (mysqli_connect_errno()) {
            die("Failed to connect to MySQL: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        return $conn;
    }

    public function get_result($sql)
    {
        $result = $this->open_conn()->query($sql);
        return $result;
    }

    public function sql_execute($sql)
    {
        //$this->open_conn()->query($sql);
        $conn = $this->open_conn();
        $conn->query($sql);
        return $conn->insert_id;
    }

    public function sql_execute_multi($sql)
    {
        $conn = $this->open_conn();
        $conn->multi_query($sql);
    }

    public function sql_execute_debug($st = "", $sql)
    {
        if ($st != "") {
            if ($st == "die") {
                $this->debug_console("SQL: " . $sql);
            } else {
                $this->debug_console("SQL: " . $sql);
            }
        } else {
            //$this->open_conn()->query($sql);
            $conn = $this->open_conn();
            $conn->query($sql);
            return $conn->insert_id;
        }
    }

    public function sql_secure_string($str)
    {
        return mysqli_real_escape_string($this->open_conn(), $str);
    }

    public function get_db_row($sql)
    {
        if (isset($sql)) {
            $result = $this->get_result($sql);
            // if ($result->num_rows > 0) {
            if (!empty($result)) {
                return $result->fetch_assoc();
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_db_rows($sql)
    {
        if (isset($sql)) {
            $result = $this->get_result($sql);
            // if ($result->num_rows > 0) {
            if (!empty($result)) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_db_col_name($sql)
    {
        if (isset($sql)) {
            // $column = array("name", "orgname", "table", "orgtable", "def", "db", "catalog", "max_length", "length", "charsetnr", "flags", "type", "decimals");
            $column = array();
            $result = $this->get_result($sql);
            while ($col = $result->fetch_field()) {
                array_push($column, $col->name);
            }
            return $column;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_db_array($sql)
    {
        if (isset($sql)) {
            $result = $this->get_result($sql);
            // if ($result->num_rows > 0) {
            if (!empty($result)) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_dataset_array($sql, $method = "MYSQLI_NUM")
    {
        // * method = MYSQLI_NUM, MYSQLI_ASSOC, MYSQLI_BOTH
        return $this->open_conn()->query($sql)->fetch_all(MYSQLI_BOTH);
    }

    // public function get_dataset_array($sql)
    // {
    //     $dataset = array();
    //     if (isset($sql)) {
    //         $result = $this->get_result($sql);
    //         if ($result->num_rows > 0) {
    //             while ($row = $result->fetch_array()) {
    //                 array_push($dataset, array($row[0], $row[1]));
    //             }
    //             return $dataset;
    //         }
    //         //return NULL;
    //     } else {
    //         die("fnc get_db_col no sql parameter.");
    //     }
    // }

    public function get_db_col($sql)
    {
        if (isset($sql)) {
            //echo $this->debug("", "fnc get_db_col sql: " . $sql);
            $result = $this->get_result($sql);
            // if ($result->num_rows > 0) {
            if (!empty($result)) {
                $row = $result->fetch_array();
                return $row[0];
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_last_id($tbl = "activity", $col = "act_id")
    {
        $sql = "select " . $col . " from " . $tbl;
        $sql .= " order by " . $col . " Desc Limit 1";
        return $this->get_db_col($sql);
    }
}

class linecore extends database
{
    public function Location($events, $data)
    {
        if (!is_array($data)) {
            $data = json_decode($data, true);
        }
        $textMessageBuilder = new LINE\LINEBot\MessageBuilder\LocationMessageBuilder($data["title"], $data["address"], $data["latitude"], $data["longitude"]);
        return $textMessageBuilder;
    }

    public function AccountLink($line_userid)
    {
        // $urlviewinfo = 'https://api.line.me/v2/bot/user/' . $line_userid . '/linkToken';
        // // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>');
        // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->line_setting["ChannelAccessToken"]);
        // // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']);
        // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->line_setting["ChannelSecret"]]);
        // $response = $bot->createLinkToken($line_userid);
    }

    public function PushText($event, $typeresponse, $text, $line_userid = NULL)
    {
        global $bot;
        if (!$line_userid) {
            $line_userid = $event['source']['userId'];
        } else {
            // $line_userid = $this->line_userid[$line_userid];
            $line_userid = $this->authention[$line_userid]["line_userid"];
        }
        // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->line_setting["ChannelAccessToken"]);
        // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->line_setting["ChannelSecret"]]);
        $response = '';
        if ($typeresponse == 'text') {
            $TextMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            $response = $bot->pushMessage($line_userid, $TextMessageBuilder);
        } else if ($typeresponse == 'image') {
            $ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($text, $text);
            $response = $bot->replyMessage($line_userid, $ImageMessageBuilder);
        }
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }

    // ใช้ PushText แทน
    public function responseText_bk($event, $typeresponse, $text)
    {
        global $bot;
        // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->line_setting["ChannelAccessToken"]);
        // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->line_setting["ChannelSecret"]]);
        $response = '';
        if ($typeresponse == 'text') {
            $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            $response = $bot->pushMessage($event['source']['userId'], $outputText);
        } else if ($typeresponse == 'image') {
            $outputText = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($text, $text);
            $response = $bot->replyMessage($event['replyToken'], $outputText);
        }
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }

    function viewprofile($event, $json_text = NULL)
    {
        // $accesstoken = $this->line_setting["ChannelAccessToken"];

        // $userid = $event['source']['userId'];

        $textsjson = json_decode($json_text, true);

        $urlviewinfo = 'https://api.line.me/v2/bot/message/push';
        $dataviewinfo = [
            'to' => $event['source']['userId'],
            'messages' => [$textsjson],
        ];
        $postviewinfo = json_encode($dataviewinfo);
        $headerviewinfo = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->line_setting["ChannelAccessToken"]);
        $chviewinfo = curl_init($urlviewinfo);
        curl_setopt($chviewinfo, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($chviewinfo, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chviewinfo, CURLOPT_POSTFIELDS, $postviewinfo);
        curl_setopt($chviewinfo, CURLOPT_HTTPHEADER, $headerviewinfo);
        curl_setopt($chviewinfo, CURLOPT_FOLLOWLOCATION, 1);
        $resultviewinfo = curl_exec($chviewinfo);
        curl_close($chviewinfo);
        echo $resultviewinfo . "\r\n";
    }

    public function TextReply($ReplyToken, $replyData)
    {
        global $bot;
        // $response = $bot->pushMessage($this->authention["umnarj"]["line_userid"], $TextMessageBuilder);
        // $response = $bot->pushMessage("U0146eb03d721963acc198a4589f6ebb2", $TextMessageBuilder);
        // echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
        $response = $bot->replyMessage($ReplyToken, $textMessageBuilder);

        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }

    public function TextPush($text, $userID = NULL)
    {
        global $bot;
        if (is_null($userID)) {
            // $userID = $this->authention["umnarj"]["line_userid"];
            // $userID = $this->line_userid["test"];
            $userID = "U0146eb03d721963acc198a4589f6ebb2";
        }
        if (strlen($userID) <= 10) {
            $userID = $this->line_userid[$userID];
        }

        // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->line_setting["ChannelAccessToken"]);
        // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->line_setting["ChannelSecret"]]);
        $TextMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        // $response = $bot->pushMessage($this->authention["umnarj"]["line_userid"], $TextMessageBuilder);
        // $response = $bot->pushMessage("U0146eb03d721963acc198a4589f6ebb2", $TextMessageBuilder);
        $response = $bot->pushMessage($userID, $TextMessageBuilder);
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }

    public function TextPush_multi($text, $userID = NULL)
    {
        global $bot;
        // if (is_null($userID)) {
        //   // $userID = $this->authention["umnarj"]["line_userid"];
        //   // $userID = $this->line_userid["test"];
        //   $userID = "U0146eb03d721963acc198a4589f6ebb2";
        // }
        // if (strlen($userID) <= 10) {
        // $userID = $this->line_userid[$userID];     
        $userID = [$this->authention["umnarj"]["line_userid"], $this->authention["tk"]["line_userid"]];
        // }

        // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->line_setting["ChannelAccessToken"]);
        // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->line_setting["ChannelSecret"]]);
        $TextMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        // $response = $bot->pushMessage($this->authention["umnarj"]["line_userid"], $TextMessageBuilder);
        // $response = $bot->pushMessage("U0146eb03d721963acc198a4589f6ebb2", $TextMessageBuilder);
        // $response = $bot->pushMessage($userID, $TextMessageBuilder);
        $response = $bot->multicast($userID, $TextMessageBuilder);
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }

    function flexPush_multi($userId, $json_text)
    {
        // $fnc = new core_function();
        // if (is_numeric($json_text)) {
        //     $json_text = $this->gen_flex_json_text($json_text);
        //     $json_text = $fnc->gen_flex_json_text($json_text);
        // }

        if (is_null($userId)) {
            $line_userid = $this->authention["umnarj"]["line_userid"];
        }

        $textsjson = json_decode($json_text, true);

        $urlviewinfo = 'https://api.line.me/v2/bot/message/push';
        $dataviewinfo = [
            'to' => $userId,
            'messages' => [$textsjson],
        ];
        $postviewinfo = json_encode($dataviewinfo);
        $headerviewinfo = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->line_setting["ChannelAccessToken"]);
        $chviewinfo = curl_init($urlviewinfo);
        curl_setopt($chviewinfo, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($chviewinfo, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chviewinfo, CURLOPT_POSTFIELDS, $postviewinfo);
        curl_setopt($chviewinfo, CURLOPT_HTTPHEADER, $headerviewinfo);
        curl_setopt($chviewinfo, CURLOPT_FOLLOWLOCATION, 1);
        $resultviewinfo = curl_exec($chviewinfo);
        curl_close($chviewinfo);
        echo "<hr>textpush info:<br>" . $resultviewinfo . "\r\n";
        // $this->flexPushAdminMonitoring($textsjson);
    }

    function flexPush($userId, $json_text)
    {
        // $fnc = new core_function();
        // if (is_numeric($json_text)) {
        //     $json_text = $this->gen_flex_json_text($json_text);
        //     $json_text = $fnc->gen_flex_json_text($json_text);
        // }

        if (is_null($userId)) {
            $line_userid = $this->authention["umnarj"]["line_userid"];
        }

        $textsjson = json_decode($json_text, true);

        $urlviewinfo = 'https://api.line.me/v2/bot/message/push';
        $dataviewinfo = [
            'to' => $userId,
            'messages' => [$textsjson],
        ];
        $postviewinfo = json_encode($dataviewinfo);
        $headerviewinfo = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->line_setting["ChannelAccessToken"]);
        $chviewinfo = curl_init($urlviewinfo);
        curl_setopt($chviewinfo, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($chviewinfo, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chviewinfo, CURLOPT_POSTFIELDS, $postviewinfo);
        curl_setopt($chviewinfo, CURLOPT_HTTPHEADER, $headerviewinfo);
        curl_setopt($chviewinfo, CURLOPT_FOLLOWLOCATION, 1);
        $resultviewinfo = curl_exec($chviewinfo);
        curl_close($chviewinfo);
        echo "<hr>textpush info:<br>" . $resultviewinfo . "\r\n";
        // $this->flexPushAdminMonitoring($textsjson);
    }

    function flexPushAdminMonitoring($json_text)
    {
        // $textsjson = json_decode($json_text, true);

        $urlviewinfo = 'https://api.line.me/v2/bot/message/push';
        $dataviewinfo = [
            // 'to' => $this->line_userid["umnarj"],
            'to' => $this->authention["umnarj"]["line_userid"],
            'messages' => [$json_text],
        ];
        $postviewinfo = json_encode($dataviewinfo);
        $headerviewinfo = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->line_setting["ChannelAccessToken"]);
        $chviewinfo = curl_init($urlviewinfo);
        curl_setopt($chviewinfo, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($chviewinfo, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chviewinfo, CURLOPT_POSTFIELDS, $postviewinfo);
        curl_setopt($chviewinfo, CURLOPT_HTTPHEADER, $headerviewinfo);
        curl_setopt($chviewinfo, CURLOPT_FOLLOWLOCATION, 1);
        $resultviewinfo = curl_exec($chviewinfo);
        curl_close($chviewinfo);
        echo "<hr>textpush info:<br>" . $resultviewinfo . "\r\n";
    }

    function flexMessage($json_text, $userId = NULL)
    {
        // $fnc = new core_function();
        // if (is_numeric($json_text)) {
        //     $json_text = $this->gen_flex_json_text($json_text);
        //     $json_text = $fnc->gen_flex_json_text($json_text);
        // }

        // $textsjson = json_decode($json_text, true);    
        // if (is_null($userId)) {
        //   $userId = $this->line_userid["umnarj"];
        // }

        $urlviewinfo = 'https://api.line.me/v2/bot/message/push';
        $dataviewinfo = [
            'to' => $userId,
            'messages' => [json_decode($json_text, true)],
        ];
        $postviewinfo = json_encode($dataviewinfo);
        $headerviewinfo = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->line_setting["ChannelAccessToken"]);
        $chviewinfo = curl_init($urlviewinfo);
        curl_setopt($chviewinfo, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($chviewinfo, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chviewinfo, CURLOPT_POSTFIELDS, $postviewinfo);
        curl_setopt($chviewinfo, CURLOPT_HTTPHEADER, $headerviewinfo);
        curl_setopt($chviewinfo, CURLOPT_FOLLOWLOCATION, 1);
        $resultviewinfo = curl_exec($chviewinfo);
        curl_close($chviewinfo);
        echo "<hr>flexmessage info:<br>" . $resultviewinfo . "\r\n";
    }
}

class core_function extends linecore
{
    public function user_register_lineId($citizenId, $lineId)
    {
        $sql = "SELECT `so_firstname`,`so_lastname` FROM `so-member` WHERE `so_citizen_id` = '" . $citizenId . "'";
        $user = $this->get_db_row($sql);
        if (!empty($user)) {
            $sql = "UPDATE `so-member` SET `so_lineid`='" . $lineId . "' WHERE `so_citizen_id` = '" . $citizenId . "'";
            // die ($sql);
            $this->sql_execute($sql);
            return array("success", "CitizenId: " . $citizenId . "\nline_Id: " . $lineId . "\nName: " . $user['so_firstname'] . " " . $user['so_lastname'] . "\n\nstatus: " . "Register is Completed.");
        } else {
            return array("error", "CitizenId: " . $citizenId . "\nline_Id: " . $lineId . "\n\nstatus: " . "Data not Founded.");
        }
    }

    public function get_user($col, $val, $event)
    {
        $sql = "SELECT admin_member_id FROM admin_member WHERE " . $col . " = '" . $val . "'";
        $val = $this->get_db_col($sql);
        if (!$val) {
            $text = "คุณยังไม่เคยลงทะเบียนกับเรา กรุณาลงทะเบียนก่อนค่ะ";
            $this->PushText($event, "text", $text);
            return NULL;
        } else {
            return $val;
        }
    }

    public function gen_quickryply_json_text($json_type = 0, $event = null)
    {
        $json_text = '{
            "to": "U3c28a70ed7c5e7ce2c9a7597...",
            "messages": [
              {
                "type": "text",
                "text": "Hello Quick Reply!",
                "quickReply": {
                  "items": [
                    {
                      "type": "action",
                      "action": {
                        "type": "uri",
                        "label": "URI",
                        "uri": "https://developers.line.biz"
                      }
                    },
                    {
                      "type": "action",
                      "action": {
                        "type": "cameraRoll",
                        "label": "Camera Roll"
                      }
                    },
                    {
                      "type": "action",
                      "action": {
                        "type": "camera",
                        "label": "Camera"
                      }
                    },
                    {
                      "type": "action",
                      "action": {
                        "type": "location",
                        "label": "Location"
                      }
                    },
                    {
                      "type": "action",
                      "imageUrl": "https://cdn1.iconfinder.com/data/icons/mix-color-3/502/Untitled-1-512.png",
                      "action": {
                        "type": "message",
                        "label": "Message",
                        "text": "Hello World!"
                      }
                      },
                    {
                      "type": "action",
                      "action": {
                        "type": "postback",
                        "label": "Postback",
                        "data": "action=buy&itemid=123",
                        "displayText": "Buy"
                      }
                      },
                    {
                      "type": "action",
                      "imageUrl": "https://icla.org/wp-content/uploads/2018/02/blue-calendar-icon.png",
                      "action": {
                        "type": "datetimepicker",
                        "label": "Datetime Picker",
                        "data": "storeId=12345",
                        "mode": "datetime",
                        "initial": "2018-08-10t00:00",
                        "max": "2018-12-31t23:59",
                        "min": "2018-08-01t00:00"
                      }
                    }
                  ]
                }
              }
             ]
          }';

        return $json_text;
    }
}
