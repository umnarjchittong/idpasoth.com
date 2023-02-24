<?php

session_start();
// echo '<meta charset="UTF-8">';
date_default_timezone_set("Asia/Bangkok");



class settings
{
    // Configures
    public $user_chk_first = false;

    // Constants
    // public $message_text = array();
    public $line_userid = array(
        "tk" => "Ua896434ac488b74992c4e4dff85ac459",
        "test" => "U38a2a50b9b25da532e46c0181c66d826",
        "umnarj" => "U94b9c26beec046b69f2e5c3de8838bd0",
        "salinee" => "U159f9e69a02d9657383ea028c8a816aa",
        "chokanan" => "Ud5c318e30968a5646633a97fcf88b28f",
        "thamnieb" => "U341c2cae641d0963b37953ee937261c5",
        "punsak" => "U2339765bc75ab757b9d2f83d612feef2",
        "nachawit" => "Ub3f8f39b1f02c136308b33e4b7ae481e",
        "punravee" => "Ub5d9fd961bbf7b8ba0f467a77faf9f69",
        "porntip" => "U398b227f0b017492859a153ff82e0fb8",
        "thawatchai" => "U444f6c52690f34bc21cb5256b49f84e0"
    );

    public $board_list = array("umnarj", "chokanan", "thamnieb", "phansak", "nachawit", "punravee", "porntip", "thawatchai");
    // public $board_list = array("umnarj", "tk", "test");

    public $authention = array(
        "umnarj" => array(
            "memberid" => "admin",
            "pid" => "3500700238956",
            "email" => "umnarjchittong@gmail.com",
            "name" => "umnarj",
            "line_userid" => "U39d75c332530aeae3be2661a182e8539"
        ),
        "chokanan" => array(
            "memberid" => "1",
            "pid" => "3509900264894",
            "email" => "Chokanan@mju.ac.th",
            "name" => "chokanan",
            "line_userid" => "Ud5c318e30968a5646633a97fcf88b28f"
            // "line_userid" => "U0146eb03d721963acc198a4589f6ebb2"
        ),
        "thamniap" => array(
            "memberid" => "2",
            "pid" => "3470101438941",
            "email" => "Thamniap@mju.ac.th",
            "name" => "thamniap",
            "line_userid" => "U341c2cae641d0963b37953ee937261c5"
            // "line_userid" => "U0146eb03d721963acc198a4589f6ebb2"
        ),
        "nachawit" => array(
            "memberid" => "3",
            "pid" => "3102401232374",
            "email" => "Nachawit@mju.ac.th",
            "name" => "nachawit",
            "line_userid" => "Ub3f8f39b1f02c136308b33e4b7ae481e"
            // "line_userid" => "U0146eb03d721963acc198a4589f6ebb2"
        ),
        "phansak" => array(
            "memberid" => "4",
            "pid" => "4501900002319",
            "email" => "Phansak@mju.ac.th",
            "name" => "phansak",
            "line_userid" => "U2339765bc75ab757b9d2f83d612feef2"
            // "line_userid" => "U0146eb03d721963acc198a4589f6ebb2"
        ),
        "punravee" => array(
            "memberid" => "5",
            "pid" => "3501300659751",
            "email" => "Punravee@mju.ac.th",
            "name" => "punravee",
            "line_userid" => "Ub5d9fd961bbf7b8ba0f467a77faf9f69"
            // "line_userid" => "U0146eb03d721963acc198a4589f6ebb2"
        ),
        "porntip" => array(
            "memberid" => "6",
            "pid" => "3401200159781",
            "email" => "Porntip@mju.ac.th",
            "name" => "porntip",
            "line_userid" => "U398b227f0b017492859a153ff82e0fb8"
            // "line_userid" => "U0146eb03d721963acc198a4589f6ebb2"
        ),
        "thawatchai" => array(
            "memberid" => "7",
            "pid" => "3509901000475",
            "email" => "thawatchai@mju.ac.th",
            "name" => "thawatchai",
            "line_userid" => "U444f6c52690f34bc21cb5256b49f84e0"
            // "line_userid" => "U0146eb03d721963acc198a4589f6ebb2"
        ),
        "phongnapa" => array(
            "memberid" => "officer",
            "pid" => "3510100314708",
            "email" => "Phongnapa@mju.ac.th",
            "name" => "phongnapa",
            "line_userid" => ""
        )
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
    // private $db = array("server" => "10.1.3.5:3306", "user" => "soth", "pass" => "faedadmin", "name" => "soth");
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
    public $line_setting = array(
        "ChannelID" => "1655453169",
        "ChannelName" => "SOTH",
        "BotBasicID" => "@674lsmcs",
        "YourUserID" => "U94b9c26beec046b69f2e5c3de8838bd0",
        "ChannelSecret" => "d6efe68166e8bb6cf8cbc445be0efdf6",
        "ChannelAccessToken" => "Ii5m9kZAkix1Noh0PmAlbTo3mPMXbq1rhOtQ9STkaAo13nHJpjQxtRO7JMhUht2FeA6YTE41o8jAHvNcNJlrTj7ebbmuwUw0w/C0m1VaJAJ6/iTafor22GLjU1YxmhKDNkI2DAGkNE6U1wC0zMY87wdB04t89/1O/w1cDnyilFU="
    );

    // public function j

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
        // $json_text = '{
        //   "type": "flex",
        //   "altText": "มีสายตรงคณบดีใหม่",
        //   "contents": ';
        $json_text = '{
        "
            "type": "text",
            "text": "Hello Quick Reply!",
            "quickReply": {
              "items": [
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
          
      }';
        // $json_text .= '}';


        return $json_text;
    }
}

class MJU_API extends CommonFnc
{
    private $api_url = "";
    public function get_api_info($title = "", $api_url, $print_r = false)
    {
        $array_data = $this->GetAPI_array($api_url);
        echo "<h3 style='color:#1f65cf'>API Information: $title</h3>";
        echo "<h4 style='color:#cf1f7a'>#row: " . $this->get_row_count($array_data) . "</br>";
        echo "#column: " . $this->get_col_count($array_data) . "</br>";
        echo "@column name: <br><span style='color:#741fcf; font-size:0.8em'>";
        $this->get_col_name($array_data, true);
        echo "</span></h4><hr>";
        if ($print_r) {
            print_r($array_data);
            echo "<hr>";
        }
    }

    public function get_row_count($array, $print_r = false)
    {
        return count($array);
    }

    public function get_col_count($array, $print_r = false)
    {
        return count($array[0]);
    }

    public function get_col_name($array, $print_r = false)
    {
        if ($print_r) {
            print_r(array_keys($array[0]));
        }
        return array_keys($array[0]);
    }

    public function gen_array_filter($array, $key, $value)
    {
        $result = array();
        foreach ($array as $k => $val) {
            if ($val[$key] == $value) {
                array_push($result, $array[$k]);
            }
        }
        return $result;
    }

    public function get_array_filters($array, $key1, $value1, $key2 = null, $value2 = null, $key3 = null, $value3 = null, $key4 = null, $value4 = null, $key5 = null, $value5 = null)
    {
        $result = $array;
        $this->debug_console("get_array_filter2 started");

        if ($key5 && $value5) {
            $result = $this->gen_array_filter($result, $key5, $value5);
            $this->debug_console("gen_array_filter condition #5 completed");
        }
        if ($key4 && $value4) {
            $result = $this->gen_array_filter($result, $key4, $value4);
            $this->debug_console("gen_array_filter condition #4 completed");
        }
        if ($key3 && $value3) {
            $result = $this->gen_array_filter($result, $key3, $value3);
            $this->debug_console("gen_array_filter condition #3 completed");
        }
        if ($key2 && $value2) {
            $result = $this->gen_array_filter($result, $key2, $value2);
            $this->debug_console("gen_array_filter condition #2 completed");
        }
        if ($key1 && $value1) {
            $result = $this->gen_array_filter($result, $key1, $value1);
            $this->debug_console("gen_array_filter condition #1 completed");
        }

        if (count($result)) {
            $this->debug_console("#row of result : " . count($result));
            return $result;
        } else {
            return null;
        }
    }

    public function get_row($array_data, $num_row = 1, $print_r = false)
    {
        if (isset($array_data) && isset($num_row)) {
            return $array_data[$num_row];
        } else {
            return null;
        }
    }

    public function get_col($array_data, $num_row, $col_name, $print_r = false)
    {
        if (isset($array_data) && isset($num_row) && isset($col_name)) {
            if ($print_r) {
                print_r($array_data[$num_row][$col_name]);
            }
            return $array_data[$num_row][$col_name];
        } else {
            return null;
        }
    }

    public function get_last_id($tbl = "activity", $col = "act_id")
    {
        $sql = "select " . $col . " from " . $tbl;
        $sql .= " order by " . $col . " Desc Limit 1";
        // return $this->get_db_col($sql);
        $database = new $this->database();
        return $database->get_db_col($sql);
    }

    function arraysearch_rownum($key, $value, $array)
    {
        foreach ($array as $k => $val) {
            if ($val[$key] == $value) {
                return $k;
            }
        }
        return null;
    }

    // not Supported for SSL
    /*
    Function GetAPI_array($API_URL) {
        $data = file_get_contents($API_URL); // put the contents of the file into a variable            
        $array_data = json_decode($data, true);

        return $array_data;
    }
    */

    // update for SSL
    function GetAPI_array($API_URL)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $data = file_get_contents($API_URL, false, stream_context_create($arrContextOptions)); // put the contents of the file into a variable                   
        $array_data = json_decode($data, true);

        return $array_data;
    }

    function GetAPI_object($API_URL)
    {
        $data = file_get_contents($API_URL); // put the contents of the file into a variable    
        $obj_data = json_decode($data); // decode the JSON to obj        
        return $obj_data;
    }
}

class Mailer extends CommonFnc
{
    public function gen_activate_link()
    {
    }

    public function gen_email($data)
    {
        $database = new Database;
        // $data = array(
        //     "receiver_address" => $_POST["receiver_address"],
        //     "receiver_name" => $_POST["receiver_address"],
        //     "from_address" => $_SESSION["admin"]["e_mail"],
        //     // "from_name" => $_POST["m_replyuser"],
        //     "from_name" => "คณะสถาปัตยกรรมศาสตร์ฯ มหาวิทยาลัยแม่โจ้",
        //     "reply_address" => "archmaejo@gmail.com",
        //     "reply_name" => "คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้",
        //     "cc_address" => "",
        //     "cc_name" => "",
        //     "cc_address1" => "",
        //     "cc_name1" => "",
        //     "cc_address2" => "",
        //     "cc_name2" => "",
        //     "subject" => "การตอบกลับข้อความสายตรงคณบดีของท่าน",
        //     "content" => $_POST["m_reply"],
        //     "next_url" => "../admin/message.php?p=read&action=replied&id=" . $_POST["m_id"]
        // );        

        // $sql = "select * from message where message_id = " . $_POST["m_id"];
        // $row = $database->get_db_row($sql);
        // $m_created = $this->get_date_semi_th($row["message_created"]);

        $content = array(
            "title" => '<div class="mb-2"><strong class="mb-2">เรียน คุณ' . $data["receiver_name"] . '</strong></div>',
            "subject" => '<div class="mb-4"><strong class="mb-2">เรื่อง ยืนยันสิทธิ์ศิษย์เก่า</strong></div>',
            "content_intro" => '',
            "content_m_memo" => '',
            "content_then" => 'ในการนี้ กดลิงค์เถอะ',
            "reply_by" => "รองคณบดีฯ",
            "reply_by_fullname" => "ผศ.พันธุ์ศักดิ์ ชัยภักดี"
        );

        $data["content"] = $this->email_content_html($content);

        // die($data["content"]);

        $_SESSION["data"] = $data;
        $this->debug_console("email data: ", $data);
        // $_SESSION["data_json"] = json_encode($data, JSON_UNESCAPED_UNICODE);
        // echo "<br>" . $_SESSION["data"] . "<hr style:margin-bottom: 1em;>";

        // $sql = "UPDATE message SET message_status='completed',message_replied=CURRENT_TIMESTAMP,message_completed=CURRENT_TIMESTAMP,message_replytext='" . $_POST["m_reply"] . "',message_replyuser='" . $_SESSION["admin"]["board_fullname"] . "',message_replyuser_position='" . $_SESSION["admin"]["board"] . "' WHERE message_id = " . $_POST["m_id"];
        // $database->sql_execute($sql);

        // header("Location:../phpmailer/mail.php?type=session&next=true");

    }

    private function email_content_html($content)
    {
        // $content_html = '<!doctype html><html lang="en">';
        $content_html = '<meta charset="UTF-8">';
        // $content_html .= '<head>';
        // $content_html .= '<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        // $content_html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">';
        // $content_html .= '<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">';
        // $content_html .= '<title>ระบบสายตรงคณบดี</title>';
        $content_html .= '<style>';
        $content_html .= 'body { font-family: Kanit, sans-serif; font-size: 1rem; letter-spacing: 0.075em; color: #000; }';
        $content_html .= '.footer-text { letter-spacing: 0.1em; }';
        $content_html .= '</style>';
        // $content_html .= '</head>';

        $content_html .= '<body>';
        $content_html .= '<div class="container col-10 col-lg-8 p-2 align-self-center" style="padding: 4em;">';
        $content_html .= '<div id="title">';
        $content_html .= $content["title"] . $content["subject"];
        $content_html .= '</div>';
        $content_html .= '<div id="content" class="text-black">';
        $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
        $content_html .= $content["content_intro"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
        $content_html .= $content["content_m_memo"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
        $content_html .= $content["content_then"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
        // $content_html .= $_POST["m_reply"];
        $content_html .= '</p>';
        $content_html .= '</div>';

        $content_html .= '<br><br>';
        $content_html .= '<div id="footer" class="mt-3 text-black">';
        $content_html .= '  <div style="float: left; width: 50%; padding: 10px;"></div>';
        $content_html .= '  <div class="mt-2 col-auto offset-6">';
        $content_html .= '      <div>';
        $content_html .= $content["reply_by_fullname"];
        $content_html .= '      </div>';
        $content_html .= '  <div style="float: left; width: 50%; padding: 10px;"></div>';
        $content_html .= '      <div>';
        $content_html .= $content["reply_by"];
        $content_html .= '      </div>';
        $content_html .= '  </div>';
        $content_html .= '</div>';

        $content_html .= '<hr class="my-4">';
        $content_html .= '<div class="row mt-1 p-2" style="content: ""; display: table; clear: both;">';
        $content_html .= '<div class="col-auto" style="float: left; width: 100px; padding: 10px;"><img src="https://arch.mju.ac.th/img/mju_logo.jpg" width="75px"></div>';
        $content_html .= '<div class="col text-black-50 pt-1" style="margit-top: 2em;>';
        $content_html .= '<p class="footer-text" style="font-size: 0.8em;">คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้<br>';
        $content_html .= '<sapn>63/4 ถ.เชียงใหม่-พร้าว อ.สันทราย จ.เชียงใหม่ 50290</sapn><br>';
        $content_html .= '<span>โทร 053873350</span><span class="ms-2">Email: <a href="mailto:arch@mju.ac.th">arch@mju.ac.th</a></span><br><span><a href="https://arch.mju.ac.th" target="_blank">arch.mju.ac.th</a></span><span class="ms-2"> <a href="https://www.facebook.com/ArchMaejo/" target="_blank">FB: fb.com/archmaejo</a></span>';
        $content_html .= '</p>';
        $content_html .= '</div>';
        $content_html .= '</div>';
        $content_html .= '</div>';
        // $content_html .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>';
        $content_html .= '</body>';
        // $content_html .= '</html>';
        return $content_html;
    }

    private function email_content_html2($content)
    {
        $content_html = '<!doctype html><html lang="en">';
        $content_html .= '<meta charset="UTF-8">';
        $content_html .= '<head>';
        $content_html .= '<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $content_html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">';
        $content_html .= '<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">';
        $content_html .= '<title>ระบบสายตรงคณบดี</title>';
        $content_html .= '<style>';
        $content_html .= 'body { font-family: Kanit, sans-serif; font-size: 1rem; letter-spacing: 0.075em; color: #000; }';
        $content_html .= '.footer-text { letter-spacing: 0.1em; }';
        $content_html .= '</style>';
        $content_html .= '</head>
        
        <body>';
        $content_html .= '<div class="container col-10 col-lg-8 p-2">';
        $content_html .= '<div id="title">';
        $content_html .= $content["title"] . $content["subject"];
        $content_html .= '</div>';
        $content_html .= '<div id="content" class="text-black">';
        $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
        $content_html .= $content["content_intro"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
        $content_html .= $content["content_m_memo"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
        $content_html .= $content["content_then"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
        $content_html .= $_POST["m_reply"];
        $content_html .= '</p>';
        $content_html .= '</div>

        <div id="footer" class="mt-3 text-black">';
        $content_html .= '<br><br>
        ';
        $content_html .= '<div class="mt-2 col-auto offset-6">';
        $content_html .= '<div>';
        $content_html .= $content["reply_by_fullname"];
        $content_html .= '</div>';
        $content_html .= '<div>';
        $content_html .= $content["reply_by"];
        $content_html .= '</div>';
        $content_html .= '</div>';
        $content_html .= '</div>

        <hr class="my-4">';
        $content_html .= '<div class="row mt-1 p-2" style="">';
        $content_html .= '<div class="col-auto"><img src="https://arch.mju.ac.th/img/mju_logo.jpg" width="75px"></div>';
        $content_html .= '<div class="col text-black-50 pt-1">';
        $content_html .= '<p class="footer-text" style="font-size: 0.8em;">คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้<br>';
        $content_html .= '<sapn>63/4 ถ.เชียงใหม่-พร้าว อ.สันทราย จ.เชียงใหม่ 50290</sapn><br>';
        $content_html .= '<span>โทร 053873350</span><span class="ms-2">Email: <a href="mailto:arch@mju.ac.th">arch@mju.ac.th</a></span><br><span><a href="https://arch.mju.ac.th" target="_blank">arch.mju.ac.th</a></span><span class="ms-2"><a href="https://www.facebook.com/ArchMaejo/" target="_blank">FB: fb.com/archmaejo</a></span>';
        $content_html .= '</p>';
        $content_html .= '</div>';
        $content_html .= '</div>';
        $content_html .= '</div>';
        $content_html .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>';
        $content_html .= '</body>';
        $content_html .= '</html>';
        return $content_html;
    }
}
