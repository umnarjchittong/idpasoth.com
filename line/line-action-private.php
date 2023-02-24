<?php
///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
use LINE\LINEBot\QuickReplyBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\RichMenuBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;


require_once("lib/nusoap.php");
$line = new linecore();

function authen_user($user_id, $authen_list)
{
    if (!$user_id || !$authen_list) {
        return false;
    } else {
        global $line;
        $user_right = false;
        if (is_array($authen_list)) {
            foreach ($authen_list as $user) {
                if ($user_id == $line->authention[$user]["line_userid"]) {
                    $user_right = true;
                }
            }
        } else {
            if ($user_id == $authen_list) {
                $user_right = true;
            }
        }
        return $user_right;
    }
}

$reply_right = false;

if ($is_message) {
    $flex = new line_flex();
    if ($eventObj["message"]["type"] == "text") {
        // Text Checker
        switch ($eventObj["message"]["text"]) {
            case 'ans':
                $response = $bot->getProfile($events['events'][0]['source']['userId']);
                $profile = $response->getJSONDecodedBody();
                // echo $profile['displayName'];
                // echo $profile['pictureUrl'];
                // echo $profile['statusMessage'];                
                $text = $profile['displayName'] . " นี่คือทดสอบการตอบกลับข้อความเฉพาะบุคคลค่ะ";
                // $text = "นี่คือทดสอบการตอบกลับข้อความเฉพาะบุคคลค่ะ";
                $replyData = new TextMessageBuilder($text);
                $reply_right = true;
                $process_done = true;
                break;
            case "สายตรงคณบดี":
                $reply_right = authen_user($events['events'][0]['source']['userId'], array("umnarj", "chokanan", "thamnieb", "phansak", "nachawit", "punravee", "porntip", "thawatchai"));
                $json_text = $flex->gen_flex_message("สายตรงคณบดี", $events['events'][0]['source']['userId']);
                // $json_text = $fnc->gen_flex_message_dean_dm("สายตรงคณบดี");
                // $json_text = gen_flex_message("สายตรงคณบดี");                      
                // $line->flexMessage($json_text, $events['events'][0]['source']['userId']);
                break;

                // case "au":
                //     $text = "sending message to " . "umnarj";
                //     $replyData = new TextMessageBuilder($text);
                //     break;
                // case "ac":
                //     $text = "chittong";
                //     $replyData = new TextMessageBuilder($text);
                //     break;
                // case "alogin":
                //     $text = "สามารถเข้าระบบได้จากลิงค์นี้ค่ะ\n\n";
                //     $text .= "http://www.faed.mju.ac.th/it/dean_dm/signin/";
                //     $replyData = new TextMessageBuilder($text);
                //     break;
                // case "aoqes":
                //     $text = "สามารถเข้าระบบได้จากลิงค์นี้ค่ะ\n\n";
                //     $text .= "http://www.faed.mju.ac.th/it/oqes_report";
                //     $replyData = new TextMessageBuilder($text);
                //     break;
                // case "aสายตรงคณบดี":
                //     $json_text = $fnc->gen_flex_message_dean_dm("ระบบสายตรงคณบดี");
                //     $line->flexMessage($json_text, $events['events'][0]['source']['userId']);
                //     break;
                // default:
                //     $text = "ที่ถามมายังตอบไม่ได้นะคะ กำลังสอนน้องบอทอยู่ค่ะ";
                //     $replyData = new TextMessageBuilder($text);
                // $text = "เบื้องต้น สามารถตอบคำถามดังนี้ค่ะ\n\n";
                // $text .= "    1. สมัครสมาชิก\n";
                // $text .= "    2. rulebook\n";
                // $text .= "    3. ติดต่อ SOTH\n";
                // $text .= "    4. สมัครแข่งขัน\n";
                // $text .= "    5. รายชื่อนักกีฬา\n";
                // $text .= "    6. แบบสนาม\n";
                // $text .= "    7. ตรวจคะแนน\n";
                // $text .= "    8. ติดต่อ MD";
                // $line->PushText($event, "text", $text);
        }
    }
}

if ($is_postback) {
    $flex = new line_flex();
    // $line->TextPush("is_postback - " . $content);
    if ($dataPostback) {
        // $line->TextPush("text postback newdm-" . $dataPostback["action"]);
        // Text Checker
        switch ($dataPostback["action"]) {
            case 'ans':
                // $profile = $response->getJSONDecodedBody();
                // echo $profile['displayName'];
                // echo $profile['pictureUrl'];
                // echo $profile['statusMessage'];                
                // $text = $profile['displayName'] . " นี่คือทดสอบการตอบกลับข้อความเฉพาะบุคคลค่ะ";
                $text = "นี่คือทดสอบการตอบกลับข้อความเฉพาะบุคคลค่ะ";
                $replyData = new TextMessageBuilder($text);
                $process_done = true;
                break;
            case "viewnewdm":
                $reply_right = authen_user($events['events'][0]['source']['userId'], array("umnarj", "chokanan", "thamnieb", "phansak", "nachawit", "punravee", "porntip", "thawatchai"));
                $json_text = $flex->gen_flex_message($dataPostback["action"], $events['events'][0]['source']['userId'], $dataPostback);
                // $line->TextPush("text postback newdm-" . $dataPostback["action"]);
                // $line->TextPush("text postback newdm-" . $json_text);
                break;
            case "viewreaddm":
                $reply_right = authen_user($events['events'][0]['source']['userId'], array("umnarj", "chokanan", "thamnieb", "phansak", "nachawit", "punravee", "porntip", "thawatchai"));
                $json_text = $flex->gen_flex_message($dataPostback["action"], $events['events'][0]['source']['userId'], $dataPostback);
                // $line->TextPush("text postback newdm-" . $dataPostback["action"]);
                // $line->TextPush("text postback newdm-" . $json_text);
                break;
            case "viewdm":
                $reply_right = authen_user($events['events'][0]['source']['userId'], array("umnarj", "chokanan", "thamnieb", "phansak", "nachawit", "punravee", "porntip", "thawatchai"));
                $json_text = $flex->gen_flex_message($dataPostback["action"], $events['events'][0]['source']['userId'], $dataPostback);
                // $line->TextPush("text postback newdm-" . $dataPostback["action"]);
                // $line->TextPush("text postback newdm-" . $json_text);
                break;
            case "dmread":
                if ($dataPostback["dm_id"]) {
                    $reply_right = authen_user($events['events'][0]['source']['userId'], array("umnarj", "chokanan", "thamnieb", "phansak", "nachawit", "punravee", "porntip", "thawatchai"));
                    $client = new nusoap_client("http://www.faed.mju.ac.th/it/dean_dm/wss.php?wsdl", true);
                    $data = $client->call("setDeanDM_Status_Read", array("dm_id" => $dataPostback["dm_id"]));
                    $replyData = new TextMessageBuilder($data);
                    $process_done = true;
                }
                break;
        }
    }
}


// check user authention right
if ($reply_right) {
    if ($replyData) {
        if ($push_userid) {
            $response = $bot->pushMessage($push_userid, $replyData);
        } else {
            $response = $bot->replyMessage($ReplyToken, $replyData);
        }
    }
    if ($json_text) {
        $line->flexMessage($json_text, $eventObj['source']['userId']);
    }
    $process_done = true;
} else {
}
$replyData = NULL;
$json_text = NULL;
