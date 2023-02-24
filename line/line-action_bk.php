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


function chk($text = "CHK")
{
    global $response, $bot, $ReplyToken;
    $replyData = new TextMessageBuilder($text);
    $response = $bot->replyMessage($ReplyToken, $replyData);
}

function chk_replydata($replyData)
{
    global $response, $bot, $ReplyToken;
    $response = $bot->replyMessage($ReplyToken, $replyData);
}

if (!is_null($is_message)) {
    $line = new linecore();
    switch ($MessageType) {
        case 'text':
            if (substr($MessageText, 0, 1) == "*") {
                switch (substr($MessageText, 0, 4)) {
                    case "*":
                        $text = "สวัสดีครับ คำสั่งลัด * มีดังนี้...\n";
                        $text .= " *reg ลงทะเบียนผู้ใช้งาน ตามด้วยหมายเลขบัตร ปชช.\n";
                        $text .= " *it ระบบสารสนเทศที่รองรับ\n";
                        $text .= " *sql แสดง SQL\n";
                        $text .= " *chk Check contents\n";
                        $text .= " *uid user id ของคุณ\n";
                        $text .= " *mul ทดลองส่งหลายข้อความ\n";
                        $text .= " *้help ช่วยเหลือ\n";
                        $replyData = new TextMessageBuilder($text);
                        // $line->PushText($event, "text", $text);
                        // $response = $bot->replyMessage($replyToken, $replyData);
                        break;
                    case "*reg": // ลงทะเบียน line user id
                        $citizenId = trim(substr($MessageText, 4, 18), " ");
                        if (!empty($citizenId) && strlen($citizenId) == 13) {
                            $lineId = $events['events'][0]['source']['userId'];
                            // require_once("lib/nusoap.php");
                            $client = new nusoap_client("https://faed.mju.ac.th/soth/line/wss.php?wsdl", true);
                            $data = $client->call("user_register_lineId", array("citizenId" => $citizenId, "lineId" => $lineId));
                            $data = json_decode($data, true);

                            $replyData = new TextMessageBuilder("Admin Notify MSG.\n\n" . "มีการลงทะเบียน Line ID ใหม่\n" . $events['events'][0]['message']['text'] . "\n\n" . $data[1]);
                            // $response = $bot->pushMessage($line->line_userid["umnarj"], $replyData);                        
                            $response = $bot->pushMessage($line->line_userid["test"], $replyData);
                            if ($data[0] == "success") {
                                $replyData = new TextMessageBuilder("ลงทะเบียนสำเร็จ ขอบคุณที่ลงทะเบียนครับ...");
                            } else {
                                $replyData = new TextMessageBuilder("ลงทะเบียนไม่สำเร็จ โปรดตรวจสอบหมายเลขบัตรประชาชนอีกครั้ง !" . "\n\n" . $data[0]);
                            }
                        } else {
                            $replyData = new TextMessageBuilder("วิธีการลงทะเบียน พิมพ์..." . "\n\n" . "*reg ตามด้วยหมายเลขบัตร ปชช." . "\n\n" . "จากนั้นกดส่งข้อความครับ");
                        }
                        break;
                    case "*sql":
                        // $line->PushText($event, "text", "sql: " . $sql);
                        $replyData = new TextMessageBuilder("sql: " . $sql);
                        break;
                    case "*chk":
                        $line->PushText($event, "text", $content);
                        // $line->flexMessage($event, $fnc->gen_flex_json_text(1, $event));
                        $replyData = new TextMessageBuilder($content);
                        break;
                    case "*uid":
                        $replyData = new TextMessageBuilder("your id: " . $events['events'][0]['source']['userId']);
                        break;
                    case "*al ":
                        $text = "Account link\n";
                        // $line->AccountLink($event['source']['userId']);
                        break;
                    case "*hel":
                        $text = "ยินดีต้อนรับสู่ระบบช่วยเหลือผู้ใช้งาน...";
                        $replyData = new TextMessageBuilder($text);
                        break;
                    case "*mul":
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
                        $text .= " **al Account link\n";
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
                        /*
                        Template ทั้ง 4 ประเภทนี้จะรองรับ Action Object ที่สามารถส่งค่าการโต้ตอบจากผู้ใช้ด้วยกัน ดังนี้
                        Postback action ใช้สำหรับส่งค่าข้อมูล เมื่อผู้ใช้กดเลือกจะเกิด postback event ขึ้น
                        Message action ใช้สำหรับกำหนดข้อความตามที่ผู้ใช้เลือก โดยข้อความจะแสดงในฝั่งผู้ใช้
                        URI action ใช้สำหรับกำหนดให้ทำการลิ้งค์ไปยัง url ที่ต้องการ คล้ายกับใน imagemap
                        Datetime picker action ใช้สำหรับส่งค่าวันที่ เวลา หรือวันที่และเวลาจากผู้ใช้ที่เลือก โดยส่งค่าไปในกับ postback event
                        */

                        $replyData = new TextMessageBuilder($text);
                        break;
                    case "**al":  // เงื่อนไขกรณีต้องการ เชื่อม Line  account กับ ระบบสมาชิกของเว็บไซต์เรา
                        $response = $httpClient->post("https://api.line.me/v2/bot/user/" . urlencode($userId) . "/linkToken", array());
                        $result = json_decode($response->getRawBody(), TRUE);
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                        $actionBuilder = array(
                            new UriTemplateActionBuilder(
                                'Account Link', // ข้อความแสดงในปุ่ม
                                'https://www.example.com/link.php?linkToken=' . $result['linkToken']
                            )
                        );
                        $imageUrl = ''; //กำหนด url รุปภาพ ถ้ามี
                        $replyData = new TemplateMessageBuilder(
                            'Button Template',
                            new ButtonTemplateBuilder(
                                'Account Link', // กำหนดหัวเรื่อง
                                'Please select', // กำหนดรายละเอียด
                                $imageUrl, // กำหนด url รุปภาพ
                                $actionBuilder  // กำหนด action object
                            )
                        );
                        break;
                    case "**t":
                        $textReplyMessage = "Bot ตอบกลับคุณเป็นข้อความ";
                        $replyData = new TextMessageBuilder($textReplyMessage);
                        break;
                    case "**i":
                        $picFullSize = 'https://www.mywebsite.com/imgsrc/photos/f/simpleflower';
                        $picThumbnail = 'https://www.mywebsite.com/imgsrc/photos/f/simpleflower/240';
                        $replyData = new ImageMessageBuilder($picFullSize, $picThumbnail);
                        break;
                    case "**v":
                        $picThumbnail = 'https://www.mywebsite.com/imgsrc/photos/f/sampleimage/240';
                        $videoUrl = "https://www.mywebsite.com/simplevideo.mp4";
                        $replyData = new VideoMessageBuilder($videoUrl, $picThumbnail);
                        break;
                    case "**a":
                        $audioUrl = "https://www.mywebsite.com/simpleaudio.mp3";
                        $replyData = new AudioMessageBuilder($audioUrl, 27000);
                        break;
                    case "**l":
                        $data = '{
                                "type": "location",
                                "title": "คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้",
                                "address": "63 หมู่ 4 ถนนเชียงใหม่-พร้าว ต.หนองหาร อ.สันทราย จ.เชียงใหม่",
                                "latitude": 18.895964933752857,
                                "longitude": 99.01520123802179
                              }';
                        if (!is_array($data)) {
                            $data = json_decode($data, true);
                        }
                        $replyData = new LINE\LINEBot\MessageBuilder\LocationMessageBuilder($data["title"], $data["address"], $data["latitude"], $data["longitude"]);
                        break;
                    case "**qr":
                        $postback = new PostbackTemplateActionBuilder(
                            'Postback', // ข้อความแสดงในปุ่ม
                            http_build_query(array(
                                'action' => 'buy',
                                'item' => 100
                            )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                            'Buy'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                        );
                        $txtMsg = new MessageTemplateActionBuilder(
                            'ข้อความภาษาไทย', // ข้อความแสดงในปุ่ม
                            'thai' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                        );
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
                        $replyData = new TextMessageBuilder($textReplyMessage);
                        break;
                    case "**s":
                        $stickerID = 22;
                        $packageID = 2;
                        $replyData = new StickerMessageBuilder($packageID, $stickerID);
                        break;
                    case "**im":
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
                    case "**tm":
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
                    case "**tb":
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
                    case "**tc":
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
                    case "**ti":
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
                            $textReplyMessage = $response->getRawBody(); // return string            
                            $replyData = new TextMessageBuilder($textReplyMessage);
                            break;
                        }
                        // กรณีไม่สามารถดึงข้อมูลได้ ให้แสดงสถานะ และข้อมูลแจ้ง ถ้าไม่ต้องการแจ้งก็ปิดส่วนนี้ไปก็ได้
                        $failMessage = json_encode($response->getHTTPStatus() . ' ' . $response->getRawBody());
                        $replyData = new TextMessageBuilder($failMessage);
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
                            $replyData = new TextMessageBuilder($text);
                            $text = 'สวัสดีครับ คุณ' . "\n" . $userData['displayName'] . "\n\n";
                            $text .= 'textReplyMessageUserID: ' . "\n" . $userData['userId'] . "\n\n";
                            $text .= 'Profile Pic: ' . "\n" . $userData['pictureUrl'] . "\n\n";
                            $text .= 'Status: ' . "\n" . $userData['statusMessage'];
                            $replyData = new TextMessageBuilder($text);
                            break;
                        }
                        // กรณีไม่สามารถดึงข้อมูลได้ ให้แสดงสถานะ และข้อมูลแจ้ง ถ้าไม่ต้องการแจ้งก็ปิดส่วนนี้ไปก็ได้
                        // $failMessage = json_encode($response->getHTTPStatus() . ' ' . $response->getRawBody());
                        // $replyData = new TextMessageBuilder($failMessage);
                        break;
                    case '**pu':
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
                        // $replyData = new FlexMessageBuilder("This is a Flex Message", $textReplyMessage);
                        break;

                    default:
                        $textReplyMessage = " คุณไม่ได้พิมพ์ คำสั่ง ตามที่กำหนด";
                        $replyData = new TextMessageBuilder($textReplyMessage);
                        break;
                }
            } else {
                // Text Checker
                switch ($MessageText) {
                    case 'menu':                        
                        $flex = new line_flex();
                        $json_text = $flex->gen_flix_soth_mainmenu();
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
                            'https://faed.mju.ac.th/soth' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
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
                                    "https://faed.mju.ac.th/soth/images/soth_logo.png"
                                ),
                                new QuickReplyButtonBuilder(
                                    $txtMsg2,
                                    "https://faed.mju.ac.th/soth/images/soth_logo.png"
                                ),
                                // new QuickReplyButtonBuilder(
                                //     $txtMsg3,
                                //     "https://faed.mju.ac.th/soth/images/soth_logo.png"
                                // ),
                                new QuickReplyButtonBuilder(
                                    $txtMsg4,
                                    "https://faed.mju.ac.th/soth/images/soth_logo.png"
                                )
                            )
                        );
                        $textReplyMessage = "ท่านต้องการใช้งานในฐานะของ ?";
                        $replyData = new TextMessageBuilder($textReplyMessage, $quickReply);
                        break;
                    case 'mul':
                        $textReplyMessage = "Bot ตอบกลับคุณเป็นชุดข้อความ";
                        $textMessage = new TextMessageBuilder($textReplyMessage);

                        $picFullSize = 'https://faed.mju.ac.th/soth/images/soth_logo.png';
                        $picThumbnail = 'https://faed.mju.ac.th/soth/images/soth_logo.png';
                        $imageMessage = new ImageMessageBuilder($picFullSize, $picThumbnail);

                        $placeName = "ที่ตั้งร้าน";
                        $placeAddress = "แขวง พลับพลา เขต วังทองหลาง กรุงเทพมหานคร ประเทศไทย";
                        $latitude = 13.780401863217657;
                        $longitude = 100.61141967773438;
                        $locationMessage = new LocationMessageBuilder($placeName, $placeAddress, $latitude, $longitude);

                        $multiMessage = new MultiMessageBuilder;
                        $multiMessage->add($textMessage);
                        $multiMessage->add($imageMessage);
                        $multiMessage->add($locationMessage);
                        $replyData = $multiMessage;
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
                    case "login":
                        $text = "สามารถเข้าระบบได้จากลิงค์นี้ครับ\n\n";
                        $text .= "https://faed.mju.ac.th/it/dean-dm/signin/";
                        $replyData = new TextMessageBuilder($text);
                        break;
                    case "oqes":
                        $text = "สามารถเข้าระบบได้จากลิงค์นี้ครับ\n\n";
                        $text .= "https://faed.mju.ac.th/it/oqes_report";
                        $replyData = new TextMessageBuilder($text);
                        break;
                        // case "สายตรงคณบดี":
                        //     $json_text = $fnc->gen_flex_message_dean_dm("ระบบสายตรงคณบดี");
                        //     $line->flexMessage($json_text, $events['events'][0]['source']['userId']);
                        //     break;
                    default:
                        $text = "ที่ถามมายังตอบไม่ได้นะคะ กำลังสอนน้องบอทอยู่ครับ";
                        // $replyData = new TextMessageBuilder($text);

                        // $text = "เบื้องต้น สามารถตอบคำถามดังนี้ครับ\n\n";
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
            break;
        case (preg_match('/image|audio|video/', $MessageType) ? true : false): // error " 405 {\"message\":\"The request method, 'GET', is not supported\"}"
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
    }
}