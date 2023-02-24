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

class line_action
{
    public function chk($text = "CHK")
    {
        global $response, $bot, $ReplyToken;
        $replyData = new TextMessageBuilder($text);
        $response = $bot->replyMessage($ReplyToken, $replyData);
    }

    public function chk_replydata($replyData)
    {
        global $response, $bot, $ReplyToken;
        $response = $bot->replyMessage($ReplyToken, $replyData);
    }

    public function gen_message_text($MessageType, $MessageText)
    {
        global $response, $bot, $line, $ReplyToken, $events, $eventObj, $SourceUserId;
        if ($MessageType == 'text' && $MessageText != '') {
            if (substr($MessageText, 0, 1) == "*") {
                $result = $this->gen_script_menu($MessageText);
            } elseif ($MessageText != '') {
                // $result = $this->gen_message_action($MessageText);
                if (empty($result)) {
                    $result = $this->gen_message_action_mini_idpa($MessageText);
                }
            }
        } elseif ($MessageType == preg_match('/image|audio|video/', $MessageType) ? true : false) {
            $result = $this->gen_message_media($MessageType, $MessageText);
        }
        // $line->TextPush("gen_message_text : \n" . json_encode($result, JSON_UNESCAPED_UNICODE), "umnarj");
        return $result;
    }

    public function gen_script_menu($MessageText)
    {
        global $response, $bot, $httpClient, $ReplyToken, $replyId, $events, $event, $eventObj, $SourceUserId, $content, $line, $userId, $wss;
        switch (substr($MessageText, 0, 4)) {
            case "*":
                $text = "สวัสดีครับ คำสั่งลัด * มีดังนี้...\n\n";
                $text .= " *reg ลงทะเบียนผู้ใช้งาน.\n";
                $text .= " *it ระบบที่รองรับ.\n";
                $text .= " *chk Check contents.\n";
                $text .= " *uid ดู user id ของคุณ.\n";
                $text .= " *mul ทดลองส่งหลายข้อความ.\n";
                $text .= " *help ช่วยเหลือ.\n";
                // * result repply token , user or group or room
                // $result = array(array("datatype" => "TextMessage", "replyData" => $replyData, "replyId" => $replyId));
                // * result replly to user only
                $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $SourceUserId));
                break;
            case "*reg": // ลงทะเบียน line user id
                $citizenId = trim(substr($MessageText, 4, 18), " ");
                if (empty($citizenId) && strlen($citizenId) != 13) { // ? no citizenId send
                    // todo : check the Line User Id in database
                    $citizenId = "";
                    $citizenId = $wss->call("check_user_register_lineId", array("lineId" => $SourceUserId));
                    if (!empty($citizenId)) {
                        $text = "ท่านได้ลงทะเบียนบัญชี LINE นี้ เรียบร้อยแล้ว";
                    } else {
                        $text = "บัญชี LINE นี้ ยังไม่ได้รับการลงทะเบียนในระบบ SOTH ";
                        $text .= "วิธีการลงทะเบียน พิมพ์..." . "\n\n" . "*reg ตามด้วยหมายเลขบัตร ปชช." . "\n\n" . "จากนั้นกดส่งข้อความครับ.";
                    }

                    $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $SourceUserId));
                } else { // ? have citizenId parameter
                    // todo : update so member with citizenId
                    // $result = array(array("datatype" => "TextMessage", "replyData" => "Try to Line registering.", "replyId" => $SourceUserId));
                    $data = $wss->call("user_register_lineId", array("citizenId" => $citizenId, "lineId" => $SourceUserId));
                    $data = json_decode($data, true);
                    // $line->TextPush("Line Register: " . $data[0] . "\n\n" . $data[1], "umnarj");
                    if ($data[0] == "success") {
                        $line->TextPush("Admin Notify:.\n\n" . "มีการลงทะเบียน Line ID ใหม่\n" . $events['events'][0]['message']['text'] . "\n\n" . $data[1], "test");
                        $result = array(array("datatype" => "TextMessage", "replyData" => "ลงทะเบียนสำเร็จ ขอบคุณที่ลงทะเบียนครับ...", "replyId" => $SourceUserId));
                    } else {
                        $line->TextPush("Admin Notify:.\n\n" . "มีการลงทะเบียน Line ID ไม่สำเร็จ\n" . $events['events'][0]['message']['text'] . "\n\n" . $data[1], "test");
                        // $replyData = new TextMessageBuilder("ลงทะเบียนไม่สำเร็จ โปรดตรวจสอบหมายเลขบัตรประชาชนอีกครั้ง !" . "\n\n" . $data[0]);
                        $result = array(array("datatype" => "TextMessage", "replyData" => "ลงทะเบียนไม่สำเร็จ โปรดตรวจสอบหมายเลขบัตรประชาชนอีกครั้ง !" . "\n\n" . $data[0], "replyId" => $SourceUserId));
                    }
                }
                break;
            case "*chk":
                $line->PushText($event, "text", $content);
                $result = array(array("datatype" => "TextMessage", "replyData" => $content, "replyId" => $replyId));
                break;
            case "*uid":
                $result = array(array("datatype" => "TextMessage", "replyData" => "Your LINE ID:\n\n" . $events['events'][0]['source']['userId'], "replyId" => $SourceUserId));
                break;
                // case "*al ":
                //     $text = "Account link\n";
                //     // $line->AccountLink($event['source']['userId']);
                //     break;
            case "*hel":
                $text = "ยินดีต้อนรับสู่ระบบช่วยเหลือผู้ใช้งาน...";
                $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $replyId));
                break;
            case "*mul": // ! ยังไม่ได้ทำ
                $multiMessage = new MultiMessageBuilder;

                $text = "ยินดีต้อนรับสู่ระบบช่วยเหลือผู้ใช้งาน...";
                $replyData = new TextMessageBuilder($text);
                $multiMessage->add($replyData);

                $picFullSize = 'https://llandscapes-10674.kxcdn.com/wp-content/uploads/2019/07/lighting.jpg';
                $picThumbnail = 'https://llandscapes-10674.kxcdn.com/wp-content/uploads/2019/07/lighting.jpg';
                $imageMessage = new ImageMessageBuilder($picFullSize, $picThumbnail);
                $multiMessage->add($imageMessage);

                $placeName = "ที่ตั้งร้าน";
                $placeAddress = "แขวง พลับพลา เขต วังทองหลาง กรุงเทพมหานคร ประเทศไทย";
                $latitude = 13.780401863217657;
                $longitude = 100.61141967773438;
                $locationMessage = new LocationMessageBuilder($placeName, $placeAddress, $latitude, $longitude);
                $multiMessage->add($locationMessage);

                $replyData = $multiMessage;
                break;
            case "**":
                $text = "สวัสดีครับ สามารถใช้คำสั่งดังนี้...\n";
                $text .= " **al Account link (ปิด)\n";
                $text .= " **t ตัวอย่างการตอบกลับด้วย Text\n";
                $text .= " **i ตัวอย่างการตอบกลับด้วย Image\n";
                $text .= " **v ตัวอย่างการตอบกลับด้วย Video\n";
                $text .= " **a ตัวอย่างการตอบกลับด้วย Audio\n";
                $text .= " **l ตัวอย่างการตอบกลับด้วย Location\n";
                $text .= " **s ตัวอย่างการตอบกลับด้วย Sticker\n";
                $text .= " **im ตัวอย่างการตอบกลับด้วย Image Map Url\n";
                $text .= " **tm Confirm Template\n";
                $text .= " **tb Bottons Template\n";
                $text .= " **tc Carousel Template\n";
                $text .= " **ti image carousel Template\n";
                $text .= " **qr quick reply Template\n";
                // $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $replyId));
                $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $SourceUserId));
                /*
            Template ทั้ง 4 ประเภทนี้จะรองรับ Action Object ที่สามารถส่งค่าการโต้ตอบจากผู้ใช้ด้วยกัน ดังนี้
            Postback action ใช้สำหรับส่งค่าข้อมูล เมื่อผู้ใช้กดเลือกจะเกิด postback event ขึ้น
            Message action ใช้สำหรับกำหนดข้อความตามที่ผู้ใช้เลือก โดยข้อความจะแสดงในฝั่งผู้ใช้
            URI action ใช้สำหรับกำหนดให้ทำการลิ้งค์ไปยัง url ที่ต้องการ คล้ายกับใน imagemap
            Datetime picker action ใช้สำหรับส่งค่าวันที่ เวลา หรือวันที่และเวลาจากผู้ใช้ที่เลือก โดยส่งค่าไปในกับ postback event
            */

                $replyData = new TextMessageBuilder($text);
                break;
                // case "**al":  // เงื่อนไขกรณีต้องการ เชื่อม Line  account กับ ระบบสมาชิกของเว็บไซต์เรา
                //     $response = $httpClient->post("https://api.line.me/v2/bot/user/" . urlencode($userId) . "/linkToken", array());
                //     $result = json_decode($response->getRawBody(), TRUE);
                //     // กำหนด action 4 ปุ่ม 4 ประเภท
                //     $actionBuilder = array(
                //         new UriTemplateActionBuilder(
                //             'Account Link', // ข้อความแสดงในปุ่ม
                //             'https://www.example.com/link.php?linkToken=' . $result['linkToken']
                //         )
                //     );
                //     $imageUrl = ''; //กำหนด url รุปภาพ ถ้ามี
                //     $replyData = new TemplateMessageBuilder(
                //         'Button Template',
                //         new ButtonTemplateBuilder(
                //             'Account Link', // กำหนดหัวเรื่อง
                //             'Please select', // กำหนดรายละเอียด
                //             $imageUrl, // กำหนด url รุปภาพ
                //             $actionBuilder  // กำหนด action object
                //         )
                //     );
                //     break;
            case "**t":
                $text = "Bot ตอบกลับคุณเป็นข้อความ";
                // $replyData = new TextMessageBuilder($textReplyMessage);
                $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $replyId), array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $SourceUserId));
                break;
            case "**i":
                $picFullSize = 'https://idpasoth.com/images/soth_logo.png';
                $picThumbnail = 'https://idpasoth.com/images/favicon.png';
                // $replyData = new ImageMessageBuilder($picFullSize, $picThumbnail);
                $result = array(
                    array("datatype" => "TextMessage", "replyData" => "Bot ตอบกลับคุณเป็นรูปภาพ", "replyId" => $replyId),
                    array("datatype" => "ImageMessage", "replyData" => "", "picFullSize" => $picFullSize, "picThumbnail" => $picThumbnail, "replyId" => $replyId)
                );
                // $result = array(array("datatype" => "TextMessage", "replyData" => "ตัวอย่างตอบกลับด้วยรูปภาพ", "replyId" => $replyId),array("datatype" => "ImageMessage", "picFullSize" => $picFullSize, "picThumbnail" => $picThumbnail, "replyId" => $ReplyToken));
                break;
            case "**v":
                $picThumbnail = 'https://idpasoth.com/images/favicon.png';
                $videoUrl = "https://idpasoth.com/images/sample-mp4-file.mp4";
                // $replyData = new VideoMessageBuilder($videoUrl, $picThumbnail);
                $result = array(
                    array("datatype" => "TextMessage", "replyData" => "Bot ตอบกลับคุณเป็นคลิปวิดีโอ", "replyId" => $replyId),
                    array("datatype" => "VideoMessage", "replyData" => "", "videoUrl" => $videoUrl, "picThumbnail" => $picThumbnail, "replyId" => $replyId)
                );
                break;
            case "**a":
                $audioUrl = "https://idpasoth.com/images/file_example_MP3_1MG.mp3";
                // $replyData = new AudioMessageBuilder($audioUrl, 27000);
                // ? ไฟล์เสียงที่เป็น mp3 หรือ wav หรือ m4a โดยต้องเป็นไฟล์ที่มีขนาดไฟล์ไม่เกิน 10 MB ความยาวไม่เกิน 1 นาที ในขั้นตอนการส่งค่า ต้องกำหนดเวลาของไฟล์นั้นในหน่วย มิลลิวินาทีไปด้วย เช่น 2 วิ ก็จะเป็น 2000 มิลลิวินาที
                $result = array(
                    array("datatype" => "TextMessage", "replyData" => "Bot ตอบกลับคุณเป็นคลิปเสียง", "replyId" => $replyId),
                    array("datatype" => "AudioMessage", "replyData" => "", "audioUrl" => $audioUrl, "audioTime" => 27000, "replyId" => $replyId)
                );
                break;
            case "**l":
                $placeName = "คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้";
                $placeAddress = "63 หมู่ 4 ถนนเชียงใหม่-พร้าว ต.หนองหาร อ.สันทราย จ.เชียงใหม่";
                $latitude = 18.895964933752857;
                $longitude = 99.01520123802179;
                $result = array(
                    array("datatype" => "TextMessage", "replyData" => "Bot ตอบกลับคุณเป็นพิกัดสถานที่", "replyId" => $replyId),
                    array("datatype" => "LocationMessage", "replyData" => "", "placeName" => $placeName, "placeAddress" => $placeAddress, "latitude" => $latitude, "longitude" => $longitude, "replyId" => $replyId)
                );
                break;
            case '**qr': // ! ยังไม่ได้ทำ
                // การใช้งาน postback action
                $postback = new PostbackTemplateActionBuilder(
                    'Postback', // ข้อความแสดงในปุ่ม
                    http_build_query(array(
                        'action' => 'buy',
                        'item' => 100
                    )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                    'Buy'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );
                // การใช้งาน message action
                $txtMsg = new MessageTemplateActionBuilder(
                    'ข้อความภาษาไทย', // ข้อความแสดงในปุ่ม
                    'thai' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );
                // การใช้งาน datetime picker action
                $datetimePicker = new DatetimePickerTemplateActionBuilder(
                    'Datetime Picker', // ข้อความแสดงในปุ่ม
                    http_build_query(array(
                        'action' => 'reservation',
                        'person' => 5
                    )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                    'datetime', // date | time | datetime รูปแบบข้อมูลที่จะส่ง ในที่นี้ใช้ datatime
                    substr_replace(date("Y-m-d H:i"), 'T', 10, 1), // วันที่ เวลา ค่าเริ่มต้นที่ถูกเลือก
                    substr_replace(date("Y-m-d H:i", strtotime("+5 day")), 'T', 10, 1), //วันที่ เวลา มากสุดที่เลือกได้
                    substr_replace(date("Y-m-d H:i"), 'T', 10, 1) //วันที่ เวลา น้อยสุดที่เลือกได้
                );

                // การสร้างปุ่ม quick reply
                $quickReply = new QuickReplyMessageBuilder(
                    array(
                        new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('Location')),
                        new QuickReplyButtonBuilder(new CameraTemplateActionBuilder('Camera')),
                        new QuickReplyButtonBuilder(new CameraRollTemplateActionBuilder('Camera roll')),
                        new QuickReplyButtonBuilder($postback),
                        new QuickReplyButtonBuilder($datetimePicker),
                        new QuickReplyButtonBuilder(
                            $txtMsg,
                            "https://www.ninenik.com/images/ninenik_page_logo.png"
                        ),
                    )
                );
                $textReplyMessage = "ส่งพร้อม quick reply ";
                $replyData = new TextMessageBuilder($textReplyMessage, $quickReply);
                break;
            case "**s":
                // $packageID = 2;
                // $stickerID = 22;
                $packageID = 6325;
                $stickerID = 10979905;
                // $replyData = new StickerMessageBuilder($packageID, $stickerID);
                // ? sticker list : https://developers.line.biz/en/docs/messaging-api/sticker-list/
                $result = array(
                    array("datatype" => "TextMessage", "replyData" => "Bot ตอบกลับคุณเป็นสติกเกอร์", "replyId" => $replyId),
                    array("datatype" => "StickerMessage", "replyData" => "", "packageID" => $packageID, "stickerID" => $stickerID, "replyId" => $replyId)
                );
                break;
            case "**im": // ! ยังไม่ได้ทำ
                $imageMapUrl = 'https://www.mywebsite.com/imgsrc/photos/w/sampleimagemap';
                $replyData = new ImagemapMessageBuilder(
                    $imageMapUrl,
                    'This is Title',
                    new BaseSizeBuilder(699, 1040),
                    array(
                        new ImagemapMessageActionBuilder(
                            'test image map',
                            new AreaBuilder(0, 0, 520, 699)
                        ),
                        new ImagemapUriActionBuilder(
                            'http://www.ninenik.com',
                            new AreaBuilder(520, 0, 520, 699)
                        )
                    )
                );
                break;
            case "**tm": // ! ยังไม่ได้ทำ
                $replyData = new TemplateMessageBuilder(
                    'Confirm Template',
                    new ConfirmTemplateBuilder(
                        'Confirm template builder', // ข้อความแนะนำหรือบอกวิธีการ หรือคำอธิบาย
                        array(
                            new MessageTemplateActionBuilder(
                                'Yes', // ข้อความสำหรับปุ่มแรก
                                'YES'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'No', // ข้อความสำหรับปุ่มแรก
                                'NO' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            )
                        )
                    )
                );
                break;
            case "**tb": // ! ยังไม่ได้ทำ
                // กำหนด action 4 ปุ่ม 4 ประเภท
                $actionBuilder = array(
                    new MessageTemplateActionBuilder(
                        'Message Template', // ข้อความแสดงในปุ่ม
                        'This is Text' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    ),
                    new UriTemplateActionBuilder(
                        'Uri Template', // ข้อความแสดงในปุ่ม
                        'https://www.ninenik.com'
                    ),
                    new DatetimePickerTemplateActionBuilder(
                        'Datetime Picker', // ข้อความแสดงในปุ่ม
                        http_build_query(array(
                            'action' => 'reservation',
                            'person' => 5
                        )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event

                        //แบบ date time
                        // 'datetime', // date | time | datetime รูปแบบข้อมูลที่จะส่ง ในที่นี้ใช้ datatime
                        // substr_replace(date("Y-m-d H:i"), 'T', 10, 1), // วันที่ เวลา ค่าเริ่มต้นที่ถูกเลือก
                        // substr_replace(date("Y-m-d H:i", strtotime("+5 day")), 'T', 10, 1), //วันที่ เวลา มากสุดที่เลือกได้
                        // substr_replace(date("Y-m-d H:i"), 'T', 10, 1) //วันที่ เวลา น้อยสุดที่เลือกได้

                        //แบบ date อย่างเดียว
                        'date', // date | time | datetime รูปแบบข้อมูลที่จะส่ง ในที่นี้ใช้ datatime
                        date("Y-m-d"), // วันที่ เวลา ค่าเริ่มต้นที่ถูกเลือก
                        date("Y-m-d", strtotime("+30 day")), //วันที่ เวลา มากสุดที่เลือกได้
                        date("Y-m-d") //วันที่ เวลา น้อยสุดที่เลือกได้

                        //แบบ time อย่างเดียว
                        // 'time' // date | time | datetime รูปแบบข้อมูลที่จะส่ง ในที่นี้ใช้ datatime
                    ),
                    new PostbackTemplateActionBuilder(
                        'Postback', // ข้อความแสดงในปุ่ม
                        http_build_query(array(
                            'action' => 'buy',
                            'item' => 100
                        )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                        'Postback Text'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    ),
                );
                $imageUrl = 'https://image.dek-d.com/1/content/2015/39003_500x500_1447127218.jpg';
                $replyData = new TemplateMessageBuilder(
                    'Button Template',
                    new ButtonTemplateBuilder(
                        'button template builder', // กำหนดหัวเรื่อง
                        'Please select', // กำหนดรายละเอียด
                        $imageUrl, // กำหนด url รุปภาพ
                        $actionBuilder  // กำหนด action object
                    )
                );
                break;
            case "**tc": // ! ยังไม่ได้ทำ
                // กำหนด action 3 ปุ่ม 3 ประเภท
                $actionBuilder1 = array(
                    new MessageTemplateActionBuilder(
                        'Message Template', // ข้อความแสดงในปุ่ม
                        'This is Text' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    ),
                    new UriTemplateActionBuilder(
                        'Uri Template', // ข้อความแสดงในปุ่ม
                        'https://www.ninenik.com'
                    ),
                    new PostbackTemplateActionBuilder(
                        'Postback', // ข้อความแสดงในปุ่ม
                        http_build_query(array(
                            'action' => 'buy',
                            'item' => 100
                        )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                        'Postback Text'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    ),
                );
                $actionBuilder2 = array(
                    new MessageTemplateActionBuilder(
                        'Message Template2', // ข้อความแสดงในปุ่ม
                        'This is Text' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    ),
                    new UriTemplateActionBuilder(
                        'Uri Template2', // ข้อความแสดงในปุ่ม
                        'https://www.ninenik.com'
                    ),
                    new PostbackTemplateActionBuilder(
                        'Postback2', // ข้อความแสดงในปุ่ม
                        http_build_query(array(
                            'action' => 'buy',
                            'item' => 100
                        )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                        'Postback Text'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    ),
                );
                $actionBuilder3 = array(
                    new MessageTemplateActionBuilder(
                        'Message Template3', // ข้อความแสดงในปุ่ม
                        'This is Text' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    ),
                    new UriTemplateActionBuilder(
                        'Uri Template3', // ข้อความแสดงในปุ่ม
                        'https://www.ninenik.com'
                    ),
                    new PostbackTemplateActionBuilder(
                        'Postback3', // ข้อความแสดงในปุ่ม
                        http_build_query(array(
                            'action' => 'buy',
                            'item' => 100
                        )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                        'Postback Text'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    ),
                );
                $replyData = new TemplateMessageBuilder(
                    'Carousel',
                    new CarouselTemplateBuilder(
                        array(
                            new CarouselColumnTemplateBuilder(
                                'Title Carousel',
                                'Description Carousel',
                                'https://image.dek-d.com/1/content/2015/39003_500x500_1447127218.jpg',
                                $actionBuilder1
                            ),
                            new CarouselColumnTemplateBuilder(
                                'Title Carousel',
                                'Description Carousel',
                                'https://llandscapes-10674.kxcdn.com/wp-content/uploads/2019/07/lighting.jpg',
                                $actionBuilder2
                            ),
                            new CarouselColumnTemplateBuilder(
                                'Title Carousel',
                                'Description Carousel',
                                'https://img.freepik.com/free-vector/beautiful-gradient-spring-landscape_23-2148448598.jpg?size=626&ext=jpg',
                                $actionBuilder3
                            ),
                        )
                    )
                );
                break;
            case "**ti": // ! ยังไม่ได้ทำ
                $replyData = new TemplateMessageBuilder(
                    'Image Carousel',
                    new ImageCarouselTemplateBuilder(
                        array(
                            new ImageCarouselColumnTemplateBuilder(
                                'https://llandscapes-10674.kxcdn.com/wp-content/uploads/2019/07/lighting.jpg',
                                new UriTemplateActionBuilder(
                                    'Uri Template', // ข้อความแสดงในปุ่ม
                                    'https://www.ninenik.com'
                                )
                            ),
                            new ImageCarouselColumnTemplateBuilder(
                                'https://img.freepik.com/free-vector/beautiful-gradient-spring-landscape_23-2148448598.jpg?size=626&ext=jpg',
                                new UriTemplateActionBuilder(
                                    'Uri Template', // ข้อความแสดงในปุ่ม
                                    'https://www.ninenik.com'
                                )
                            )
                        )
                    )
                );
                break;
            case "**pf":
                // เรียกดูข้อมูลโพรไฟล์ของ Line user โดยส่งค่า userID ของผู้ใช้ LINE ไปดึงข้อมูล
                $response = $bot->getProfile($events['events'][0]['source']['userId']);
                if ($response->isSucceeded()) {
                    // ดึงค่ามาแบบเป็น JSON String โดยใช้คำสั่ง getRawBody() กรณีเป้นข้อความ text
                    $text = $response->getRawBody(); // return string            
                    // $replyData = new TextMessageBuilder($textReplyMessage);
                    $result = array(
                        array("datatype" => "TextMessage", "replyData" => "Bot ส่งข้อมูลโปรไฟล์ให้ดู", "replyId" => $replyId),
                        array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $replyId)
                    );
                    break;
                }
                // กรณีไม่สามารถดึงข้อมูลได้ ให้แสดงสถานะ และข้อมูลแจ้ง ถ้าไม่ต้องการแจ้งก็ปิดส่วนนี้ไปก็ได้
                $failMessage = json_encode($response->getHTTPStatus() . ' ' . $response->getRawBody());
                // $replyData = new TextMessageBuilder($failMessage);
                $result = array(
                    array("datatype" => "TextMessage", "replyData" => "Bot อ่านโปรไฟล์ไม่ได้", "replyId" => $replyId),
                    array("datatype" => "TextMessage", "replyData" => $failMessage, "replyId" => $replyId)
                );
                break;
            case "**hi":
                // เรียกดูข้อมูลโพรไฟล์ของ Line user โดยส่งค่า userID ของผู้ใช้ LINE ไปดึงข้อมูล
                $response = $bot->getProfile($events['events'][0]['source']['userId']);
                if ($response->isSucceeded()) {
                    // ดึงค่าโดยแปลจาก JSON String .ให้อยู่ใรูปแบบโครงสร้าง ตัวแปร array 
                    $userData = $response->getJSONDecodedBody(); // return array     
                    // $userData['userId'] " ไอดีของผู้ใช้ LINE "
                    // $userData['displayName']
                    // $userData['pictureUrl']
                    // $userData['statusMessage']
                    // $replyData = new TextMessageBuilder($text);
                    $text = 'สวัสดีครับ คุณ' . "\n" . $userData['displayName'] . "\n\n";
                    $text .= 'textReplyMessageUserID: ' . "\n" . $userData['userId'] . "\n\n";
                    $text .= 'Profile Pic: ' . "\n" . $userData['pictureUrl'] . "\n\n";
                    $text .= 'Status: ' . "\n" . $userData['statusMessage'];
                    // $replyData = new TextMessageBuilder($text);
                    $result = array(
                        array("datatype" => "TextMessage", "replyData" => "Bot ส่งข้อมูลโปรไฟล์ให้ท่าน", "replyId" => $replyId),
                        array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $replyId)
                    );
                    break;
                }
                // กรณีไม่สามารถดึงข้อมูลได้ ให้แสดงสถานะ และข้อมูลแจ้ง ถ้าไม่ต้องการแจ้งก็ปิดส่วนนี้ไปก็ได้
                // $failMessage = json_encode($response->getHTTPStatus() . ' ' . $response->getRawBody());
                // $replyData = new TextMessageBuilder($failMessage);
                break;
            case '**pu': // multi-push messages // ! ใช้ multi-array แทน
                // userId ของผู้ใช้ หลายๆ คน
                $userIds = array(
                    'U39d75c332530aeae3be2661a182e8539',
                    'U0146eb03d721963acc198a4589f6ebb2'
                );
                // ทดสอบส่ง push ข้อความอย่างง่าย
                $textPushMessage = 'สวัสดีครับ';
                $messageData = new TextMessageBuilder($textPushMessage);

                $response = $bot->multicast($userIds, $messageData);
                break;
            case '**fl':
                // $textReplyMessage = new BubbleContainerBuilder(
                //     "ltr",
                //     NULL,
                //     NULL,
                //     new BoxComponentBuilder(
                //         "vertical",
                //         array(
                //             new TextComponentBuilder("hello"),
                //             new TextComponentBuilder("world")
                //         )
                //     )
                // );
                // $replyData = new FlexMessageBuilder("This is a Flex Message", $replyData);
                $flexName = "Sample Flex Message";
                $json_text = '{ "type": "flex", "altText": "SOTH Main Menu", "contents": ';
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
                          "text": "Brown Cafe",
                          "weight": "bold",
                          "size": "xl"
                        },
                        {
                          "type": "box",
                          "layout": "baseline",
                          "margin": "md",
                          "contents": [
                            {
                              "type": "icon",
                              "size": "sm",
                              "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                            },
                            {
                              "type": "icon",
                              "size": "sm",
                              "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                            },
                            {
                              "type": "icon",
                              "size": "sm",
                              "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                            },
                            {
                              "type": "icon",
                              "size": "sm",
                              "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                            },
                            {
                              "type": "icon",
                              "size": "sm",
                              "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gray_star_28.png"
                            },
                            {
                              "type": "text",
                              "text": "4.0",
                              "size": "sm",
                              "color": "#999999",
                              "margin": "md",
                              "flex": 0
                            }
                          ]
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
                                  "text": "Place",
                                  "color": "#aaaaaa",
                                  "size": "sm",
                                  "flex": 1
                                },
                                {
                                  "type": "text",
                                  "text": "Miraina Tower, 4-1-6 Shinjuku, Tokyo",
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
                                  "text": "Time",
                                  "color": "#aaaaaa",
                                  "size": "sm",
                                  "flex": 1
                                },
                                {
                                  "type": "text",
                                  "text": "10:00 - 23:00",
                                  "wrap": true,
                                  "color": "#666666",
                                  "size": "sm",
                                  "flex": 5
                                }
                              ]
                            }
                          ]
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
                            "type": "uri",
                            "label": "WEBSITE",
                            "uri": "https://linecorp.com"
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
                $json_text .= '}';
                $result = array(
                    array("datatype" => "TextMessage", "replyData" => "Bot ตอบกลับคุณเป็น Flex", "replyId" => $replyId),
                    array("datatype" => "json_text", "json_text" => $json_text, "replyId" => $replyId),
                    // array("datatype" => "FlexMessage", "replyData" => $json_text, "flexName" => $flexName, "replyId" => $replyId)
                );
                break;

            default:
                $text = " คุณไม่ได้พิมพ์ คำสั่ง ตามที่กำหนด";
                // $replyData = new TextMessageBuilder($text);
                $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $ReplyToken));
                break;
        }

        if (is_array($result)) {
            return $result;
        } else {
            // return $replyText;
            return array("datatype" => "TextMessage", "replyData" => $replyText);
        }
    }

    public function gen_message_media($MessageType, $MessageText)
    {
        global $response, $bot, $ReplyToken, $events;
        // ** Comments
        //     $response = $bot->getMessageContent($idMessage);
        //     if ($response->isSucceeded()) {
        //         // คำสั่ง getRawBody() ในกรณีนี้ จะได้ข้อมูลส่งกลับมาเป็น binary 
        //         // เราสามารถเอาข้อมูลไปบันทึกเป็นไฟล์ได้
        //         $dataBinary = $response->getRawBody(); // return binary
        //         // ดึงข้อมูลประเภทของไฟล์ จาก header
        //         $fileType = $response->getHeader('Content-Type');
        //         switch ($fileType) {
        //             case (preg_match('/^image/', $fileType) ? true : false):
        //                 list($typeFile, $ext) = explode("/", $fileType);
        //                 $ext = ($ext == 'jpeg' || $ext == 'jpg') ? "jpg" : $ext;
        //                 $fileNameSave = time() . "." . $ext;
        //                 break;
        //             case (preg_match('/^audio/', $fileType) ? true : false):
        //                 list($typeFile, $ext) = explode("/", $fileType);
        //                 $fileNameSave = time() . "." . $ext;
        //                 break;
        //             case (preg_match('/^video/', $fileType) ? true : false):
        //                 list($typeFile, $ext) = explode("/", $fileType);
        //                 $fileNameSave = time() . "." . $ext;
        //                 break;
        //         }
        //         $botDataFolder = 'botdata/'; // โฟลเดอร์หลักที่จะบันทึกไฟล์
        //         $botDataUserFolder = $botDataFolder . $userID; // มีโฟลเดอร์ด้านในเป็น userId อีกขั้น
        //         if (!file_exists($botDataUserFolder)) { // ตรวจสอบถ้ายังไม่มีให้สร้างโฟลเดอร์ userId
        //             mkdir($botDataUserFolder, 0777, true);
        //         }
        //         // กำหนด path ของไฟล์ที่จะบันทึก
        //         $fileFullSavePath = $botDataUserFolder . '/' . $fileNameSave;
        //         file_put_contents($fileFullSavePath, $dataBinary); // ทำการบันทึกไฟล์
        //         $textReplyMessage = "บันทึกไฟล์เรียบร้อยแล้ว $fileNameSave";
        //         $replyData = new TextMessageBuilder($textReplyMessage);
        //         break;
        //     }
        //     $failMessage = json_encode($idMessage . ' ' . $response->getHTTPStatus() . ' ' . $response->getRawBody());
        //     $replyData = new TextMessageBuilder($failMessage);
        //     break;
        // default:
        //     $textReplyMessage = json_encode($events);
        //     $replyData = new TextMessageBuilder($textReplyMessage);
        //     break;

        return null;
    }

    public function gen_message_action($MessageText)
    {
        global $response, $bot, $ReplyToken, $events, $flex, $userId, $replyId;
        // Text Checker
        switch ($MessageText) {
            case 'soth':
                $text = "SOTH สวัสดีครับ";
                $text .= "\n\nท่านสามารถใช้คำสั่งเพื่อเปิดเมนูการใช้งานได้ดังนี้ครับ";
                $text .= "\n\nmenu : ข้อมูลแมทซ์การแข่งขัน";
                $text .= "\n\nso menu : ข้อมูล SO และการจัดการระบบ SOTH";
                $text .= "\n\nหรือเข้าสู่ระบบ SOTH: https://idpasoth.com";
                $replyData = new TextMessageBuilder($text);
                // $json_text = $flex->gen_flex_match_mainmenu($replyId);
                break;
            case 'เมนู':
            case 'menu':
                // $json_text = $flex->gen_flex_global("mainmenu");
                // $json_text = $flex->gen_flex_soth_url("");
                // $replyData = new TextMessageBuilder('get menu');     
                // $line->flexMessage($json_text, $eventObj['source']['userId']);     

                // $flex = new line_flex();
                $json_text = $flex->gen_flex_match_mainmenu($replyId);
                break;
            case 'somenu':
                // $json_text = $flex->gen_flex_global("mainmenu");
                // $json_text = $flex->gen_flex_soth_url("");
                // $replyData = new TextMessageBuilder('get menu');     
                // $line->flexMessage($json_text, $eventObj['source']['userId']);     

                // $flex = new line_flex();
                $json_text = $flex->gen_flex_match_mainmenu($replyId);
                break;
            case 'so menu':
                // $json_text = $flex->gen_flex_global("mainmenu");
                // $json_text = $flex->gen_flex_soth_url("");
                // $replyData = new TextMessageBuilder('get menu');     
                // $line->flexMessage($json_text, $eventObj['source']['userId']);     

                // $flex = new line_flex();
                $result = $flex->gen_flex_so_mainmenu($replyId);
                break;
            case 'shooter menu':
                // $json_text = $flex->gen_flex_global("mainmenu");
                // $json_text = $flex->gen_flex_soth_url("");
                // $replyData = new TextMessageBuilder('get menu');     
                // $line->flexMessage($json_text, $eventObj['source']['userId']);     

                // $flex = new line_flex();
                $json_text = $flex->gen_flex_so_mainmenu($replyId);
                break;
            case 'menu_q':
                // การใช้งาน postback action
                $postback1 = new PostbackTemplateActionBuilder(
                    'SOTH App', // ข้อความแสดงในปุ่ม
                    http_build_query(array(
                        'action' => 'sothapp',
                        'lineid' => $events['events'][0]['source']['userId']
                    )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                    'SOTH App'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );
                $postback2 = new PostbackTemplateActionBuilder(
                    'ลงทะเบียนไลน์', // ข้อความแสดงในปุ่ม
                    http_build_query(array(
                        'action' => 'lineregist',
                        'lineid' => $events['events'][0]['source']['userId']
                    )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                    'ลงทะเบียนไลน์'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );

                // การใช้งาน message action
                $txtMsg1 = new MessageTemplateActionBuilder(
                    'นักกีฬา', // ข้อความแสดงในปุ่ม
                    'shooter' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );
                $txtMsg2 = new MessageTemplateActionBuilder(
                    'ผู้ตัดสิน', // ข้อความแสดงในปุ่ม
                    'so' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );
                $txtMsg3 = new MessageTemplateActionBuilder(
                    'ระบบ SOTH', // ข้อความแสดงในปุ่ม
                    'https://idpasoth.com' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );
                $txtMsg4 = new MessageTemplateActionBuilder(
                    'อื่นๆ', // ข้อความแสดงในปุ่ม
                    'menu2' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );
                // $txtMsg2 = new MessageTemplateActionBuilder(
                //     'กรรมการบันทึกคะแนน', // ข้อความแสดงในปุ่ม
                //     'stat' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                // );
                // $txtMsg2 = new MessageTemplateActionBuilder(
                //     'ผู้จัดแข่งขัน', // ข้อความแสดงในปุ่ม
                //     'md' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                // );
                // $txtMsg2 = new MessageTemplateActionBuilder(
                //     'ผู้ดูแลระบบ', // ข้อความแสดงในปุ่ม
                //     'admin' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                // );
                // การใช้งาน datetime picker action
                // $datetimePicker = new DatetimePickerTemplateActionBuilder(
                //     'Datetime Picker', // ข้อความแสดงในปุ่ม
                //     http_build_query(array(
                //         'action' => 'reservation',
                //         'person' => 5
                //     )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                //     'datetime', // date | time | datetime รูปแบบข้อมูลที่จะส่ง ในที่นี้ใช้ datatime
                //     substr_replace(date("Y-m-d H:i"), 'T', 10, 1), // วันที่ เวลา ค่าเริ่มต้นที่ถูกเลือก
                //     substr_replace(date("Y-m-d H:i", strtotime("+5 day")), 'T', 10, 1), //วันที่ เวลา มากสุดที่เลือกได้
                //     substr_replace(date("Y-m-d H:i"), 'T', 10, 1) //วันที่ เวลา น้อยสุดที่เลือกได้
                // );

                // การสร้างปุ่ม quick reply
                $quickReply = new QuickReplyMessageBuilder(
                    array(
                        // new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('Location')),
                        // new QuickReplyButtonBuilder(new CameraTemplateActionBuilder('Camera')),
                        // new QuickReplyButtonBuilder(new CameraRollTemplateActionBuilder('Camera roll')),
                        // new QuickReplyButtonBuilder($postback),
                        new QuickReplyButtonBuilder($postback1),
                        new QuickReplyButtonBuilder($postback2),
                        new QuickReplyButtonBuilder(
                            $txtMsg1,
                            "https://idpasoth.com/images/soth_logo.png"
                        ),
                        new QuickReplyButtonBuilder(
                            $txtMsg2,
                            "https://idpasoth.com/images/soth_logo.png"
                        ),
                        // new QuickReplyButtonBuilder(
                        //     $txtMsg3,
                        //     "https://idpasoth.com/images/soth_logo.png"
                        // ),
                        new QuickReplyButtonBuilder(
                            $txtMsg4,
                            "https://idpasoth.com/images/soth_logo.png"
                        )
                    )
                );
                $textReplyMessage = "ท่านต้องการใช้งานในฐานะของ ?";
                $replyData = new TextMessageBuilder($textReplyMessage, $quickReply);
                break;
            case 'qr':
                // การใช้งาน postback action
                $postback = new PostbackTemplateActionBuilder(
                    'Postback', // ข้อความแสดงในปุ่ม
                    http_build_query(array(
                        'action' => 'buy',
                        'item' => 100
                    )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                    'Buy'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );
                // การใช้งาน message action
                $txtMsg = new MessageTemplateActionBuilder(
                    'ข้อความภาษาไทย', // ข้อความแสดงในปุ่ม
                    'thai' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                );
                // การใช้งาน datetime picker action
                $datetimePicker = new DatetimePickerTemplateActionBuilder(
                    'Datetime Picker', // ข้อความแสดงในปุ่ม
                    http_build_query(array(
                        'action' => 'reservation',
                        'person' => 5
                    )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                    'datetime', // date | time | datetime รูปแบบข้อมูลที่จะส่ง ในที่นี้ใช้ datatime
                    substr_replace(date("Y-m-d H:i"), 'T', 10, 1), // วันที่ เวลา ค่าเริ่มต้นที่ถูกเลือก
                    substr_replace(date("Y-m-d H:i", strtotime("+5 day")), 'T', 10, 1), //วันที่ เวลา มากสุดที่เลือกได้
                    substr_replace(date("Y-m-d H:i"), 'T', 10, 1) //วันที่ เวลา น้อยสุดที่เลือกได้
                );

                // การสร้างปุ่ม quick reply
                $quickReply = new QuickReplyMessageBuilder(
                    array(
                        new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('Location')),
                        new QuickReplyButtonBuilder(new CameraTemplateActionBuilder('Camera')),
                        new QuickReplyButtonBuilder(new CameraRollTemplateActionBuilder('Camera roll')),
                        new QuickReplyButtonBuilder($postback),
                        new QuickReplyButtonBuilder($datetimePicker),
                        new QuickReplyButtonBuilder(
                            $txtMsg,
                            "https://www.ninenik.com/images/ninenik_page_logo.png"
                        ),
                    )
                );
                $textReplyMessage = "ส่งพร้อม quick reply ";
                $replyData = new TextMessageBuilder($textReplyMessage, $quickReply);
                break;
            case "u":
                $text = "sending message to " . "umnarj";
                $replyData = new TextMessageBuilder($text);
                break;
            case "c":
                $text = "chittong";
                $replyData = new TextMessageBuilder($text);
                break;
                // case "ddm login":
                //     $text = "สามารถเข้าระบบได้จากลิงค์นี้ครับ\n\n";
                //     $text .= "https://faed.mju.ac.th/it/dean-dm/signin/";
                //     $replyData = new TextMessageBuilder($text);
                //     break;
                // case "oqes":
                //     $text = "สามารถเข้าระบบได้จากลิงค์นี้ครับ\n\n";
                //     $text .= "https://faed.mju.ac.th/it/oqes_report";
                //     $replyData = new TextMessageBuilder($text);
                //     break;
            default:
        }

        if (!is_array($result)) {
            if (is_array($json_text)) {
                // !
                $result = array("datatype" => "json_text", "json_text" => $json_text["json_text"], "replyId" => $json_text["replyId"]);
            } elseif (is_array($replyData)) {
                // !
                $result = array("datatype" => "replydata", "replyData" => $replyData["replyData"], "replyId" => $replyData["replyId"]);
            } else {
                if (!empty($json_text)) {
                    $result = array("datatype" => "json_text", "json_text" => $json_text, "replyId" => $replyId);
                } elseif (!empty($replyData)) {
                    $result = array("datatype" => "replydata", "replyData" => $replyData, "replyId" => $ReplyToken);
                }
            }
        }

        // $result = $json_text + $replyData;
        // $result = $json_text;
        // $result = array("json_text" => $json_text);
        // return array("json_text" => $json_text);
        return $result;
    }

    public function gen_message_action_mini_idpa($MessageText)
    {
        global $response, $bot, $ReplyToken, $events, $flex, $userId, $replyId;
        // Text Checker
        switch ($MessageText) {
            case 'idpa':
                // go flex
                return $flex->gen_flex_mini_idpa_info();
                // $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $ReplyToken));
                break;
            case 'cof1':
                $text = 'Stage 1: 8+8
    ประกอบด้วย 5 เป้ากระดาษ, 2 เพลท, 2 ป๊อปเปอร์ ใช้กระสุนอย่างน้อย 14 นัด สวมเสื้อคลุม คอนดิชั่น 3

    1. วางปืน และแม๊กกาซีน 1 ตัว บทโต๊ะในกรอบที่กำหนด
    2. นั่งตำแหน่งเริ่มต้น หลังพิง ส้นเท้าสองข้างแตะขาเก้าอี้ เริ่มยิงเมื่อได้ยินเสียงสัญญาณ
    3. ทำลายเป้าหมายตามลำดับความสำคัญ ใกล้-ไกล และสไลด์พาย
    * ทิ้งแม๊กเปล่าเมื่อรังเพลิงไม่มีกระสุนบรรจุอยู่เท่านั้น, ห้ามสัมผัสพื้นนอกแนวไม้ Fault Line, ไม้ Fault Line ยาวสุดสายตา';
    $picFullSize = 'https://idpasoth.com/images/COF_STG1.jpg';
                $picThumbnail = 'https://idpasoth.com/images/STG1_Plan.jpg';
                $result = array(
                    array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $ReplyToken),
                    array("datatype" => "ImageMessage", "replyData" => "", "picFullSize" => $picFullSize, "picThumbnail" => $picThumbnail, "replyId" => $replyId)
                );
                // $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $ReplyToken));
            break;
            case 'cof2':
                $text = 'Stage 1: 10+10
    ประกอบด้วย 6 เป้ากระดาษ, 5 เพลท, 1 ป๊อปเปอร์ ใช้กระสุนอย่างน้อย 18 นัด สวมเสื้อคลุม คอนดิชั่น 2

    1. ยืนตำแหน่งเริ่มต้น สองมือสัมผัสจุดที่กำหนด เริ่มยิงเมื่อได้ยินเสียงสัญญาณ
    2. ทำลายเป้ากระดาษที่มองเห็น ตามลำดับความสำคัญ ใกล้-ไกล และสไลด์พาย
    3. เพลทเหล็กและป๊อปเปอร์สามารถยิง จากแหน่ง VB ได้
    * ทิ้งแม๊กเปล่าเมื่อรังเพลิงไม่มีกระสุนบรรจุอยู่เท่านั้น, ห้ามสัมผัสพื้นนอกแนวไม้ Fault Line, ไม้ Fault Line ยาวสุดสายตา';
    $picFullSize = 'https://idpasoth.com/images/COF_STG2.jpg';
                $picThumbnail = 'https://idpasoth.com/images/STG2_Plan.jpg';
                $result = array(
                    array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $ReplyToken),
                    array("datatype" => "ImageMessage", "replyData" => "", "picFullSize" => $picFullSize, "picThumbnail" => $picThumbnail, "replyId" => $replyId)
                );
                // $result = array(array("datatype" => "TextMessage", "replyData" => $text, "replyId" => $ReplyToken));
            break;
        }
        return $result;
    }
}
