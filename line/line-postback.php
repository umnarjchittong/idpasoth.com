<?php
// * ส่วนของการเรียกใช้งาน class ผ่าน namespace
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

class line_postback
{

    public function chk($text = "CHK")
    {
        global $response, $bot, $ReplyToken;
        $replyData = new TextMessageBuilder($text);
        $response = $bot->replyMessage($ReplyToken, $replyData);
    }

    public function chk_replydata($replyData)
    {
        global $response, $bot, $ReplyToken, $userId;
        $response = $bot->replyMessage($ReplyToken, $replyData);
    }

    public function postback_action($dataPostback)
    {
        global $response, $bot, $ReplyToken, $userId, $line;
        if ($dataPostback["action"]) {
            $flex = new line_flex();
            switch ($dataPostback["action"]) {
                case "myduty":                    
                    $json_text = $flex->gen_flex_so_info("myduty", $dataPostback["lineid"]);
                    return array("datatype" => "json_text", "json_text" => $json_text);
                    break;
                case "TeachingLoadMenu":
                    // $json_text = $flex->gen_flex_teachingload("teaching-menu");
                    break;
                case "myteachingload":
                    // * check registered line id
                    // * if not registered line id show quick reply to registering
                    require __DIR__ . '/vendor/autoload.php';
                    $client = new nusoap_client("https://faed.mju.ac.th/dev/TeachingLoad/wss.php?wsdl", true);
                    // $result = $client->call("Check_Line_Registered", array("lineId" => "U94b9c26beec046b69f2e5c3de8838bd0"));
                    $result = $client->call("Check_Line_Registered", array("lineId" => $userId));
                    $replyData = new TextMessageBuilder("check line id: " . $result);
                    // * if already registered line id show quick replay to: today, thismonth

                    break;
                case "sothapp":
                    $json_text = $flex->gen_flex_soth_url($dataPostback["lineid"]);
                    break;
                case "lineregist":
                    $json_text = $flex->gen_flex_soth_url($dataPostback["lineid"]);
                    break;
                case "lineregist2":
                    $actionBuilder = array(
                        new UriTemplateActionBuilder(
                            'Get SOTH', // ข้อความแสดงในปุ่ม
                            'https://faed.mju.ac.th/soth'
                        ),
                    );
                    $imageUrl = 'https://faed.mju.ac.th/soth/images/soth_banner.png';
                    $replyData = new TemplateMessageBuilder(
                        'Button Template',
                        new ButtonTemplateBuilder(
                            'SOTH Application', // กำหนดหัวเรื่อง
                            'please', // กำหนดรายละเอียด
                            $imageUrl, // กำหนด url รุปภาพ
                            $actionBuilder  // กำหนด action object
                        )
                    );
                    break;
                case "soth":
                    break;
                case "score":
                    break;
                case "match":
                    break;
                case "result":
                    break;
            }
            if ($json_text) {
                // $line->flexMessage($json_text, $userId);

            }
        }

        // if ($is_postback === true) {
        // $line->TextPush("is_postback - " . $content);
        // $line->PushText($event, "text", $content);
        // $line->flexMessage($event, $fnc->gen_flex_json_text(1, $event));
        // $replyData = new TextMessageBuilder($content);
        // switch ($MessageType) {
        //     case 'text':
        //     }


        // $textReplyMessage = "ข้อความจาก Postback Event Data = ";
        // if (is_array($dataPostback)) {
        //     $textReplyMessage .= json_encode($dataPostback);
        // }
        // if (!is_null($paramPostback)) {
        //     $textReplyMessage .= " \r\nParams = " . $paramPostback;
        // }
        // $replyData = new TextMessageBuilder($textReplyMessage);
        // $dataPostback = json_decode($dataPostback, true);
        // $response = $bot->pushMessage("U94b9c26beec046b69f2e5c3de8838bd0", new TextMessageBuilder("debug2:\n"));
        // $response = $bot->pushMessage("U94b9c26beec046b69f2e5c3de8838bd0", new TextMessageBuilder("debug postback:" . $is_Postback . "\n\ndataPostback= " . $dataPostback["action"]));
        // if () {

        // }
        // } else {
        // $response = $bot->pushMessage("U94b9c26beec046b69f2e5c3de8838bd0", new TextMessageBuilder("debug1:\n" . $is_postback));
        // }


    }
}
