<?php

use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class line_flex
{
    public function gen_flex_mini_idpa_info()
    {
        global $debug, $bot, $fnc, $line, $eventObj, $replyId, $ReplyToken;
        $json_text = '{ "type": "flex", "altText": "Arch Menu", "contents": ';
        $json_text .= '{
            "type": "bubble",
            "size": "giga",
            "hero": {
              "type": "image",
              "url": "https://idpasoth.com/images/mini_idpa_poster.jpg",
              "size": "full",
              "aspectMode": "cover",
              "action": {
                "type": "uri",
                "uri": "http://linecorp.com/"
              },
              "aspectRatio": "5:3"
            },
            "body": {
              "type": "box",
              "layout": "vertical",
              "contents": [
                {
                  "type": "text",
                  "text": "MINI IDPA ป้องกันไฟป่าฯ",
                  "weight": "bold",
                  "size": "lg",
                  "color": "#e10021"
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "margin": "lg",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "box",
                      "layout": "baseline",
                      "spacing": "sm",
                      "contents": [
                        {
                          "type": "text",
                          "text": "สถานที่",
                          "color": "#aaaaaa",
                          "size": "sm",
                          "flex": 1
                        },
                        {
                          "type": "text",
                          "text": "สนามยิงปืนกองพันพัฒนาที่ 3",
                          "wrap": true,
                          "color": "#666666",
                          "size": "sm",
                          "flex": 5
                        }
                      ]
                    },
                    {
                      "type": "box",
                      "layout": "baseline",
                      "spacing": "sm",
                      "contents": [
                        {
                          "type": "text",
                          "text": "วันเวลา",
                          "color": "#aaaaaa",
                          "size": "sm",
                          "flex": 1
                        },
                        {
                          "type": "text",
                          "text": "30 ม.ค. 65 / 09:00-16:00 น.",
                          "wrap": true,
                          "color": "#666666",
                          "size": "sm",
                          "flex": 5
                        }
                      ]
                    }
                  ]
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "contents": [
                    {
                      "type": "text",
                      "text": "กติกาการแข่งขัน",
                      "weight": "bold",
                      "size": "md",
                      "color": "#0253a9"
                    },
                    {
                      "type": "text",
                      "text": "1. เปิดกระดานคะแนนแต่ละประเภทมือ หรือชนิด ด้วย 2 ชุดยิง",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "2. ใช้บัตร 3 ใบ ต่อ 1 ชุดยิง ทำการยิงได้ 1 รอบ",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "3. ซื้อชุดยิงเพิ่มได้ตลอดเวลาแข่งขัน",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "4. ยิงประเภทมือเดิม หรือสูงขึ้นไปเท่านั้น (ข้อ 1)",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "5. แบ่งมือ U,NV,D / MM,SS,C,B / EX,MA,A,M,GM",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "6. แบ่งปืน CDP, CCP, BUG-S, BUG-R บรรจุ 8 / SSP, ESP, REV บรรจุ 10",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "7. ทิ้งแม๊กเปล่าเมื่อรังเพลิงว่างเท่านั้น",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "8. สวมเสื้อคลุมทุกสตริง",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "9. ผลการตัดสินของกรรมการ ถือเป็นสิ้นสุด",
                      "size": "xs",
                      "wrap": true
                    }
                  ],
                  "spacing": "none",
                  "margin": "xxl"
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "contents": [
                    {
                      "type": "text",
                      "text": "Division ปืน",
                      "weight": "bold",
                      "size": "md",
                      "color": "#0253A9"
                    },
                    {
                      "type": "text",
                      "text": "SSP กึ่งอัตโนมัติ เข็มพุ่ง ไกดับเบิ้ล 10 นัด",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "ESP กึ่งอัตโนมัติ 10 นัด",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "CCP กึ่งอัตโนมัติ 4.375\" 8 นัด",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "CDP กึ่งอัตโนมัติ .45 8 นัด",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "REV ลูกโม่ 4.25\" 6 นัด",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "BUG-S กึ่งอัตโนมัติ 3.5\" 6 นัด",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "BUG-R ลูกโม่ 2.5\" 5 นัด",
                      "size": "xs",
                      "wrap": true
                    },
                    {
                      "type": "separator",
                      "margin": "lg",
                      "color": "#e10021"
                    },
                    {
                      "type": "text",
                      "text": "* ห้ามเจาะพอร์ท, ติดดอท, ใส่คอมพ์, ถ่วงน้ำหนัก, ติดไฟฉาย, ใส่เลเซอร์ หรืออุปกรณ์ที่ทำให้ได้เปรียบผู้แข่งอื่น",
                      "size": "xs",
                      "wrap": true,
                      "color": "#e10021",
                      "align": "center",
                      "margin": "sm"
                    },
                    {
                      "type": "text",
                      "text": "ปืนอื่นๆ นอกกติกา IDPA ลงแข่ง 10 นัดมือโปรฯ",
                      "size": "xs",
                      "wrap": true,
                      "color": "#e10021",
                      "align": "center"
                    }
                  ],
                  "spacing": "none",
                  "margin": "xxl"
                }
              ]
            },
            "footer": {
              "type": "box",
              "layout": "vertical",
              "spacing": "sm",
              "contents": [
                {
                  "type": "box",
                  "layout": "horizontal",
                  "contents": [
                    {
                      "type": "button",
                      "action": {
                        "type": "message",
                        "label": "COF Stage#1",
                        "text": "cof1"
                      },
                      "style": "primary",
                      "margin": "none",
                      "height": "sm"
                    },
                    {
                      "type": "separator",
                      "margin": "xl"
                    },
                    {
                      "type": "button",
                      "action": {
                        "type": "message",
                        "label": "COF Stage#2",
                        "text": "cof2"
                      },
                      "style": "primary",
                      "margin": "none",
                      "height": "sm"
                    }
                  ],
                  "paddingAll": "lg"
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "contents": [
                    {
                      "type": "button",
                      "style": "primary",
                      "height": "sm",
                      "action": {
                        "type": "uri",
                        "label": "IDPA & MATCH RULE",
                        "uri": "https://idpasoth.com/images/idpa_rule_800px.jpg"
                      },
                      "color": "#3990e4"
                    }
                  ],
                  "paddingAll": "lg",
                  "paddingTop": "none"
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "contents": [
                    {
                      "type": "button",
                      "style": "primary",
                      "height": "sm",
                      "action": {
                        "type": "uri",
                        "label": "STAGE PLAN",
                        "uri": "https://idpasoth.com/images/STG_Plan.jpg"
                      },
                      "color": "#45BCB3"
                    }
                  ],
                  "paddingAll": "lg",
                  "paddingTop": "none"
                },
                {
                  "type": "spacer",
                  "size": "sm"
                }
              ],
              "flex": 0
            }
          }';
        $json_text .= ' }';
        return array(
            // array("datatype" => "replydata", "replyData" => "mini idpa info", "replyId" => $ReplyToken),
            array("datatype" => "json_text", "json_text" => $json_text, "replyId" => $replyId)
        );
    }

    public function gen_flex_global($flex_name, $line_userid = NULL, $dataPostback = Null)
    {
        global $debug, $bot, $fnc, $line, $eventObj;

        if (!empty($flex_name)) {
            // require_once("line-bot.php");
            $line = new linecore();

            switch ($flex_name) {
                case "mainmenu":
                    $json_text = '{ "type": "flex", "altText": "Arch Menu", "contents": ';
                    $json_text .= '{
            "type": "bubble",
            "hero": {
              "type": "image",
              "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png",
              "size": "full",
              "aspectRatio": "20:13",
              "aspectMode": "cover",
              "action": {
                "type": "uri",
                "uri": "http://linecorp.com/"
              }
            },
            "body": {
              "type": "box",
              "layout": "vertical",
              "contents": [
                {
                  "type": "text",
                  "text": "Arch Main Menu",
                  "weight": "bold",
                  "size": "xl",
                  "color": "#ba5024"
                },
                {
                  "type": "text",
                  "text": "โปรดเลือกเมนู",
                  "size": "sm",
                  "color": "#999999"
                }
              ]
            },
            "footer": {
              "type": "box",
              "layout": "vertical",
              "spacing": "sm",
              "contents": [
                {
                  "type": "button",
                  "style": "link",
                  "height": "sm",
                  "action": {
                    "type": "postback",
                    "label": "ระบบลงเวลาทำงาน",
                    "data": "action=TimeAttendanceMenu",
                    "displayText": "Time Attendance Menu"
                  }
                },
                {
                  "type": "button",
                  "style": "link",
                  "height": "sm",
                  "action": {
                    "type": "postback",
                    "label": "ระบบภาระงานสอน",
                    "data": "action=TeachingLoadMenu",
                    "displayText": "Teaching Load Menu"
                  }
                },
                {
                  "type": "button",
                  "style": "link",
                  "height": "sm",
                  "action": {
                    "type": "uri",
                    "label": "เข้าสู่เว็บไซต์คณะฯ",
                    "uri": "https://faed.mju.ac.th/dev/TeachingLoad"
                  }
                },
                {
                  "type": "spacer",
                  "size": "sm"
                }
              ],
              "flex": 0
            }
          }';
                    $json_text .= ' }';
                    return $json_text;
                    break;
                default:
                    $response = $bot->pushMessage("U94b9c26beec046b69f2e5c3de8838bd0", new TextMessageBuilder("debug error: flex teachingload" . "no flex name parameter"));
            }
        } else {
            $response = $bot->pushMessage("U94b9c26beec046b69f2e5c3de8838bd0", new TextMessageBuilder("debug error: flex teachingload" . "no flex name parameter"));
        }
        if (!empty($json_text)) {
            // $line->flexMessage($json_text, $eventObj['source']['userId']);
        }
    }

    public function gen_flex_soth_url($lineid)
    {
        $json_text = '{ "type": "flex", "altText": "lineregistering", "contents": ';
        $json_text .= '{
        "type": "bubble",
        "hero": {
          "type": "image",
          "url": "https://idpasoth.com/images/soth_banner.png",
          "size": "full",
          "aspectMode": "cover",
          "action": {
            "type": "uri",
            "uri": "http://linecorp.com/"
          },
          "aspectRatio": "95:36"
        },
        "footer": {
          "type": "box",
          "layout": "vertical",
          "spacing": "sm",
          "contents": [
            {
              "type": "button",
              "style": "primary",
              "height": "sm",
              "action": {
                "type": "uri",
                "label": "Go to SOTH Application",
                "uri": "https://idpasoth.com/sign/?lineid=' . $lineid . '"
              }
            }
          ],
          "flex": 0,
          "paddingAll": "lg"
        }
      }';
        $json_text .= ' }';
        return $json_text;
    }

    public function gen_flex_so_mainmenu($replyId)
    {
        global $wss, $debug, $bot, $fnc, $line, $eventObj, $SourceType, $ReplyToken, $SourceUserId;
        // * chick message form group ? change userId
        if ($SourceType == 'group') {
            $replyId = $SourceUserId;
        }

        // * check line id registered
        // $client = new nusoap_client("https://idpasoth.com/line/wss.php?wsdl", true);
        // $result = json_decode($client->call("check_user_register_lineId", array("lineId" => $replyId)), true)["so_citizen_id"];
        $result = $wss->call("check_user_register_lineId", array("lineId" => $replyId));
        // $hworld = $wss->call("HelloWorld");
        // $myscore = $wss->call("check_viewscore_available", array());
        // $match_result = $wss->call("check_matchresult_available", array());

        // $line->TextPush("flex so menu : preparing\\n result : " . $result, "test");
        // $line->TextPush("userid: ". $replyId, "test");
        // $line->TextPush("citizen: ". $result["so_citizen_id"] , "test");
        // $result = json_decode($result, true);

        $json_text = '{ "type": "flex", "altText": "SOTH Main Menu", "contents": ';
        $json_text .= '{
      "type": "bubble",
      "hero": {
        "type": "image",
        "url": "https://idpasoth.com/images/soth_banner.png",
        "size": "full",
        "aspectRatio": "94:36",
        "backgroundColor": "#FFFFFF",
        "align": "center",
        "margin": "none",
        "aspectMode": "cover",
        "position": "relative",
        "gravity": "top"
      },
      "body": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "Safety Officer TH",
            "weight": "bold",
            "size": "lg"
          },
          {
            "type": "text",
            "text": "โปรดเลือกหัวข้อที่ต้องการ ?' . $replyId . '",
            "size": "sm"
          }
        ]
      },
      "footer": {
        "type": "box",
        "layout": "vertical",
        "spacing": "sm",
        "contents": [
          {
            "type": "button",
            "style": "primary",
            "height": "sm",
            "action": {
              "type": "uri",
              "label": "เข้าระบบ SOTH App",
              "uri": "https://idpasoth.com"
            },
            "color": "#2e2467"
          }';
        if (empty(json_decode($result, true)["so_citizen_id"])) {
            $json_text .= ',
          {
            "type": "button",
            "style": "primary",
            "height": "sm",
            "action": {
              "type": "uri",
              "label": "สมัครสมาชิก SOTH App",
              "uri": "https://idpasoth.com/guest/register.php"
            },
            "color": "#527DF3"
          }';
        }
        $json_text .= ',
          {
            "type": "separator",
            "margin": "lg"
          },';

        if (!empty(json_decode($result, true)["so_citizen_id"])) {
            $json_text .= '{
      "type": "button",
      "style": "primary",
      "height": "sm",
      "action": {
        "type": "postback",
        "label": "ประวัติการปฏิบัติงาน",
        "data": "action=myduty&lineid=' . $replyId . '"
      },
      "color": "#cd3b3e"
    },';
        } else {
            $json_text .= '{
        "type": "button",
        "style": "primary",
        "height": "sm",
        "action": {
          "type": "message",
          "label": "ลงทะเบียน LINE",
          "text": "*reg"
        }
      },';
        }

        $json_text .= '{
            "type": "separator",
            "margin": "lg"
          },
          {
            "type": "button",
            "style": "primary",
            "height": "sm",
            "action": {
              "type": "uri",
              "label": "ตารางการแข่งขัน 2022",
              "uri": "https://idpasoth.com/schedule/?p=schedule&y=2022"
            },
            "color": "#58719b"
          }
        ],
        "flex": 0
      }
    }';
        $json_text .= ' }';
        // $line->TextPush("flex so menu : \\n" . $json_text, "umnarj");
        $replyData = new TextMessageBuilder("โปรดตรวจสอบใน SOTH Official.");
        return array(
            array("datatype" => "replydata", "replyData" => $replyData, "replyId" => $ReplyToken),
            array("datatype" => "json_text", "json_text" => $json_text, "replyId" => $replyId)
        );
        // return NULL;
    }

    public function gen_flex_match_mainmenu($userId)
    {
        global $wss, $debug, $bot, $fnc, $line;
        // * check line id registered
        // $client = new nusoap_client("https://idpasoth.com/line/wss.php?wsdl", true);
        // $result = json_decode($client->call("check_user_register_lineId", array("lineId" => $userId)), true)["so_citizen_id"];
        // $result = $wss->call("check_user_register_lineId", array("lineId" => $userId));
        $myscore = $wss->call("check_viewscore_available", array());
        $match_result = $wss->call("check_matchresult_available", array());
        // $line->TextPush("userid: ". $userId, "test");
        // $line->TextPush("citizen: ". $result["so_citizen_id"] , "test");
        // $result = json_decode($result, true);

        $json_text = '{ "type": "flex", "altText": "SOTH Main Menu", "contents": ';
        $json_text .= '{
      "type": "bubble",
      "hero": {
        "type": "image",
        "url": "https://idpasoth.com/images/soth_banner.png",
        "size": "full",
        "aspectRatio": "94:36",
        "backgroundColor": "#FFFFFF",
        "align": "center",
        "margin": "none",
        "aspectMode": "cover",
        "position": "relative",
        "gravity": "top"
      },
      "body": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "Phumpailin IDPA Charity 2021",
            "align": "center",
            "weight": "bold",
            "color": "#3f6ef9",
            "size": "md"
          },
          {
            "type": "text",
            "text": "Dec 26, 2021",
            "align": "center",
            "size": "xs",
            "weight": "bold",
            "color": "#555e64"
          },
          {
            "type": "separator",
            "margin": "lg"
          },
          {
            "type": "box",
            "layout": "vertical",
            "contents": []
          }
        ]
      },
      "footer": {
        "type": "box",
        "layout": "vertical",
        "spacing": "sm",
        "contents": [
          {
            "type": "button",
            "style": "primary",
            "height": "md",
            "action": {
              "type": "uri",
              "label": "Shooters - ข้อมูลนักกีฬา",
              "uri": "https://idpasoth.com/match/shooters/"
            },
            "color": "#1fb327"
          }';

        if ($myscore) {
            $json_text .= ',
          {
            "type": "button",
            "style": "primary",
            "height": "md",
            "action": {
              "type": "uri",
              "label": "My Score - ตรวจดูคะแนน",
              "uri": "https://idpasoth.com/shooter/"
            },
            "color": "#527DF3"
          }';
        }

        if ($match_result) {
            $json_text .= ',
          {
            "type": "button",
            "style": "primary",
            "height": "md",
            "action": {
              "type": "uri",
              "label": "Match Result - สรุปผลการแข่งขัน",
              "uri": "https://idpasoth.com/match/result/?v=overall"
            },
            "color": "#58719b"
          }';
        }
        // $json_text .= ',
        // {
        //   "type": "separator",
        //   "margin": "xl"
        // },
        // {
        //   "type": "separator",
        //   "margin": "xl"
        // },
        // {
        //   "type": "button",
        //   "style": "primary",
        //   "height": "sm",
        //   "action": {
        //     "type": "message",
        //     "label": "SO - ผู้ตัดสิน",
        //     "text": "so menu"
        //   },
        //   "color": "#cd3b3e"
        // } ';
        $json_text .= '
        ],
        "flex": 0
      }
    }';
        $json_text .= ' }';
        return $json_text;
    }

    public function gen_flex_so_info($type, $userId)
    {
        global $wss, $debug, $bot, $fnc, $line;

        switch ($type) {
            case "myduty":
                $sql = "SELECT `match_name`,`match_level`,`match_begin`,`on_duty_position` FROM `v_on_duty` WHERE `on_duty_status` = 'enable' AND `match_status` = 'enable' AND `so_lineid` = '" . $userId . "' ORDER BY match_begin Desc";
                $line->TextPush("flex duty sql: " . $sql, "umnarj");
                $data_array = $fnc->get_db_rows($sql);
                if (!empty($data_array)) {
                    $line->TextPush("flex duty data_array : having data", "umnarj");
                } else {
                    $line->TextPush("flex duty data_array : no data", "umnarj");
                }
                $json_text = '{ "type": "flex", "altText": "SOTH Main Menu", "contents": ';
                $json_text .= '{
            "type": "bubble",
            "size": "giga",
            "hero": {
              "type": "image",
              "url": "https://idpasoth.com/images/soth_banner.png",
              "size": "full",
              "aspectRatio": "94:36",
              "backgroundColor": "#FFFFFF",
              "align": "center",
              "margin": "none",
              "aspectMode": "cover",
              "position": "relative",
              "gravity": "top"
            },
            "body": {
              "type": "box",
              "layout": "vertical",
              "contents": [
                {
                  "type": "text",
                  "text": "ประวัติการทำงานของ",
                  "align": "center",
                  "weight": "bold",
                  "margin": "none"
                },
                {
                  "type": "text",
                  "text": "TH1003366 อำนาจ ชิดทอง",
                  "align": "center",
                  "margin": "sm"
                },
                {
                  "type": "text",
                  "text": "รวม ' . count($data_array) . ' ครั้ง",
                  "color": "#999999",
                  "size": "xs",
                  "offsetTop": "md"
                }';
                if (!empty($data_array)) {
                    // $line->TextPush("flex duty sql: ". $sql, "test");
                    $duty = "";
                    foreach ($data_array as $row) {
                        $duty .= ',
              {
              "type": "box",
              "layout": "horizontal",
              "contents": [
                {
                  "type": "text",
                  "text": "';
                        $duty .= date("M d, Y", strtotime($row["match_begin"]));
                        $duty .= '",
                  "size": "xs",
                  "gravity": "center",
                  "flex": 2
                },
                {
                  "type": "text",
                  "text": "' . $row["match_name"] . ' (' . $row["match_level"] . ') / ' . $row["on_duty_position"] . '",
                  "gravity": "center",
                  "size": "xs",
                  "align": "start",
                  "flex": 6
                }
              ],
              "spacing": "lg",
              "cornerRadius": "30px",
              "margin": "md"
            }';
                    }
                    $json_text .= $duty;
                }
                $json_text .= '
              ]
            },
            "footer": {
              "type": "box",
              "layout": "horizontal",
              "contents": [
                {
                  "type": "text",
                  "text": "ออกรายงานโดยระบบ SOTH.",
                  "size": "xxs",
                  "color": "#666666",
                  "weight": "bold",
                  "offsetStart": "lg"
                },
                {
                  "type": "text",
                  "text": "วันที่ 23 ธ.ค. 64",
                  "size": "xxs",
                  "color": "#999999",
                  "offsetStart": "none",
                  "align": "end"
                }
              ]
            }
          }';
                $json_text .= ' }';
                $line->TextPush("flex duty json: " . $json_text, "test");
                return $json_text;
                break;
        }
    }
}
