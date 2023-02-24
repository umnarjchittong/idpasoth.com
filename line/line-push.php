<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require __DIR__ . '../vendor/autoload.php';

require_once("core-engine.php");
$line = new linecore();


// require_once("line-flex.php");
// $flex = new line_flex();

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


// เชื่อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient($line->line_setting["ChannelAccessToken"]);
$bot = new LINEBot($httpClient, array('channelSecret' => $line->line_setting["ChannelSecret"]));

if (isset($_GET['fst']) && $_GET['fst'] == 'linepush' && isset($_GET['line_message']) && isset($_GET['lineid'])) {
  $line->TextPush($_GET['line_message'], $_GET['lineid']);
  // echo "sent..";
  echo '<meta http-equiv="refresh" content="0 ;url=../admin/?p=soinfo&soid=' . $_GET['soid'] . '&alert=success&title=Line Sent Completed&msg=ส่งข้อความไลน์เรียบร้อยแล้ว.">';
  die();
}
if (isset($_GET['fst']) && $_GET['fst'] == 'linenotify') {
  session_start();
  // echo '<pre>' . print_r($_SESSION["linepush"]) . '</pre>';
  if (is_array($_SESSION["linepush"]["lineid"])) {
     foreach ($_SESSION["linepush"]["lineid"] as $lindId) {
       $line->TextPush($_SESSION["linepush"]["line_msg"], $lindId);
     }
  } else {
  $line->TextPush($_SESSION["linepush"]["line_msg"], $_SESSION["linepush"]["lineid"]);
  }
  echo '<script type="text/javascript">';
  echo 'window.close();';
  echo '</script>';
  die();
}

?>

<script type="text/javascript">
  // window.close();
  window.location('../admin/?p=soinfo&soid=50');
</script>