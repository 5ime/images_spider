
<?php 
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json');
ini_set('display_errors','off');
error_reporting(E_ALL || ~E_NOTICE);
require 'src/images_spider.php';
$url = $_REQUEST['url'];
use Images_spider\Images;
$api = new Images;
if (strpos($url,'weibo') !== false){
    $arr = $api->weibo($url);
} elseif (strpos($url, 'kuaishou') !== false){
    $arr = $api->kuaishou($url);
} elseif (strpos($url, 'pipix') !== false){
    $arr = $api->pipixia($url);
} elseif (strpos($url, 'izuiyou') !== false){
    $arr = $api->zuiyou($url);
} elseif (strpos($url, 'xhslink') !== false){
    $arr = $api->xhs($url);
} elseif (strpos($url, 'douyin') !== false){
    $arr = $api->douyin($url);
}  else {
    $arr = array(
        'code'  => 201,
        'msg' => '不支持您输入的链接'
    );
}
if (!empty($arr)){
    echo json_encode($arr, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
else{
    $arr = array(
        'code' => 201,
        'msg' => '解析失败',
    );
    echo json_encode($arr, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}


