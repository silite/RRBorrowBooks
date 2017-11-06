<?php


/*
File: ChangeHeadImage.php
Desc: Save header image user changed
Auth: ws , lyd
Date: 2017-08-02
=============================
Change History
1,lyd,2017-08-17,save image with type
=============================
*/


include_once __DIR__.'/../Class/MyLog.php';
include_once __DIR__.'/../Class/GetAccessToken.php';


if (empty($open_id = $_POST['openId']) || empty($server_id = $_POST['serverId'])) {
    $log = new MyLog();
    $log->Log(3 , 'no open id or server id , openid : '.$open_id.'  server id : '.$server_id);
    exit;
}
$get_old_header_image = 'ls '.__DIR__.'/../Media/UserHeadImg/ | grep '.$open_id.'.*';
$old_header_image = `$get_old_header_image`;
$delete_old_header_image = 'rm -rf '.__DIR__.'/../Media/UserHeadImg/'.$old_header_image;
`$delete_old_header_image`;
$source_image = file_get_contents('https://api.weixin.qq.com/cgi-bin/media/get?access_token='.((new GetAccessToken())->Get()).'&media_id='.$server_id);
file_put_contents(__DIR__.'/../Media/UserHeadImg/'.$open_id , $source_image);
list($width, $height, $type, $attr) = getimagesize(__DIR__.'/../Media/UserHeadImg/'.$open_id);
unlink(__DIR__.'/../Media/UserHeadImg/'.$open_id);
$type = substr(image_type_to_extension($type) , 1);
file_put_contents(__DIR__.'/../Media/UserHeadImg/'.$open_id.'.'.$type , $source_image);
