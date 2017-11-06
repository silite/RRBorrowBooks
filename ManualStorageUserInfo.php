<?php
include_once __DIR__.'/../Class/GetUserInfo.php';
include_once __DIR__.'/ChangeUserInfoStatus.php';
$open_id = 'o2urFwoHgD4X2nY_Hq3SUerzWwEc';
$user_info = (new GetUserInfo($open_id))->Get();
if (0 == $user_info['subscribe']) {
    exit("用户已取关");
}
if (array_key_exists("errcode" , $user_info)) {
    var_dump($user_info);
    exit('获取用户信息出错');
}
var_dump($user_info);
$res = Subscribe($user_info);
if (!$res) {
    var_dump($res);
    exit('写入数据库出错');
}
exit($open_id.'   OK !');
